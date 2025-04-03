<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'zip',
        'notes',
        'subtotal',
        'shipping',
        'total',
        'payment_method',
        'payment_status',
        'order_status',
    ];

    // Relationship with user
    public function user()
    {
        return $this->belongsTo(MemberLoginDetail::class, 'user_id');
    }

    // Relationship with order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
