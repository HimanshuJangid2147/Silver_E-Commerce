<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\WebController;
use App\Http\Controllers\EcommerceController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\WishlistController;

Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('/about', [WebController::class, 'about'])->name('about');
Route::get('/myaccount', [WebController::class, 'myaccount'])->name('myaccount');
Route::get('/cart', [EcommerceController::class, 'cart'])->name('cart');
Route::post('/cart/add/{product_id}', [EcommerceController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{product_id}', [EcommerceController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove/{product_id}', [EcommerceController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/checkout', [EcommerceController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [EcommerceController::class, 'processCheckout'])->name('checkout.process');
Route::post('/checkout/apply-coupon', [EcommerceController::class, 'applyCoupon'])->name('checkout.apply.coupon');
Route::get('/checkout/remove-coupon', [EcommerceController::class, 'removeCoupon'])->name('checkout.remove.coupon');
Route::get('/order/confirmation/{orderNumber}', [EcommerceController::class, 'orderConfirmation'])->name('order.confirmation');
Route::get('/payment/process/{orderNumber}', [EcommerceController::class, 'processPayment'])->name('payment.process');
Route::get('/testimonials', [WebController::class, 'testimonials'])->name('testimonials');
Route::get('/contact', [WebController::class, 'contact'])->name('contact');
Route::post('/contact/submit', [WebController::class, 'contactSubmit'])->name('contact.submit');
Route::get('/track-order', [WebController::class, 'track'])->name('track_order');
Route::get('/refer', [WebController::class, 'ReferandEarn'])->name('refer');
Route::get('/login', [WebController::class, 'login'])->name('login');
Route::get('/signup', [WebController::class, 'signup'])->name('signup');
Route::get('/products/{product_name?}/{product_id?}', [WebController::class, 'Product'])->name('product');
Route::get('/wishlist', [WebController::class, 'wishlist'])->name('wishlist');
Route::get('/shop/{category_name?}/{category_id?}', [WebController::class, 'shop'])->name('shop');
Route::get('/policies/{policy}', [PolicyController::class, 'show'])->name('policies.show');
Route::post('/reviews/store', [App\Http\Controllers\CustomerReviewsController::class, 'store'])->name('reviews.store');
Route::get('/product-reviews/{product_id}', [App\Http\Controllers\CustomerReviewsController::class, 'getProductReviews'])->name('product.reviews');
Route::post('/signup_submit', [WebController::class, 'register'])->name('signup_submit');
Route::post('/login_submit', [WebController::class, 'loginSubmit'])->name('login_submit');
Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/add/{product_id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/logout', [WebController::class, 'logout'])->name('logout');
Route::get('/search', [WebController::class, 'search'])->name('search');

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/enquiries', [EnquiryController::class, 'index'])->name('admin.enquiries.index');
    Route::post('/enquiries/{id}/read', [EnquiryController::class, 'markAsRead'])->name('admin.enquiries.read');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/myaccount', [WebController::class, 'myaccount'])->name('myaccount');
    Route::get('/my-orders', [WebController::class, 'myOrders'])->name('my.orders');
    Route::get('/order/{orderNumber}', [WebController::class, 'viewOrder'])->name('order.view');
    Route::put('/profile/update', [WebController::class, 'updateProfile'])->name('profile.update');
    Route::put('/settings/update', [WebController::class, 'updateSettings'])->name('settings.update');
});
