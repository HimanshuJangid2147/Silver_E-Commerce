<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\ProductCategory;

class ShopManagement extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $connection = 'mysql';

    // Define the relationship with ProductCategory
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'category_id');
    }

    public function product()
    {
        return $this->hasMany(ProductCategory::class, 'product_id', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(CustomerReview::class, 'product_id', 'product_id');
    }
    public function show($productId)
    {
        $shopManagement = \App\Models\ShopManagement::where('product_id', $productId)->get();
        $customerreviews = \App\Models\CustomerReview::where('product_id', $productId)->get();
        return view('your-view-name', compact('shopManagement', 'customerreviews'));
    }
    public function getSlugAttribute()
    {
        return Str::slug($this->product_name);
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id', 'product_id');
    }
}
