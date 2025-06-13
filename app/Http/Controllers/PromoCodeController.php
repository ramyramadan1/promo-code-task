<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GeneratePromoCodeRequest;
use App\Http\Requests\CheckPromoCodeRequest;
use App\Http\Services\PromoCodeService;

class PromoCodeController extends Controller
{
    protected PromoCodeService $promoCodeService;
 
    public function __construct(PromoCodeService $promoCodeService) {
        $this->promoCodeService = $promoCodeService;
    }
    /**
     * Generate new Promo code
     * @param GeneratePromoCodeRequest $request
     */
    public function generate(GeneratePromoCodeRequest $request) {
        $result = $this->promoCodeService->create($request);
        return response()->json(['message'=>'Promo code created successfully !','promo_code'=>$result]);
    }
    
    /**
     * Check on promo code if valid
     * @param CheckPromoCodeRequest $request
     */
    public function redeem(CheckPromoCodeRequest $request) {
        $result = $this->promoCodeService->redeemCode($request);
        return response()->json(['message' => 'Promo code  is valid','result'=> $result]);
    }
    
    
    public function destroy($id)
    {
        $this->promoCodeService->expirePromoCode($id);
        return response()->json(['message' => 'Promo code Deleted successfully']);
    }
}
