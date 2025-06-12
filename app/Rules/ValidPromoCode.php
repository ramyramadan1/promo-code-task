<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\PromoCode;

class ValidPromoCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $promo = PromoCode::with('users')->where('promo_code', $value)->first();
        if (! $promo) {
            $fail('Promo code does not exist.');
            return;
        }
        if (($promo->expiry_date && now()->gt($promo->expiry_date)) || $promo->status == PromoCode::$STATUS_EXPIRED) {
            $fail('Promo code has expired.');
        }
    }
    
   
}
