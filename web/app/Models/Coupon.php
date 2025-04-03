<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'couponmanagement';
    protected $primaryKey = 'coupon_id';
    protected $fillable = [
        'coupon_code',
        'coupon_description',
        'coupon_status',
        'coupon_type',
        'coupon_discount_value',
        'min_purchase_amount',
        'start_date',
        'exp_date',
        'cdt'
    ];
}
