<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PromoCode;

class PromoCodeService
{

    /**
     * create New Array
     * @param type $params
     */
    public function create($params){
        $params->code = (isset($params->code) && !empty($params->code))?$params->code: $this->generateNew($params) ;
        PromoCode::create(
                [
                'code' => $params->code, 
                'status' => 'active', 
                'expiry_date' => $params->expiry_date??null, 
                'max_usage' => 100,
                'usage_times' => 0,
                'promo_type' => 'percentage', // or 'value'
                'value' => 15.5,
            ]
        );
        
    }
    
    /**
     * generate unique promo code
     * @param type $params
     * @return type
     */
    public function generateNew($params) {
         do {
            $code = Str::upper(Str::random(5));
        } while (Promo::where('code', $code)->exists());
        return $code;
    }
}
