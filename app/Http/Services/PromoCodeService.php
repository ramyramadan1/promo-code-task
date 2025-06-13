<?php

namespace App\Http\Services;

use App\Models\PromoCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PromoCodeService
{

    /**
     * create New Array
     * @param type $params
     */
    public function create($params){
        $params->code = (isset($params->code) && !empty($params->code))?$params->code: $this->generateCode($params) ;
        PromoCode::create(
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
        }else{
            $promo->increment('usage_times');
        }
        $result['price'] = $params->price;
        switch ($promo->type){
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
        return $result;
    }
}
