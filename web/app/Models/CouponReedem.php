<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CouponReedem extends Model
{
    protected $table = 'coupon_redeem';
    protected $primaryKey = 'redeem_id';
    protected $fillable = [
        'user_id',
        'coupon_code',
        'redeem_status',
        'cdt'
    ];
}
