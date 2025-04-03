@include('layouts.header')
@include('layouts.mobilemenu')

<!-- breadcrumb area -->
<div class="breadcumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 txtc text-center ccase">
                <div class="brpt brptsize">
                    <h1 class="brcrumb_title">Wishlist</h1>
                </div>
                <div class="breadcumb-inner">
                    <ul>
                        <li>You Here!- </li>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li> -<span class="current">Wishlist</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End breadcrumb area -->

<!-- wishlist area start -->
<section class="wishlist_grid_area sec_padding wishlist_page port_grid">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <p class="woocommerce-result-count">
                    Showing {{ $wishlistItems->count() }} items in your wishlist
                </p>
            </div>
            <div class="col-lg-7">
                <div class="d-flex order_tx">
                    <form class="woocommerce-ordering" method="get" action="#">
                        <select class="nice-select orderby" tabindex="0">
                            <option value="">Sort by Date Added</option>
                            <option value="">Sort by Name</option>
                            <option value="">Sort by Price: Low to High</option>
                            <option value="">Sort by Price: High to Low</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content">
                    <!-- Grid View -->
                    <div class="bgimgload fade tab-pane active show" id="tx_wishlist_grid">
                        <div class="row blog-messonary">
                            @if($wishlistItems->isEmpty())
                                <div class="col-lg-12 text-center">
                                    <p>Your wishlist is empty.</p>
                                </div>
                            @else
                                @foreach($wishlistItems as $item)
                                    @php
                                        $product = $item->product;
                                        $original_price = $product->product_ammount;
                                        $discount_percentage = $product->discount;
                                        $discounted_price = $original_price - ($original_price * $discount_percentage / 100);
                                        $images = json_decode($product->product_image ?? '[]', true);
                                        $display_image = !empty($images) && is_array($images) ? $images[0] : 'images/no-image.jpg';
                                    @endphp
                                    <!-- Wishlist item -->
                                    <div class="col-lg-3 eportfolio_item grid-item col-md-6 col-xs-12 col-sm-12 dried-products juice fruits-fresh allprt30">
                                        <div class="product_inner" style="padding-top: 20px;">
                                            <div class="product_img">
                                                @if($discount_percentage > 0)
                                                    <span class="sale-badge">{{ $discount_percentage }}% OFF</span>
                                                @endif
                                                <img src="{{ admnin_url . htmlspecialchars($display_image) }}" alt="wishlist item" loading="lazy">
                                                <div class="jewel-action-container">
                                                    <!-- Remove from Wishlist Button -->
                                                    <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="jewel-action-form">
                                                        @csrf
                                                        <button type="submit" class="jewel-action-btn jewel-wishlist" title="Remove From Wishlist">
                                                            <i class="icofont-ui-love-remove"></i>
                                                        </button>
                                                    </form>
                                                    <!-- Cart Button -->
                                                    <a href="#" class="jewel-action-btn jewel-cart" title="Add to Cart">
                                                        <i class="icofont-shopping-cart"></i>
                                                    </a>
                                                    <!-- View Product Button -->
                                                    <a href="{{ route('product', ['product_name' => $product->product_name, 'product_id' => $product->product_id]) }}" class="jewel-action-btn jewel-view" title="View Product">
                                                        <i class="icofont-eye-alt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product_text">
                                                <div class="product_name">
                                                    <h3><a href="#">{{ htmlspecialchars($product->product_name) }}</a></h3>
                                                </div>
                                                <div class="product_price">
                                                    @if($discount_percentage > 0)
                                                        <p>
                                                            <span class="original-price">₹ {{ number_format($original_price, 2) }}</span>
                                                            <span class="discounted-price">₹ {{ number_format($discounted_price, 2) }}</span>
                                                        </p>
                                                    @else
                                                        <p>₹ {{ number_format($original_price, 2) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- wishlist area end -->

@include('layouts.footer')
