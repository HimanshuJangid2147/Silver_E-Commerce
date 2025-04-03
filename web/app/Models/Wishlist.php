<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlist';

    protected $fillable = ['user_id', 'product_id'];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(MemberLoginDetail::class, 'user_id');
    }
    public function member()
    {
        return $this->belongsTo(MemberLoginDetail::class, 'id');
    }
    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(ShopManagement::class, 'product_id', 'product_id');
    }
}
