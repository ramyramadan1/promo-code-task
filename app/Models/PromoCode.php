<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    static $STATUS_EXPIRED = 'expired';
    static $STATUS_ACTIVE = 'expired';
    
    protected  $fillable =[ 'code', 'expiry_date', 'max_usage','type'];
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
