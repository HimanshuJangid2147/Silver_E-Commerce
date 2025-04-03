<?php

namespace App\Providers;

use App\Models\BlockManagement;
use App\Models\Coupon;
use App\Models\CustomerReview;
use App\Models\GeneralSetting;
use App\Models\ProductCategory;
use App\Models\sliders;
use App\Models\ShopManagement;
use App\Models\Wishlist;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $generalSettings = GeneralSetting::all();
        $productCategory = ProductCategory::all();
        $BlockManagement = BlockManagement::all();
        $customerReviews = CustomerReview::all();
        $sliders = sliders::all();
        $shopManagement = ShopManagement::all();
        $Wishlist = Wishlist::all();
        $coupon = Coupon::all();


        View::share('generalSettings', $generalSettings);
        View::share('productCategory', $productCategory);
        View::share('BlockManagement', $BlockManagement);
        View::share('customerreviews', $customerReviews);
        View::share('sliders', $sliders);
        View::share('shopManagement', $shopManagement);
        View::share('Wishlist', $Wishlist);
        View::share('coupon', $coupon);


        define('admnin_url', 'http://localhost/silver.com/myadmin/');

    }
}
