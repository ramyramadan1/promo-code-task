<?php

namespace App\Http\Services;

use App\Models\PromoCode;
use Illuminate\Support\Str;

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
}
