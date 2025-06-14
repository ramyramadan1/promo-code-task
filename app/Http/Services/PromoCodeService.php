<?php

namespace App\Http\Services;

use App\Models\PromoCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PromoCodeService
{

    /**
     * create New Array
     * @param type $params
     */
    public function create($params){
        $params->code = (isset($params->code) && !empty($params->code))?$params->code: $this->generateCode($params) ;
        $promoCode = PromoCode::create(
                [
                'code' => $params->code, 
                'status' => 'active', 
                'expiry_date' => $params->expiry_date??null, 
                'max_usage' => $params->max_usage??null,
                'usage_times' => 0,
                'promo_type' => 'percentage', 
                'value' => $params->value,
            ]
        );
        if(isset($params->user_ids) && !empty($params->user_ids)){
            foreach($params->user_ids as $userId){
                     $promoCode->promoCodeUser()->create(
                             [
                                'user_id'=>$userId,
                                'usage_time_per_user'=>$params->usage_time_per_user,
                                 'max_usage_per_user'=>$params->max_usage_per_user
                             ]
                     );   
            }

        }
        return $params->code;
    }
    
    /**
     * generate unique promo code
     * @param type $params
     * @return type
     */
    public function generateCode($params) {
         do {
            $code = Str::upper(Str::random(5));
        } while (PromoCode::where('code', $code)->exists());
        //forget cache 
        Cache::forget('promo_codes');
        return $code;
    }
    
    
    /**
     * Make promo code expired
     * @param type $id
     */
    public function expirePromoCode($id) {
            $promo = PromoCode::findOrFail($id);
            $promo->update(['status'=>'expired']);
    }
    
    /**
     * redeem code and return result 
     * @param type $params
     */
    public function redeemCode($params){
        $result = [];
        $promo = PromoCode::with('users')->where('code', $params->code)->first();
        //check if it is assigned to this user 
        if(in_array(Auth::user()->id,$promo->users->pluck('id')->toArray())){
            $promo->promoCodeUser->where('user_id',Auth::user()->id)->first()->increment('usage_time_per_user');
            if(!is_null($promo->max_usage)){
                $promo->increment('usage_times');
            }
        }else{
            $promo->increment('usage_times');
        }
        
        if(!is_null($promo->max_usage) && ($promo->usage_times >= $promo->max_usage)){
            $promo->status=  PromoCode::$STATUS_EXPIRED;
            $promo->save();
        }
        $result['price'] = (float)$params->price;
        switch ($promo->promo_type){
            case 'percentage':
                $result['promocode_discounted_amount'] = (($params->price * $promo->value) / 100);
                $result['price_after_discount'] = $params->price - (($params->price * $promo->value) / 100);
            break;
            
            case 'value':
                    $result['promocode_discounted_amount'] = $promo->value;
                    $result['price_after_discount'] = $params->price - $promo->value ;
            break;
                $result['promocode_discounted_amount'] =0;
                $result['price_after_discount'] = $params->price; 
            default:
                
        }
        Cache::forget('promo_codes');
        return $result;
    }
}
