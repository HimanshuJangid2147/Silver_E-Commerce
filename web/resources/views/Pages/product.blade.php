@include('layouts.header')
@include('layouts.mobilemenu')

<?php
$productId = $shopManagement[0]->product_id; // Updated to use product_id
$productReviews = \App\Models\CustomerReview::where('product_id', $productId)->get();
$customerreviews = \App\Models\CustomerReview::where('product_id', $shopManagement[0]->product_id)->get();
?>

<!-- Breadcrumb Area -->
<div class="breadcumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 txtc text-center ccase">
                <div class="brpt brptsize">
                    <h1 class="brcrumb_title">{{ $shopManagement[0]->product_name ?? 'Product' }}</h1>
                </div>
                <div class="breadcumb-inner">
                    <ul>
                        <li>You Are Here: </li>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li> - <a href="{{ url('/shop') }}">Shop</a></li>
                        <li> - <span class="current">{{ $shopManagement[0]->product_name ?? 'Product' }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$product_image = trim(str_replace(']', '', str_replace('[', '', $shopManagement[0]['product_image'])), '"');
?>

<!-- Single Product Area -->
<section class="shop_grid_area sec_padding shop_page_shop port_grid sopage_shop">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <!-- Product Image Gallery -->
                <div class="product_img_wrapper">
                    <div class="product_img position-relative" id="main-product-image">
                        <img src="<?php echo admnin_url . $product_image; ?>" alt="{{ $shopManagement[0]->product_name }}"
                            class="image-preview image-preview-js img-fluid" id="selected-image">
                        @if (isset($shopManagement[0]->discount) && $shopManagement[0]->discount > 0)
                            <div class="sale">
                                <p>Sale!</p>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Selection -->
                    <div class="product_thumbnails mt-3">
                        <div class="row">
                            @if (isset($shopManagement[0]->product_image))
                                <div class="col-3">
                                    <div class="thumbnail_item active">
                                        <img src="<?php echo admnin_url . $product_image; ?>"
                                            alt="{{ $shopManagement[0]->product_name }} - Main"
                                            class="img-fluid thumbnail" data-image="<?php echo admnin_url . $product_image; ?>">
                                    </div>
                                </div>
                            @endif

                            @php
                                $additionalImages = [];
                                if (isset($shopManagement[0]->product_image)) {
                                    try {
                                        $imageData = $shopManagement[0]->product_image;
                                        // If it's already a JSON string, decode it
        if (is_string($imageData) && strpos($imageData, '[') === 0) {
            $additionalImages = json_decode($imageData, true);
            // If decode fails or returns null, make it an empty array
            if (!is_array($additionalImages)) {
                $additionalImages = [];
            }
        }
        // If it's already treated as a single image earlier, don't include it again
                                    } catch (\Exception $e) {
                                        $additionalImages = [];
                                    }
                                }
                            @endphp
                            @if (is_array($additionalImages))
                                @foreach ($additionalImages as $index => $image)
                                    @if (is_string($image))
                                        <div class="col-3">
                                            <div class="thumbnail_item">
                                                <img src="<?php echo admnin_url . $image; ?>"
                                                    alt="{{ $shopManagement[0]->product_name }} - View {{ $index + 1 }}"
                                                    class="img-fluid thumbnail" data-image="<?php echo admnin_url . $image; ?>">
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Product Details -->
                <div class="tbd_product tbd_product_list">
                    <div class="tbd_product_title">
                        @foreach ($shopManagement as $product)
                            @php
                                // Calculate discounted price
                                $original_price = $product->product_ammount;
                                $discount_percentage = $product->discount;
                                $discounted_price = $original_price - ($original_price * $discount_percentage) / 100;
                            @endphp
                            <h3><?php echo $product->product_name; ?></h3>
                            <!-- Product Rating -->
                            @if ($customerreviews->count() > 0)
                                <div class="review_rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="icofont-star {{ $i <= $customerreviews[0]->customer_ratings ? 'filled' : '' }}"></i>
                                    @endfor
                                    <span class="rating_count">({{ $customerreviews->count() }} Reviews)</span>
                                </div>
                            @else
                                <div class="review_rating">
                                    <span class="rating_count">No Ratings Available</span>
                                </div>
                            @endif
                    </div>
                    <div class="tbd_price_lista">
                        <div class="tbd_price_opt clearfix">
                            <span class="price">
                                @if ($product->discount <= 0)
                                    <span class="price">₹ {{ $product->product_ammount }}</span>
                                @else
                                    <del class="original-price">₹ {{ number_format($original_price, 2) }}</del>
                                    <span class="discounted-price">₹ {{ number_format($discounted_price, 2) }}</span>
                                @endif
                            </span>
                            @if ($product->discount <= 0)
                                <span class="discount-badge" style="display: none;">0% OFF</span>
                            @else
                                <span class="discount-badge">{{ $discount_percentage }}% OFF</span>
                            @endif
                        </div>
                    </div>
                    <p class="list_produc_content">
                        {!! $product->product_shortdisc !!}
                    </p>

                    <div class="quantity_selectorr mb-3" style="margin-top: 8px;">
                        <label for="quantity" style="font-weight: bold;">Quantity:</label>
                        <div class="quantity_wrapper">
                            <span class="quantity_btn minus">-</span>
                            <input type="text" id="quantity" name="quantity" min="1" value="1"
                                class="form-control">
                            <span class="quantity_btn plus">+</span>
                        </div>
                    </div>
                    <div style="margin-top: 20px; display: block; gap: 10px; display: flex; align-items: flex-end; justify-content: space-between;">
                        <a href="#" class="btnallt btnall buy-now-btn ml-2" title="Buy Now"
                            style="background-color: #ff5722; color: white; padding: 10px 20px; border-radius: 4px; display: inline-block; margin-left: 10px; text-decoration: none;">
                            Buy Now
                        </a>
                        <div>
                            <!-- Cart Button -->
                            <form action="{{ route('cart.add', $product->product_id) }}" method="POST"
                                class="jewel-action-form">
                                @csrf
                                <button type="submit" class="btnallt btnall buy-now-btn ml-2" title="Add to Cart" style="background-color: white; padding: 10px 20px; border-radius: 4px; display: inline-block; margin-left: 10px;">
                                    <i class="icofont-shopping-cart"> Add to Cart</i>
                                </button>
                            </form>
                            <!-- Wishlist Button -->
                            <form action="{{ route('wishlist.add', $product->product_id) }}" method="POST"
                                class="jewel-action-form">
                                @csrf
                                <button type="submit" class="btnallt btnall buy-now-btn ml-2" title="Add to Wishlist" style="background-color: white; padding: 10px 20px; border-radius: 4px; display: inline-block; margin-left: 10px;">
                                    <i class="icofont-ui-love"> Wishlist</i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="product_meta mt-4">
                        <p><strong>SKU:</strong> <?php echo $product->product_sku; ?></p>
                        @if (isset($product->category) && $product->category)
                            <p><strong>Category:</strong> {{ $product->category->category_name }}</p>
                        @else
                            <p><strong>Category:</strong> Not Available</p>
                        @endif
                        <p><strong>Tags:</strong> <?php echo $product->tags; ?></p>
                        @if (isset($product->product_qty) && $product->product_qty > 0)
                            <p><strong>Availability:</strong> <span class="in-stock">In Stock</span>
                                (<?php echo $product->product_qty; ?>)
                            </p>
                        @else
                            <p><strong>Availability:</strong> <span class="out-of-stock">Out of Stock</span></p>
                        @endif
                    </div>
                    <!-- Delivery Options -->
                    <div class="delivery_options mt-3">
                        <div class="delivery_option">
                            <i class="icofont-truck"></i>
                            <span>Free shipping on orders over ₹ 1000</span>
                        </div>
                        <div class="delivery_option">
                            <i class="icofont-refresh"></i>
                            <span>30-day return policy</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="product_tabs">
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="description-tab" data-bs-toggle="tab" href="#description"
                                role="tab">Description</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="reviews-tab" data-bs-toggle="tab" href="#reviews"
                                role="tab">Reviews ({{ $customerreviews->count() }})</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="productTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="product_description p-4">
                                <h4>Product Description</h4>
                                <p>
                                    {!! $product->description !!}
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="product_reviews p-4">
                                <h4>Customer Reviews</h4>
                                <!-- Review Form -->
                                <div class="review_form_section mt-5 pt-4 border-top">
                                    <h4 class="form_title mb-3">Add Your Review</h4>
                                    <form action="{{ route('reviews.store') }}" method="post" class="review_form">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="reviewName" class="form-label">Your Name</label>
                                                <input type="text" class="form-control" id="reviewName"
                                                    name="customer_name" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="reviewEmail" class="form-label">Your Email</label>
                                                <input type="email" class="form-control" id="reviewEmail"
                                                    name="customer_email" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="reviewTitle" class="form-label">Review Title</label>
                                            <input type="text" class="form-control" id="reviewTitle"
                                                name="review_title" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Your Rating</label>
                                            <div class="rating_select">
                                                <i class="icofont-star" data-rating="1"></i>
                                                <i class="icofont-star" data-rating="2"></i>
                                                <i class="icofont-star" data-rating="3"></i>
                                                <i class="icofont-star" data-rating="4"></i>
                                                <i class="icofont-star" data-rating="5"></i>
                                                <input type="hidden" name="customer_ratings" id="selectedRating"
                                                    value="0">
                                            </div>
                                            <div class="rating-error text-danger mt-1" style="display: none;">Please
                                                select a rating</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="reviewText" class="form-label">Your Review</label>
                                            <textarea class="form-control" id="reviewText" name="customer_review" rows="4" required></textarea>
                                        </div>
                                        <input type="hidden" name="product_id"
                                            value="{{ $shopManagement[0]->product_id ?? '' }}">
                                        <button type="submit" class="btn btn-primary">Submit Review</button>
                                        <div class="alert alert-success mt-3" id="review-success"
                                            style="display: none;">
                                            Your review has been submitted successfully!
                                        </div>
                                        <div class="alert alert-danger mt-3" id="review-error"
                                            style="display: none;">
                                            Error submitting review. Please try again.
                                        </div>
                                    </form>
                                </div>
                                <!-- Reviews Display -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="customer_reviews_section mt-4">
                                            <h4 class="reviews_title mb-4">Customer Reviews</h4>
                                            <div class="reviews_container">
                                                @if ($customerreviews->isEmpty())
                                                    <div class="no_reviews text-center py-4">
                                                        <p>No customer reviews available yet. Be the first to leave a
                                                            review!</p>
                                                    </div>
                                                @else
                                                    <div class="reviews_list">
                                                        @foreach ($customerreviews->take(3) as $review)
                                                            <div class="review_item mb-4">
                                                                <div
                                                                    class="review_header d-flex justify-content-between align-items-center">
                                                                    <h5 class="reviewer_name mb-0">
                                                                        {{ htmlspecialchars($review->customer_name) }}
                                                                    </h5>
                                                                    <div class="review_rating">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            <i
                                                                                class="icofont-star {{ $i <= $review->customer_ratings ? 'filled' : '' }}"></i>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                                <div class="review_title mt-1">
                                                                    <strong>{{ htmlspecialchars($review->review_title) }}</strong>
                                                                </div>
                                                                <div class="review_content mt-2">
                                                                    <p>{{ htmlspecialchars($review->customer_review) }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if ($customerreviews->count() > 3)
                                                        <div class="view_more_reviews text-center mt-3">
                                                            <button class="btn btn-outline-primary btn-sm"
                                                                onclick="loadMoreReviews({{ $shopManagement[0]->product_id ?? '' }})">View
                                                                All Reviews</button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get form elements
        const reviewForm = document.querySelector('.review_form');
        const successMessage = document.getElementById('review-success');
        const errorMessage = document.getElementById('review-error');
        const productIdField = document.querySelector('input[name="product_id"]');

        // Make sure we have all necessary elements
        if (!reviewForm || !productIdField) {
            console.error('Required form elements not found');
            return;
        }

        // Ensure the product ID is properly set
        const productId = productIdField.value;
        console.log('Product ID detected:', productId);

        // Form submission handler
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Validate rating
            const ratingInput = document.getElementById('selectedRating');
            const ratingError = document.querySelector('.rating-error');

            if (ratingInput.value == "0") {
                ratingError.style.display = 'block';
                return false;
            }

            // Create form data
            const formData = new FormData(reviewForm);

            // Double check that product_id is included
            if (!formData.get('product_id') || formData.get('product_id') === '') {
                console.error('Product ID missing in form submission');
                // Manually append product ID if it's missing
                formData.append('product_id', productId);
            }

            // AJAX request
            fetch(reviewForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        successMessage.style.display = 'block';
                        errorMessage.style.display = 'none';
                        reviewForm.reset(); // Reset form

                        // Reset star ratings
                        const ratingStars = document.querySelectorAll('.rating_select i');
                        ratingStars.forEach(s => s.classList.remove('active'));
                        ratingInput.value = "0";

                        // Refresh reviews section
                        loadMoreReviews(productId);
                    } else {
                        // Show error message
                        errorMessage.style.display = 'block';
                        successMessage.style.display = 'none';
                        errorMessage.textContent = data.message ||
                            'Error submitting review. Please try again.';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorMessage.style.display = 'block';
                    successMessage.style.display = 'none';
                    errorMessage.textContent = 'Error submitting review. Please try again.';
                });

            console.log('Form Data:', {
                'product_id': formData.get('product_id'),
                'customer_name': formData.get('customer_name'),
                'customer_email': formData.get('customer_email'),
                'customer_ratings': formData.get('customer_ratings'),
                'customer_review': formData.get('customer_review'),
                'review_title': formData.get('review_title')
            });
        });

        // Fix for rating selection
        const ratingStars = document.querySelectorAll('.rating_select i');
        const ratingInput = document.getElementById('selectedRating');
        const ratingError = document.querySelector('.rating-error');
        const ratingContainer = document.querySelector('.rating_select');

        ratingStars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingInput.value = rating;

                // Reset all stars
                ratingStars.forEach(s => s.classList.remove('active'));

                // Highlight stars up to selected rating
                for (let i = 0; i <= index; i++) {
                    ratingStars[i].classList.add('active');
                }

                // Hide error message if rating is selected
                ratingError.style.display = 'none';
            });

            // Hover effect
            star.addEventListener('mouseenter', function() {
                for (let i = 0; i <= index; i++) {
                    ratingStars[i].classList.add('hover');
                }
                for (let i = index + 1; i < ratingStars.length; i++) {
                    ratingStars[i].classList.remove('hover');
                }
            });
        });

        // Remove hover effect when mouse leaves the container
        if (ratingContainer) {
            ratingContainer.addEventListener('mouseleave', function() {
                ratingStars.forEach(s => s.classList.remove('hover'));
            });
        }

        // Load more reviews functionality
        function loadMoreReviews(productId) {
            fetch(`/product-reviews/${productId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const reviewsList = document.querySelector('.reviews_list');
                    const noReviews = document.querySelector('.no_reviews');
                    const viewMoreSection = document.querySelector('.view_more_reviews');

                    if (reviewsList && data.reviews) {
                        // Clear existing reviews
                        reviewsList.innerHTML = '';

                        // Hide no reviews message
                        if (noReviews) {
                            noReviews.style.display = 'none';
                        }

                        // Add all reviews
                        data.reviews.forEach(review => {
                            const reviewItem = document.createElement('div');
                            reviewItem.className = 'review_item mb-4';
                            reviewItem.innerHTML = `
                                    <div class="review_header d-flex justify-content-between align-items-center">
                                        <h5 class="reviewer_name mb-0">${review.customer_name}</h5>
                                        <div class="review_rating">
                                            ${Array(5).fill().map((_, i) => `<i class="icofont-star ${i < review.customer_ratings ? 'filled' : ''}"></i>`).join('')}
                                        </div>
                                    </div>
                                    <div class="review_title mt-1">
                                        <strong>${review.review_title}</strong>
                                    </div>
                                    <div class="review_content mt-2">
                                        <p>${review.customer_review}</p>
                                    </div>
                                `;
                            reviewsList.appendChild(reviewItem);
                        });

                        // Hide the "View All Reviews" button after loading all reviews
                        if (viewMoreSection) {
                            viewMoreSection.style.display = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading reviews:', error);
                });
        }

        // Add styles
        const style = document.createElement('style');
        style.textContent = `
            .product_img {
                overflow: visible;
                position: relative;
                transition: all 0.3s ease;
                padding: 10px; /* Added padding to give space around the image */
            }

            #selected-image {
                cursor: zoom-in;
                transition: transform 0.3s ease;
                width: 100%;
                display: block; /* Ensure proper positioning */
                margin: 0 auto; /* Center the image */
            }

            #selected-image.enlarged {
                transform: scale(1.5); /* Adjust this value to change enlargement size */
                z-index: 10;
                cursor: zoom-out;
                position: relative; /* Ensure it stays within container */
            }

            .product_img_wrapper {
                position: relative;
                max-width: 100%; /* Ensure it doesn't exceed container */
            }

            /* Optional: Adjust container height dynamically */
            #main-product-image.enlarged-container {
                height: auto; /* Allow height to adjust */
                min-height: 300px; /* Minimum height to prevent collapse */
            }
        `;
        document.head.appendChild(style);

        // Image elements
        const thumbnails = document.querySelectorAll('.thumbnail');
        const mainImage = document.getElementById('selected-image');
        const imageContainer = document.getElementById('main-product-image');

        // Thumbnail switching
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                const newImageSrc = this.getAttribute('data-image');
                mainImage.src = newImageSrc;
                mainImage.classList.remove('enlarged');
                imageContainer.classList.remove('enlarged-container');
                document.querySelector('.thumbnail_item.active').classList.remove('active');
                this.parentElement.classList.add('active');
            });
        });

        // Toggle enlargement on click
        let isEnlarged = false;
        mainImage.addEventListener('click', function() {
            if (!isEnlarged) {
                this.classList.add('enlarged');
                imageContainer.classList.add('enlarged-container');
                isEnlarged = true;
            } else {
                this.classList.remove('enlarged');
                imageContainer.classList.remove('enlarged-container');
                isEnlarged = false;
            }
        });

        // Quantity selector functionality
        const quantityInput = document.getElementById('quantity');
        const minusBtn = document.querySelector('.quantity_btn.minus');
        const plusBtn = document.querySelector('.quantity_btn.plus');

        minusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        plusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });
    });
</script>

@include('layouts.footer')
