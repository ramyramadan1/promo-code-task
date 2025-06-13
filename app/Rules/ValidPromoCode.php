<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\PromoCode;
use \Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ValidPromoCode implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $promo = PromoCode::with('users')->where('code', $value)->first();
        //check if not exists
        if (! $promo) {
            $fail('Promo code does not exist.');
            return;
        }
        if($promo && !is_null($promo->expiry_date) && today()->gt($promo->expiry_date) ){
            $fail('This promo code has been expired due to its expiry date');
            return;
        }
        
        if($promo && (!empty($promo->users) && in_array(Auth::user()->id,$promo->promoCodeUser->pluck('user_id')->toArray()) 
                && ($promo->promoCodeUser->where('user_id',Auth::user()->id)->first()->usage_time_per_user >= $promo->promoCodeUser->where('user_id',Auth::user()->id)->first()->max_usage_per_user))){
            $fail('This promo code has been expired , Exceeded Number of usage for this user');
            return;
        }
        
        if($promo  && ($promo->usage_times >= $promo->max_usage)){
            $fail('This promo code has been expired , Exceeded Number of general usage ');
            return;
        }
        
        if($promo && $promo->status != PromoCode::$STATUS_ACTIVE){
            $fail('This promo code is not active');
            return;
        }
    }
    
   
}
