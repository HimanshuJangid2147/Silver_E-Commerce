@include('layouts.header')
@include('layouts.mobilemenu')

<!-- Breadcrumb Area -->
<div class="breadcumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 txtc text-center ccase">
                <div class="brpt brptsize">
                    <h1 class="brcrumb_title">Checkout</h1>
                </div>
                <div class="breadcumb-inner">
                    <ul>
                        <li>You Are Here: </li>
                        <li>-<a href="{{ route('home') }}"> Home</a></li>
                        <li>-<a href="{{ route('shop') }}"> Shop</a></li>
                        <li>-<a href="{{ route('cart') }}"> Cart</a></li>
                        <li>-<span class="current"> Checkout</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Section -->
<section class="checkout_area sec_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="alert alert-success mb-3 fade-message">
                        <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger mb-3 fade-message">
                        <i class="fa fa-exclamation-circle mr-2"></i> {{ session('error') }}
                    </div>
                @endif
                @if (empty($cart) || count($cart) == 0)
                    <div class="cart-wrapper">
                        <div class="alert alert-warning text-center empty-cart">
                            <div class="empty-cart-message">
                                <i class="fa fa-shopping-cart fa-3x"></i>
                                <p>Your cart is empty. Please add products to your cart before checking out.</p>
                                <a href="{{ route('shop') }}" class="empty-cart-btn">Start Shopping</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="cart-wrapper">
                        <div class="order-summary-section mb-4">
                            <h3 class="section-title">Order Summary</h3>
                            <div class="cart-table">
                                <table class="table table-hover cart-items-table">
                                    <thead>
                                        <tr>
                                            <th width="50%">PRODUCT</th>
                                            <th width="20%">PRICE</th>
                                            <th width="10%">QTY</th>
                                            <th width="20%">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $calculatedSubtotal = 0;
                                            $itemDetails = null; // Initialize as null or empty array
                                        @endphp
                                        @foreach ($cart as $product_id => $item)
                                            @php
                                                // Store the last item for reference if needed
                                                $itemDetails = $item;

                                                // Calculate discounted price
                                                $original_price = $item['price'];
                                                $discount_percentage = $item['discount'];
                                                $discounted_price =
                                                    $original_price - ($original_price * $discount_percentage) / 100;
                                                $item_total = $discounted_price * $item['quantity'];
                                                $calculatedSubtotal += $item_total;
                                            @endphp
                                            <tr class="cart-item-row">
                                                <td>
                                                    <div class="product-info">
                                                        <div class="product-name">{{ $item['name'] }}</div>
                                                        <div class="product-image">
                                                            <img src="{{ admnin_url . htmlspecialchars($item['image']) }}"
                                                                alt="{{ $item['name'] }}">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="price-info">
                                                        @if ($discount_percentage > 0)
                                                            <div class="original-price">
                                                                ₹{{ number_format($original_price, 2) }}</div>
                                                            <div class="discounted-price">
                                                                ₹{{ number_format($discounted_price, 2) }}</div>
                                                            <div class="discount-badgee">-{{ $discount_percentage }}%
                                                            </div>
                                                        @else
                                                            <div class="regular-price">
                                                                ₹{{ number_format($original_price, 2) }}</div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="item-quantity">{{ $item['quantity'] }}</div>
                                                </td>
                                                <td>
                                                    <div class="item-total">₹{{ number_format($item_total, 2) }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Coupon Code Section -->
                            <div class="col-lg-12 mb-4">
                                <div class="coupon-section">
                                    <h4><i class="fa fa-tag mr-2"></i>Apply Coupon</h4>
                                    <form action="{{ route('checkout.apply.coupon') }}" method="POST"
                                        class="coupon-form">
                                        @csrf
                                        <input type="text" name="coupon_code" placeholder="Enter coupon code"
                                            class="coupon-input" value="{{ old('coupon_code') }}">
                                        <button type="submit" class="coupon-btn">Apply Coupon</button>
                                    </form>
                                    @if (session('coupon_success'))
                                        <div class="alert alert-success mt-2">
                                            {{ session('coupon_success') }}
                                            @if (session('applied_coupon'))
                                                <a href="{{ route('checkout.remove.coupon') }}"
                                                    class="remove-coupon-btn">Remove</a>
                                            @endif
                                        </div>
                                    @endif
                                    @if (session('coupon_error'))
                                        <div class="alert alert-danger mt-2">{{ session('coupon_error') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('checkout.process') }}" method="POST" class="checkout-form">
                            @csrf
                            <div class="row">

                                <!-- Billing Details -->
                                <div class="col-lg-7">
                                    <div class="billing-details-section">
                                        <h3 class="section-title">Billing Details</h3>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>First Name*</label>
                                                    <input type="text" name="first_name" class="form-control"
                                                        required value="{{ old('first_name') }}">
                                                    @error('first_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Last Name*</label>
                                                    <input type="text" name="last_name" class="form-control" required
                                                        value="{{ old('last_name') }}">
                                                    @error('last_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Email Address*</label>
                                                    <input type="email" name="email" class="form-control" required
                                                        value="{{ old('email') ?? (Auth::user() ? Auth::user()->email : '') }}">
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Address*</label>
                                                    <input type="text" name="address" class="form-control" required
                                                        value="{{ old('address') }}">
                                                    @error('address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>City*</label>
                                                    <input type="text" name="city" class="form-control"
                                                        required value="{{ old('city') }}">
                                                    @error('city')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="form-group">
                                                    <label>Postal Code*</label>
                                                    <input type="text" name="zip" class="form-control"
                                                        required value="{{ old('zip') }}">
                                                    @error('zip')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Phone*</label>
                                                    <input type="number" name="phone" class="form-control"
                                                        required
                                                        value="{{ old('phone') ?? (Auth::user() ? Auth::user()->phone_number : '') }}">
                                                    @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label>Order Notes (optional)</label>
                                                    <textarea name="notes" class="form-control" rows="4">{{ old('notes') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Summary -->
                                <div class="col-lg-5">
                                    <div class="cart-totals">
                                        <h3>Order Summary</h3>
                                        <table class="totals-table">
                                            <tr>
                                                <th>Subtotal</th>
                                                <td>₹{{ number_format($subtotal, 2) }}</td>
                                            </tr>
                                            @if (session('applied_coupon'))
                                                <tr class="coupon-row">
                                                    <th>Coupon Discount ({{ session('applied_coupon')['code'] }})</th>
                                                    {{ print_r(session('applied_coupon')) }}
                                                    <td>-₹{{ $couponDiscount }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Shipping</th>
                                                <td>Free</td>
                                            </tr>
                                            <tr class="total-row">
                                                <th>Total</th>
                                                <td>₹{{ number_format($total, 2) }}</td>
                                            </tr>
                                        </table>

                                        <div class="payment-methods mt-4">
                                            <h4>Payment Method</h4>
                                            <div class="payment-options">
                                                <div class="payment-option">
                                                    <input type="radio" id="cod" name="payment_method"
                                                        value="cod" checked>
                                                    <label for="cod">
                                                        <span class="payment-icon"><i class="fa fa-money"></i></span>
                                                        <span class="payment-name">Cash On Delivery</span>
                                                    </label>
                                                </div>
                                                <div class="payment-option">
                                                    <input type="radio" id="online" name="payment_method"
                                                        value="online">
                                                    <label for="online">
                                                        <span class="payment-icon"><i
                                                                class="fa fa-credit-card"></i></span>
                                                        <span class="payment-name">Online Payment (Credit/Debit Card,
                                                            UPI, Netbanking)</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="cart-actions">
                                            <a href="{{ route('cart') }}" class="continue-shopping">
                                                <i class="fa fa-arrow-left"></i> Back to Cart
                                            </a>
                                            <button type="submit" class="checkout-btn">
                                                Place Order <i class="fa fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    /* Breadcrumb Styling */
    .breadcumb-inner ul {
        display: flex;
        justify-content: center;
        gap: 5px;
        list-style: none;
        padding: 0;
    }

    .breadcumb-inner ul li a {
        color: #e67e22;
        text-decoration: none;
    }

    .breadcumb-inner ul li .current {
        font-weight: bold;
    }

    /* Cart Wrapper */
    .cart-wrapper {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        padding: 30px;
        margin-bottom: 30px;
    }

    /* Section Titles */
    .section-title {
        margin-bottom: 20px;
        font-size: 1.3em;
        color: #333;
        border-bottom: 2px solid #e67e22;
        padding-bottom: 10px;
        font-weight: 600;
    }

    /* Cart Table */
    .cart-items-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #f0f0f0;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 30px;
    }

    .cart-items-table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9em;
        padding: 15px;
        border-bottom: 2px solid #e67e22;
        color: #333;
        text-align: left;
    }

    .cart-item-row td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    /* Product Info */
    .product-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .product-image {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
        margin-left: 15px;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-name {
        font-weight: 500;
        font-size: 1.05em;
        color: #333;
        flex: 1;
    }

    /* Price Styling */
    .price-info {
        position: relative;
    }

    .original-price {
        color: #999;
        text-decoration: line-through;
        font-size: 0.9em;
    }

    .discounted-price,
    .regular-price {
        font-weight: 600;
        font-size: 1.1em;
        color: #333;
    }

    .discount-badgee {
        display: inline-block;
        background-color: #e74c3c;
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 0.8em;
        margin-top: 5px;
    }

    /* Item Quantity and Total */
    .item-quantity,
    .item-total {
        font-weight: 600;
        font-size: 1.1em;
        color: #333;
        text-align: center;
    }

    /* Coupon Section */
    .coupon-section {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .coupon-section h4 {
        margin-bottom: 15px;
        font-size: 1.1em;
        display: flex;
        align-items: center;
    }

    .coupon-form {
        display: flex;
        gap: 10px;
    }

    .coupon-input {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1em;
    }

    .coupon-btn {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 12px 20px;
        cursor: pointer;
        transition: background-color 0.2s;
        font-weight: 500;
    }

    .coupon-btn:hover {
        background-color: #5a6268;
    }

    /* Billing Details Form */
    .billing-details-section {
        background-color: #f9f9f9;
        padding: 25px;
        border-radius: 8px;
        height: 100%;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 1em;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: #e67e22;
        outline: none;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .text-danger {
        color: #dc3545;
        font-size: 0.85em;
        display: block;
        margin-top: 5px;
    }

    /* Order Summary */
    .cart-totals {
        background-color: #f9f9f9;
        padding: 25px;
        border-radius: 8px;
        height: 100%;
    }

    .cart-totals h3 {
        margin-bottom: 20px;
        font-size: 1.3em;
        color: #333;
        border-bottom: 2px solid #e67e22;
        padding-bottom: 10px;
        font-weight: 600;
    }

    .totals-table {
        width: 100%;
        margin-bottom: 20px;
    }

    .totals-table th,
    .totals-table td {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
    }

    .totals-table th {
        text-align: left;
        font-weight: 500;
    }

    .totals-table td {
        text-align: right;
        font-weight: 600;
    }

    .total-row {
        font-size: 1.2em;
    }

    .total-row th,
    .total-row td {
        padding-top: 20px;
        border-top: 2px solid #e67e22;
        border-bottom: none;
        color: #e67e22;
    }

    /* Payment Methods */
    .payment-methods {
        margin-top: 25px;
    }

    .payment-methods h4 {
        margin-bottom: 15px;
        font-size: 1.1em;
        font-weight: 600;
    }

    .payment-options {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .payment-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .payment-option:hover {
        border-color: #e67e22;
    }

    .payment-option input[type="radio"] {
        margin-right: 10px;
    }

    .payment-option label {
        display: flex;
        align-items: center;
        cursor: pointer;
        flex: 1;
        margin: 0;
    }

    .payment-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background-color: #f0f0f0;
        border-radius: 50%;
        margin-right: 15px;
        color: #333;
    }

    .payment-name {
        font-weight: 500;
    }

    /* Cart Actions */
    .cart-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
    }

    .continue-shopping {
        color: #6c757d;
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 6px;
        font-weight: 500;
        transition: background-color 0.2s;
    }

    .continue-shopping:hover {
        background-color: #f0f0f0;
    }

    .checkout-btn {
        background-color: #e67e22;
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.2s;
        border: none;
        cursor: pointer;
    }

    .checkout-btn:hover {
        background-color: #d35400;
    }

    /* Empty Cart */
    .empty-cart {
        padding: 50px 0 !important;
    }

    .empty-cart-message {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        color: #666;
    }

    .empty-cart-message i {
        color: #ddd;
    }

    .empty-cart-message p {
        font-size: 1.2em;
        margin: 10px 0;
    }

    .empty-cart-btn {
        background-color: #e67e22;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: background-color 0.2s;
    }

    .empty-cart-btn:hover {
        background-color: #d35400;
    }

    /* Alert Messages */
    .fade-message {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        animation: fadeOut 5s forwards;
        position: relative;
    }

    @keyframes fadeOut {
        0% {
            opacity: 1;
        }

        70% {
            opacity: 1;
        }

        100% {
            opacity: 0;
        }
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .cart-actions {
            flex-direction: column;
            gap: 15px;
        }

        .continue-shopping,
        .checkout-btn {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 768px) {
        .cart-wrapper {
            padding: 20px 15px;
        }

        .product-image {
            width: 60px;
            height: 60px;
        }

        .product-name {
            font-size: 0.95em;
        }

        .coupon-form {
            flex-direction: column;
        }
    }

    @media (max-width: 576px) {
        .cart-items-table thead {
            display: none;
        }

        .cart-item-row {
            display: block;
            border: 1px solid #eee;
            border-radius: 8px;
            margin-bottom: 20px;
            position: relative;
        }

        .cart-item-row td {
            display: block;
            text-align: right;
            padding: 10px 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .cart-item-row td:before {
            content: attr(data-label);
            float: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85em;
        }

        .product-info {
            justify-content: flex-end;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alert messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('.fade-message, .alert');
            alerts.forEach(function(alert) {
                alert.style.display = 'none';
            });
        }, 5000);

        // Style active payment method
        const paymentOptions = document.querySelectorAll('.payment-option');
        if (paymentOptions.length) {
            paymentOptions.forEach(option => {
                const radio = option.querySelector('input[type="radio"]');
                if (radio.checked) {
                    option.style.borderColor = '#e67e22';
                    option.style.backgroundColor = '#fff8f0';
                }
                radio.addEventListener('change', function() {
                    paymentOptions.forEach(opt => {
                        opt.style.borderColor = '#ddd';
                        opt.style.backgroundColor = 'transparent';
                    });
                    if (this.checked) {
                        option.style.borderColor = '#e67e22';
                        option.style.backgroundColor = '#fff8f0';
                    }
                });
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const applyCouponBtn = document.getElementById('applyCouponBtn');
        if (applyCouponBtn) {
            applyCouponBtn.addEventListener('click', function() {
                const couponCode = document.querySelector('.coupon-input').value.trim();
                if (couponCode) {
                    window.location.href = "{{ route('checkout.apply.coupon') }}?code=" +
                        encodeURIComponent(couponCode);
                } else {
                    alert('Please enter a coupon code');
                }
            });
        }
    });
</script>

@include('layouts.footer')
