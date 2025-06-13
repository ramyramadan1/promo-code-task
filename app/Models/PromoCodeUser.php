<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCodeUser extends Model
{
    public $timestamps =false;
    
    protected $table='promo_code_user';
    
    protected  $fillable =[ 'promo_code_id', 'user_id', 'max_usage_per_user','usage_time_per_user'];
    
    public function users()
    {
        return $this->belongsTo(PromoCode::class,'promo_code_id','id');
    }
    
}
