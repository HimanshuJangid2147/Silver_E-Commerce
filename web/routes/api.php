<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\ShopManagement;

Route::get('/search', function (Request $request) {
    $query = $request->input('q');

    if (empty($query)) {
        return response()->json([]);
    }

    $products = ShopManagement::where('product_name', 'LIKE', "%{$query}%")
        ->orWhere('product_description', 'LIKE', "%{$query}%")
        ->limit(5)
        ->get()
        ->map(function ($product) {
            $images = json_decode($product->product_image ?? '[]', true);
            $display_image = !empty($images) && is_array($images) ? $images[0] : 'images/no-image.jpg';

            return [
                'product_id' => $product->product_id,
                'product_name' => $product->product_name,
                'slug' => $product->slug,
                'price' => number_format($product->product_ammount - ($product->product_ammount * $product->discount / 100), 2),
                'image' => admnin_url . $display_image
            ];
        });

    return response()->json($products);
});
