<!DOCTYPE html>
<html lang="en">

<head>
    <title>Juyelas</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="keywords" content="web design html template">
    <meta name="date" content="Dec 26">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <!-- CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/venobox.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/plugin_theme_css.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sliderstyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/productstyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/imagemagnifine.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login-signup.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- modernizr js -->
    <script src="{{ asset('js/modernizr-2.8.3.min.js') }}"></script>
</head>

<body>
    <header>

        <!-- Top Bar Header Area -->
        <div class="em40_header_area_main">
            <!-- Primary Top Bar -->
            <div class="primary-top-bar">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="primary-address">
                                <p>
                                    <span>
                                        <i class="ti-bell"></i><?php $value = $generalSettings[0]->alert;
                                        echo $value; ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Second Top Bar -->
            <div class="juyelas-header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-lg-7 col-xl-8 col-md-6 col-sm-12">
                            <div class="top-address text-left text_s_center">
                                <p>
                                    <span>
                                        <i class="ti-location-pin"></i><?php $value = $generalSettings[0]->notifications;
                                        echo $value; ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-lg-5 col-xl-4 col-md-6 col-sm-12">
                            <div class="top-right-menu d-flex justify-content-end">
                                <div class="top-address">
                                    <p></p>
                                </div>
                                <ul class="social-icons text-right text_m_center">
                                    <li><a href="<?php $value = $generalSettings[0]->facebook;
                                    echo $value; ?>"><i class="ti-facebook"></i></a></li>
                                    <li><a href="<?php $value = $generalSettings[0]->twitter;
                                    echo $value; ?>"><i class="fa fa-x-twitter"></i></a></li>
                                    <li><a href="<?php $value = $generalSettings[0]->instagram;
                                    echo $value; ?>"><i class="ti-instagram"></i></a></li>
                                    <li><a href="<?php $value = $generalSettings[0]->pinterest;
                                    echo $value; ?>"><i class="ti-pinterest"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Desktop Menu Area -->
        <div class="tx_top2_relative">
            <div class="juyelas-main-menu hidden-xs hidden-sm one_page witr_h_h18">
                <div class="juyelas_nav_area scroll_fixed">
                    <div class="container">
                        <div class="row logo-left">
                            <!-- MAIN MENU -->
                            <div class="col-md-2 col-sm-2 col-xs-2">
                                <div class="logo">
                                    <a class="main_sticky_main_l" href="{{ route('home') }}" title="Juyelas">
                                        <img src="{{ asset('images/logo1.png') }}" alt="Juyelas">
                                    </a>
                                    <a class="main_sticky_l" href="{{ route('home') }}" title="Juyelas">
                                        <img src="{{ asset('images/logo2.png') }}" alt="Juyelas">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-10 col-sm-10 col-xs-10 tx_menu_together">
                                <nav class="juyelas_menu">
                                    <ul class="sub-menu">
                                        <li><a href="{{ route('home') }}">Home</a></li>
                                        @if (!empty($productCategory) && $productCategory->count() > 0)
                                            @foreach ($productCategory as $category)
                                                <li><a
                                                        href="{{ route('shop', ['category_name' => $category->slug, 'category_id' => $category->category_id]) }}">{{ $category->category_name }}</a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li><a href="#">No Categories</a></li>
                                        @endif
                                    </ul>
                                </nav>
                                <div class="tx_mmenu_together">
                                    <div class="main-search-menu">
                                        <div class="em-quearys-top msin-menu-search">
                                            <div class="em-top-quearys-area">
                                                <div class="em-header-quearys">
                                                    <div class="em-quearys-menu">
                                                        <i class="ti-search t-quearys"></i>
                                                    </div>
                                                </div>
                                                <!--SEARCH FORM-->
                                                <div class="em-quearys-inner">
                                                    <div class="em-quearys-form">
                                                        <form class="top-form-control" action="#" method="get">
                                                            <input type="text" placeholder="Type Your Keyword"
                                                                name="s" value="">
                                                            <button class="top-quearys-style" type="submit">
                                                                <i class="ti-search"></i>
                                                            </button>
                                                        </form>
                                                        <div class="em-header-quearys-close text-center mrt10">
                                                            <div class="em-quearys-menu">
                                                                <i class="icofont-close-line  t-close em-s-hidden"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Woo Icon cart -->
                                    <div class="mini_shop_content site-header-cart" id="site-header-cart">
                                        <div class="">
                                            <a class="cart-contents" href="{{ route('cart') }}"
                                                title="View your shopping cart">
                                                <i class="ti-bag"></i>
                                                @php
                                                    $cart = session()->get('cart', []);
                                                    $cartCount = count($cart);
                                                @endphp
                                                <span class="count">{{ $cartCount }}</span>
                                            </a>
                                        </div>
                                        <div class="twr_mini_cart">
                                            <div class="widget woocommerce widget_shopping_cart">
                                                <div class="widget_shopping_cart_content">
                                                    @if ($cartCount > 0)
                                                        <ul
                                                            class="woocommerce-mini-cart cart_list product_list_widget">
                                                            @foreach ($cart as $item)
                                                                <li class="woocommerce-mini-cart-item mini_cart_item">
                                                                    <a href="{{ route('cart.remove', $item['id']) }}"
                                                                        class="remove" title="Remove this item">
                                                                        <i class="icofont-close"></i>
                                                                    </a>
                                                                    <img src="{{ admnin_url . htmlspecialchars($item['image']) }}"
                                                                        alt="{{ $item['name'] }}"
                                                                        style="width: 50px; height: 50px;">
                                                                    <span
                                                                        class="mini-cart-item-title">{{ $item['name'] }}</span>
                                                                    <span class="quantity">{{ $item['quantity'] }} × ₹
                                                                        {{ number_format($item['price'] - ($item['price'] * $item['discount']) / 100, 2) }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <p class="woocommerce-mini-cart__total total">
                                                            <strong>Subtotal:</strong> ₹
                                                            {{ number_format(
                                                                collect($cart)->sum(function ($item) {
                                                                    return ($item['price'] - ($item['price'] * $item['discount']) / 100) * $item['quantity'];
                                                                }),
                                                                2,
                                                            ) }}
                                                        </p>
                                                        <p class="woocommerce-mini-cart__buttons buttons">
                                                            <a href="{{ route('cart') }}"
                                                                class="button wc-forward">View Cart</a>
                                                            <a href="{{ route('checkout') }}"
                                                                class="button checkout wc-forward">Checkout</a>
                                                        </p>
                                                    @else
                                                        <p class="woocommerce-mini-cart__empty-message">No products in
                                                            the cart.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="twr_mini_cart">
                                        <div class="widget woocommerce widget_shopping_cart">
                                            <div class="widget_shopping_cart_content">
                                                <p class="woocommerce-mini-cart__empty-message">No products in
                                                    the cart.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Woo Icon Wishlist -->
                                <div class="mini_shop_content site-header-wishlist" id="site-header-wishlist">
                                    <div class="">
                                        <a class="wishlist-icon" href="{{ route('wishlist') }}"
                                            title="My Wishlist"><i class="ti-heart"></i>
                                            @php
                                                $wishlistItems = 0; // Default to 0 if user is not logged in
                                                if (Auth::check()) {
                                                    $wishlistItems = App\Models\Wishlist::where(
                                                        'user_id',
                                                        Auth::user()->id,
                                                    )
                                                        ->get()
                                                        ->count();
                                                }
                                            @endphp
                                            <span class="count">{{ $wishlistItems }}</span>
                                        </a>
                                    </div>
                                </div>
                                <!-- Woo Icon Profile -->
                                <div class="mini_shop_content site-header-profile" id="site-header-profile">
                                    <div>
                                        @if (Auth::check())
                                            <a class="account-icon" href="{{ route('myaccount') }}"
                                                title="My Account"><i class="ti-user"></i></a>
                                            <form method="POST" action="{{ route('logout') }}"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="logout-icon" title="Logout"
                                                    style="font-size: 20px; box-shadow: 0 0 30px 0 #d6c3c303; padding: 8px; border-radius: 100%; color: #222429; background: #ffffff; border: none; cursor: pointer;">
                                                    <i class="ti-power-off"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a class="account-icon" href="{{ route('login') }}" title="Login"><i
                                                    class="ti-user"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </header>
</body>

</html>
