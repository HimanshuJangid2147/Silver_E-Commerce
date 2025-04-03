<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ShopManagement;
use Illuminate\Support\Str;

class ProductCategory extends Model
{
    protected $table = 'productcategory';
    protected $primaryKey = 'category_id';
    protected $connection = 'mysql';

    public function products()
    {
        return $this->hasMany(ShopManagement::class, 'category_id', 'category_id');
    }

    public function categories()
    {
        return $this->belongsTo(ShopManagement::class, 'product_id', 'id');
    }

    // Generate a slug from the category name
    public function getSlugAttribute()
    {
        return Str::slug($this->category_name);
    }
}
