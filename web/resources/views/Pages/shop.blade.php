@include('layouts.header')
@include('layouts.mobilemenu')
<!-- breadcumb area -->
<div class="breadcumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 txtc text-center ccase">
                <div class="brpt brptsize">
                    <h1 class="brcrumb_title">
                        @if($category)
                            {{ $category->name }}
                        @else
                            Shop
                        @endif
                    </h1>
                </div>
                <div class="breadcumb-inner">
                    <ul>
                        <li>You Here!- </li>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li> -<span class="current">
                            @if($category)
                                {{ $category->name }}
                            @else
                                Shop
                            @endif
                        </span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End breadcumb area -->
<!-- shop area start -->
<section class="shop_grid_area sec_padding shop_page_shop port_grid">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <p class="woocommerce-result-count">
                    Showing all {{ $shopManagement->count() }} results
                </p>
            </div>
            <div class="col-lg-7">
                <div class="d-flex order_tx">
                    <form class="woocommerce-ordering" method="get" action="{{ route('shop', ['category' => isset($category) ? $category->id : null]) }}">
                        <select class="nice-select orderby" name="sort" onchange="this.form.submit()" tabindex="0">
                            <option value="" {{ !request()->has('sort') || request('sort') == '' ? 'selected' : '' }}>Default Sort</option>
                            <option value="price_low_high" {{ request('sort') == 'price_low_high' ? 'selected' : '' }}>Price: low to high</option>
                            <option value="price_high_low" {{ request('sort') == 'price_high_low' ? 'selected' : '' }}>Price: high to low</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content">
                    <!-- Grid View -->
                    <div class="bgimgload fade tab-pane active show" id="tx_product_grid">
                        <div class="row blog-messonary">
                            @if($shopManagement->count() > 0)
                                @php
                                    // Apply sorting based on request parameter
                                    if(request('sort') == 'price_low_high') {
                                        $shopManagement = $shopManagement->sortBy(function($product) {
                                            $original_price = $product->product_ammount;
                                            $discount_percentage = $product->discount;
                                            return $original_price - ($original_price * $discount_percentage / 100);
                                        });
                                    } elseif(request('sort') == 'price_high_low') {
                                        $shopManagement = $shopManagement->sortByDesc(function($product) {
                                            $original_price = $product->product_ammount;
                                            $discount_percentage = $product->discount;
                                            return $original_price - ($original_price * $discount_percentage / 100);
                                        });
                                    }
                                @endphp

                                @foreach($shopManagement as $product)
                                    @php
                                        // Calculate discounted price
                                        $original_price = $product->product_ammount;
                                        $discount_percentage = $product->discount;
                                        $discounted_price = $original_price - ($original_price * $discount_percentage / 100);

                                        // Decode the JSON string of image paths
                                        $images = json_decode($product->product_image ?? '[]', true);
                                        // Select the first image, or use a fallback if no images exist
                                        $display_image = !empty($images) && is_array($images) ? $images[0] : 'images/no-image.jpg';
                                    @endphp
                                    <!-- Single portfolio item -->
                                    <div class="col-lg-3 eportfolio_item grid-item col-md-6 col-xs-12 col-sm-12 dried-products juice fruits-fresh allprt30">
                                        <div class="product_inner" style="padding-top: 20px;">
                                            <div class="product_img" style="height: 300px; width: 300px;">
                                                @if($discount_percentage > 0)
                                                    <span class="sale-badge">{{ $discount_percentage }}% OFF</span>
                                                @endif
                                                <img src="{{ admnin_url . htmlspecialchars($display_image) }}" alt="product" loading="lazy">
                                                <div class="jewel-action-container">
                                                    <!-- Wishlist Button -->
                                                    <form action="{{ route('wishlist.add', $product->product_id) }}" method="POST" class="jewel-action-form">
                                                        @csrf
                                                        <button type="submit" class="jewel-action-btn jewel-wishlist" title="Add to Wishlist">
                                                            <i class="icofont-ui-love"></i>
                                                        </button>
                                                    </form>
                                                    <!-- Cart Button -->
                                                    <form action="{{ route('cart.add', $product->product_id) }}" method="POST" class="jewel-action-form">
                                                        @csrf
                                                        <button type="submit" class="jewel-action-btn jewel-cart" title="Add to Cart">
                                                            <i class="icofont-shopping-cart"></i>
                                                        </button>
                                                    </form>
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
                            @else
                                <div class="col-lg-12">
                                    <p>No products found in this category.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- shop area end -->
@include('layouts.footer')
