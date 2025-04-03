<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $connection = 'mysql';
    protected $fillable = [
        'customer_name',
        'customer_email',
        'review_title',
        'customer_review',
        'customer_ratings',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(ShopManagement::class, 'product_id', 'product_id');
    }
}
