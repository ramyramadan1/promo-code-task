<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GeneratePromoCodeRequest;
use App\Http\Requests\CheckPromoCodeRequest;

class PromoCode extends Controller
{
 
    /**
     * Generate new Promo code
     * @param GeneratePromoCodeRequest $request
     */
    public function generate(GeneratePromoCodeRequest $request) {
        
    }
    
    /**
     * Check on promo code if valid
     * @param CheckPromoCodeRequest $request
     */
    public function check(CheckPromoCodeRequest $request) {
        
    }
    
    private function validate($param) {
        
    }
}
