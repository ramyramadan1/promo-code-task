<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PromoCodeController;

Route::prefix('v1')->group(function () {
         Route::post('/authenticate', [UserController::class, 'authenticate'])->name('authenticate');
   
         Route::group(['middleware'=>'auth:api'],function () {
            Route::post('/promo-code/generate', [PromoCodeController::class, 'generate'])->name('promocode.generate');    
            Route::post('/promo-code/redeem', [PromoCodeController::class, 'redeem'])->name('promocode.redeem');
         });
});