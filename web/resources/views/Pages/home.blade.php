@include('layouts.header')
@include('layouts.mobilemenu')
<div>
    <!-- Slider Area -->
    <div class="jl_slider_area">
        <div class="container-fluid p-0">
            <div class="witr_carousel_main slider_active slick-slider">
                <!-- Slide 1 -->
                <div class="jl_slide_item">
                    <div class="slide_inner" style="background-image: url('<?php echo admnin_url . $sliders[0]->background_image; ?>');">
                        <div class="slide_content text-center">
                            <div class="ttin slide_animate">
                                <h2 class="txbdstitle sttwo hlight"><?php $slide = $sliders[0]->slide_title;
                                echo $slide; ?></h2>
                                <p><?php $slide = $sliders[0]->description;
                                echo $slide; ?></p>
                            </div>
                            <div class="witr_button_area slide_animate">
                                <div class="witr_btn_style mr">
                                    <div class="witr_btn_sinner">
                                        <a href="{{ route('shop') }}" class="witr_btn"><?php $slide = $sliders[0]->button_text;
                                        echo $slide; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 2 -->
                <div class="jl_slide_item">
                    <div class="slide_inner" style="background-image: url('<?php echo admnin_url . $sliders[1]->background_image; ?>');">
                        <div class="slide_content text-center">
                            <div class="ttin slide_animate">
                                <h2 class="txbdstitle sttwo hlight"><?php $slide = $sliders[1]->slide_title;
                                echo $slide; ?></h2>
                                <p><?php $slide = $sliders[1]->description;
                                echo $slide; ?></p>
                            </div>
                            <div class="witr_button_area slide_animate">
                                <div class="witr_btn_style mr">
                                    <div class="witr_btn_sinner">
                                        <a href="{{ route('shop') }}" class="witr_btn"><?php $slide = $sliders[1]->button_text;
                                        echo $slide; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 3 -->
                <div class="jl_slide_item">
                    <div class="slide_inner" style="background-image: url('<?php echo admnin_url . $sliders[2]->background_image; ?>');">
                        <div class="slide_content text-center">
                            <div class="ttin slide_animate">
                                <h2 class="txbdstitle sttwo hlight"><?php $slide = $sliders[2]->slide_title;
                                echo $slide; ?></h2>
                                <p><?php $slide = $sliders[2]->description;
                                echo $slide; ?></p>
                            </div>
                            <div class="witr_button_area slide_animate">
                                <div class="witr_btn_style mr">
                                    <div class="witr_btn_sinner">
                                        <a href="{{ route('shop') }}" class="witr_btn"><?php $slide = $sliders[2]->button_text;
                                        echo $slide; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- feature area -->
    <div class="jl_fe_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tts text-center">
                        <div class="ttin">
                            <h2 class="txbdstitle sttwo hlight">What We Do</h2>
                            <p>Lorem ipsum dolor sit amet, conse elit, sedid do eiusmod tempor incidi ut labore et
                                dolore magna aliqua.Quis ipsum usendi laboris mollit
                            </p>
                        </div>
                    </div>
                </div>

                <?php
            foreach ($productCategory as $category) {
            ?>
                <!-- Single feature -->
                <div class="col-lg-3 col-md-6">
                    <div class="txbdsva allcostyle boxsh txbdmb30 ser_6 text-center">
                        <div class="thbdsvthumb">
                            <img src="<?php echo admnin_url . $category->category_image; ?>" alt="image" height="270px" width="270px">
                        </div>
                        <div class="txbdsi boxtexrelative iconsabsconpd sselect">
                            <div class="imageicon">
                            </div>
                            <div class="txbdcon">
                                <a href="{{ route('shop', ['category_name' => $category->slug, 'category_id' => $category->category_id]) }}" class="txbdsvbtn txbdbtnicon">
                                    <h2 class="txbdsvtitle txstcolor hlight"><?php echo $category->category_name; ?></h2>
                                    <div class="txbdsvbtn txbdbtnicon"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>
            </div>
        </div>
    </div>
    <!-- about area -->
    <div class="ft_ab_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="ab_left_inner">
                        <div class="single_image_area">
                            <div class="single_image single_line_option">
                                <img src="images/Js_about_img.png" alt="image">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="ab_witr">
                        <div class="tts text-left">
                            <div class="ttin">
                                <h2 class="txbdstitle sttwo hlight"><?php $value = $generalSettings[0]->about_heading;
                                echo $value; ?></h2>
                                <p><?php $value = $generalSettings[0]->about_description;
                                echo $value; ?></p>
                                </p>
                            </div>
                        </div>
                        <div class="witr_button_area">
                            <div class="witr_btn_style mr">
                                <div class="witr_btn_sinner" style="position: absolute;">
                                    <a href="#" class="witr_btn" style="opacity: 1; position: relative;">
                                        View More
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shop area start {Our Popular Products} -->
    <section class="shop_grid_area sec_padding shop_page_shop port_grid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tts text-center">
                        <div class="ttin">
                            <h4 class="txbdstitle tsmall stone hlight txbdbcolor">New Product Variety</h4>
                            <h2 class="txbdstitle sttwo hlight">Our Popular Products</h2>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="bgimgload fade tab-pane active show" id="tx_product_grid">
                            <div class="row blog-messonary proj_active">
                                <?php
                                // Loop through shopManagement array, limited to 5 products
                                for ($i = 0; $i < min(5, count($shopManagement)); $i++) {
                                    // Calculate discounted price
                                    $original_price = $shopManagement[$i]->product_ammount;
                                    $discount_percentage = $shopManagement[$i]->discount;
                                    $discounted_price = $original_price - ($original_price * $discount_percentage / 100);

                                    // Decode the JSON string of image paths
                                    $images = json_decode($shopManagement[$i]->product_image ?? '[]', true);
                                    // Select the first image, or use a fallback if no images exist
                                    $display_image = !empty($images) && is_array($images) ? $images[0] : 'path/to/fallback-image.jpg';
                                ?>
                                    <!-- Single portfolio item -->
                                    <div class="col-lg-12 eportfolio_item grid-item col-md-12 col-xs-12 col-sm-12 dried-products juice fruits-fresh allprt30">
                                        <div class="product_inner" style="padding-top: 20px;">
                                            <div class="product_img">
                                                <!-- Display SALE badge with discount percentage if discount exists -->
                                                <?php if ($discount_percentage > 0) { ?>
                                                    <span class="sale-badge"><?php echo $discount_percentage; ?>% OFF</span>
                                                <?php } ?>
                                                <img src="<?php echo admnin_url . htmlspecialchars($display_image); ?>" alt="product">
                                                <div class="jewel-action-container">
                                                    <!-- Wishlist Button -->
                                                    <form action="{{ route('wishlist.add', $shopManagement[$i]->product_id) }}" method="POST" class="jewel-action-form">
                                                        @csrf
                                                        <button type="submit" class="jewel-action-btn jewel-wishlist" title="Add to Wishlist">
                                                            <i class="icofont-ui-love"></i>
                                                        </button>
                                                    </form>
                                                    <!-- Cart Button -->
                                                    <form action="{{ route('cart.add', $shopManagement[$i]->product_id) }}" method="POST" class="jewel-action-form">
                                                    @csrf
                                                        <button type="submit" class="jewel-action-btn jewel-cart" title="Add to Cart">
                                                            <i class="icofont-shopping-cart"></i>
                                                        </button>
                                                    </form>
                                                    <!-- View Product Button -->
                                                    <a href="{{ route('product', ['product_name' => $shopManagement[$i]->product_name, 'product_id' => $shopManagement[$i]->product_id]) }}" class="jewel-action-btn jewel-view" title="View Product">
                                                        <i class="icofont-eye-alt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="product_text">
                                                <div class="product_name">
                                                    <h3><a href="#"><?php echo htmlspecialchars($shopManagement[$i]->product_name); ?></a></h3>
                                                </div>
                                                <div class="product_price">
                                                    <?php if ($discount_percentage > 0) { ?>
                                                        <!-- Show original price with strikethrough and discounted price -->
                                                        <p>
                                                            <span class="original-price">₹ <?php echo number_format($original_price, 2); ?></span>
                                                            <span class="discounted-price">₹ <?php echo number_format($discounted_price, 2); ?></span>
                                                        </p>
                                                    <?php } else { ?>
                                                        <!-- Show only original price if no discount -->
                                                        <p>₹ <?php echo number_format($original_price, 2); ?></p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- shop area end -->
    <!-- call area -->
    <div class="jl_call_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tts text-center">
                        <div class="ttin">
                            <h2 class="txbdstitle sttwo hlight">Gold Jewelry that Captivates Hearts</h2>
                            <p>On sale up to - 15% Off Limited Time! </p>
                        </div>
                    </div>
                    <div class="witr_button_area">
                        <div class="witr_btn_style mr">
                            <div class="witr_btn_sinner text-center">
                                <a href="#" class="witr_btn">
                                    View More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- project area -->
    <div class="jl_proj_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tts text-left">
                        <div class="ttin">
                            <h2 class="txbdstitle sttwo hlight">Jewellery Shop</h2>
                        </div>
                    </div>
                </div>
                <!-- 1 single proj -->
                <div class="col-lg-4 col-md-6">
                    <div class="witr_process all_process_color">
                        <div class="witr_front_content">
                            <div class="witr_process_image txbdboxwhitetext">
                                <img src=<?php echo admnin_url . ($value = $BlockManagement[0]->block_image); ?> alt="image">
                                <div class="witr_back_process posibg">
                                    <div class="witr_content_service">
                                        <h2><?php $value = $BlockManagement[0]->block_heading;
                                        echo $value; ?></h2>
                                    </div>
                                </div>
                                <div class="witr_process_box">
                                    <div class="witr_process_icon">
                                        <i class="txbdbrac fas fa-plus"></i>
                                    </div>
                                    <div class="witr_process_icon2">
                                        <i class="txbdbrac fas fa-minus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 2 single proj -->
                <div class="col-lg-4 col-md-6">
                    <div class="witr_process all_process_color">
                        <div class="witr_front_content">
                            <div class="witr_process_image txbdboxwhitetext">
                                <img src=<?php echo admnin_url . ($value = $BlockManagement[1]->block_image); ?> alt="image">
                                <div class="witr_back_process posibg">
                                    <div class="witr_content_service">
                                        <h2><?php $value = $BlockManagement[1]->block_heading;
                                        echo $value; ?></h2>
                                    </div>
                                </div>
                                <div class="witr_process_box">
                                    <div class="witr_process_icon">
                                        <i class="txbdbrac fas fa-plus"></i>
                                    </div>
                                    <div class="witr_process_icon2">
                                        <i class="txbdbrac fas fa-minus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 3 single proj -->
                <div class="col-lg-4 col-md-6">
                    <div class="witr_process all_process_color">
                        <div class="witr_front_content">
                            <div class="witr_process_image txbdboxwhitetext">
                                <img src=<?php echo admnin_url . ($value = $BlockManagement[2]->block_image); ?> alt="image">
                                <div class="witr_back_process posibg">
                                    <div class="witr_content_service">
                                        <h2><?php $value = $BlockManagement[2]->block_heading;
                                        echo $value; ?></h2>
                                    </div>
                                </div>
                                <div class="witr_process_box">
                                    <div class="witr_process_icon">
                                        <i class="txbdbrac fas fa-plus"></i>
                                    </div>
                                    <div class="witr_process_icon2">
                                        <i class="txbdbrac fas fa-minus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- shop area start {Our Best Products} -->
    <section class="shop_grid_area sec_padding shop_page_shop port_grid shop2_area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="tts text-center">
                    <div class="ttin">
                        <h2 class="txbdstitle sttwo hlight">Our Best Products</h2>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="bgimgload fade tab-pane active show" id="tx_product_grid">
                        <div class="row blog-messonary proj_active">
                            <?php
                            // Filter the Collection to include only Best Products and take 5
                            $bestProducts = $shopManagement->filter(function($product) {
                                return $product->best_product == 1;
                            })->take(5);

                            // Check if there are any Best Products
                            if ($bestProducts->isEmpty()) {
                                echo '<div class="col-lg-12 text-center"><p>No Best Products available at the moment.</p></div>';
                            } else {
                                // Loop through the filtered Best Products
                                foreach ($bestProducts as $product) {
                                    // Calculate discounted price
                                    $original_price = $product->product_ammount;
                                    $discount_percentage = $product->discount;
                                    $discounted_price = $original_price - ($original_price * $discount_percentage / 100);

                                    // Decode the JSON string of image paths
                                    $images = json_decode($product->product_image ?? '[]', true);
                                    // Select the first image, or use a fallback if no images exist
                                    $display_image = !empty($images) && is_array($images) ? $images[0] : 'images/no-image.jpg';
                            ?>
                                <!-- Single portfolio item -->
                                <div class="col-lg-12 eportfolio_item grid-item col-md-12 col-xs-12 col-sm-12 dried-products juice fruits-fresh allprt30">
                                    <div class="product_inner" style="padding-top: 20px;">
                                        <div class="product_img">
                                            <!-- Display SALE badge with discount percentage if discount exists -->
                                            <?php if ($discount_percentage > 0) { ?>
                                            <span class="sale-badge"><?php echo $discount_percentage; ?>% OFF</span>
                                            <?php } ?>
                                            <img src="<?php echo admnin_url . htmlspecialchars($display_image); ?>" alt="product" loading="lazy">
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
                                                <h3><a href="#"><?php echo htmlspecialchars($product->product_name); ?></a></h3>
                                            </div>
                                            <div class="product_price">
                                                <?php if ($discount_percentage > 0) { ?>
                                                <!-- Show original price with strikethrough and discounted price -->
                                                <p>
                                                    <span class="original-price">₹ <?php echo number_format($original_price, 2); ?></span>
                                                    <span class="discounted-price">₹ <?php echo number_format($discounted_price, 2); ?></span>
                                                </p>
                                                <?php } else { ?>
                                                <!-- Show only original price if no discount -->
                                                <p>₹ <?php echo number_format($original_price, 2); ?></p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <!-- shop area end -->
    <!-- testimonial area -->
    <div class="jl_test_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tts text-center">
                        <div class="ttin">
                            <h4 class="txbdstitle tsmall stone hlight txbdbcolor">Testimonials</h4>
                            <h2 class="txbdstitle sttwo hlight">Customer Review</h2>
                        </div>
                    </div>
                    <div class="witr_carousel_main row test_active">
                        <?php if ($customerreviews->isEmpty()): ?>
                        <div class="col-md-12 text-center">
                            <p>No customer reviews available yet.</p>
                        </div>
                        <?php else: ?>
                        <?php foreach ($customerreviews->take(3) as $index => $review): ?>
                        <!-- single test -->
                        <div class="col-md-12 txbdmb30">
                            <div class="tsitem text-center alltesicl">
                                <div class="tsimg tsst4">
                                    <h2 class="tstitle">
                                        <?php echo htmlspecialchars($review->customer_name); ?>
                                    </h2>
                                </div>
                                <div class="tscon">
                                    <p><?php echo htmlspecialchars($review->customer_review); ?></p>
                                    <div class="tsreview tsdflex d-flex align-items-center justify-content-center">
                                        <div class="tsrevstar">
                                            <?php
                                                $rating = $review->customer_ratings;

                                                for ($i = 1; $i <=$rating; $i++)
                                                {?>
                                            <i class="ti-star txbdbcolor"></i>
                                            <?php
                                                }

                                                  for ($i = 1; $i <=(5-$rating); $i++)
                                                  {?>
                                            <i class="ti-star txbdbcolor-inactive"></i>
                                            <?php
                                                  }
                                                  ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Required CSS for star ratings -->
    <style>
        .txbdbcolor-inactive {
            color: #ccc;
        }

        .txbdbcolor {
            color: #ffd700;
        }

        .tsrevstar i {
            margin: 0 2px;
            font-size: 18px;
        }
    </style>
    <!-- contact area -->
    <div class="jl_cont_area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 witr_all_pd0">
                    <div class="cont_left_vd">
                        <div class="video-part">
                            <div class="video-overlay witr_all_color_v">
                                <div class="video-item text-center">
                                    <a class="btnallt btnall btnallactive videowh video-popup video-vemo-icon venobox vbox-item"
                                        data-vbtype="video" data-autoplay="true" href="https://youtu.be/BS4TUd7FJSg">
                                        <i class="icofont icofont-ui-play"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 witr_all_pd0">
                    <div class="con_witr_inner">
                        <div class="tts text-left">
                            <div class="ttin">
                                <h2 class="txbdstitle sttwo hlight" style="display: block;">Make An Enquiry</h2>
                                <p>Make an Enquiry to know more about the products, and to see the products in person at
                                    the store</p>
                            </div>
                        </div>
                        <div class="apartment_area">
                            <div class="witr_apartment_form">
                                <!-- Success Message -->
                                @if (session('success'))
                                    <div class="alert alert-success mb-3"
                                        style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; position: relative;">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle mr-2" style="font-size: 24px;"></i>
                                            <div>
                                                <strong>Thank You!</strong>
                                                {{ session('success') }}
                                            </div>
                                        </div>
                                        <button type="button" class="close"
                                            onclick="this.parentElement.style.display='none';"
                                            style="position: absolute; top: 10px; right: 10px; border: none; background: none; font-size: 20px;">&times;</button>
                                    </div>
                                @endif

                                <!-- Error Message -->
                                @if (session('error'))
                                    <div class="alert alert-danger mb-3"
                                        style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; position: relative;">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-circle mr-2" style="font-size: 24px;"></i>
                                            <div>
                                                <strong>Error!</strong>
                                                {{ session('error') }}
                                            </div>
                                        </div>
                                        <button type="button" class="close"
                                            onclick="this.parentElement.style.display='none';"
                                            style="position: absolute; top: 10px; right: 10px; border: none; background: none; font-size: 20px;">&times;</button>
                                    </div>
                                @endif

                                <!-- Enquiry Form -->
                                <form action="{{ route('enquiry.store') }}" method="POST" id="contact-form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="twr_form_box">
                                                <input type="text" name="name" placeholder="Name*"
                                                    value="{{ old('name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="twr_form_box">
                                                <input type="email" name="email" placeholder="Email*"
                                                    value="{{ old('email') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="twr_form_box">
                                                <input type="text" name="phone" placeholder="Phone*"
                                                    value="{{ old('phone') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="twr_form_box">
                                                <input type="text" name="subject" placeholder="Subject*"
                                                    value="{{ old('subject') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="twr_form_box">
                                                <textarea name="message" placeholder="Message" required>{{ old('message') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="contact_page_button text-left">
                                                <button type="submit" class="btn">Send Message</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
