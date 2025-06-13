<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    
    
    static $STATUS_EXPIRED = 'expired';
    static $STATUS_ACTIVE = 'active';
    
    protected  $fillable =[ 'code', 'expiry_date', 'max_usage','type','value'];
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
    public function promoCodeUser()
    {
        return $this->hasMany(PromoCodeUser::class);
    }
    
    
    
    
}
