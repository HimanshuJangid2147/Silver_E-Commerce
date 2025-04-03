@include('layouts.header')
@include('layouts.mobilemenu')


<!-- Breadcrumb Area -->
<div class="breadcumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 txtc text-center ccase">
                <div class="brpt brptsize">
                    <h1 class="brcrumb_title">Shopping Cart</h1>
                </div>
                <div class="breadcumb-inner">
                    <ul>
                        <li>You Are Here: </li>
                        <li>-<a href="{{ route('home') }}"> Home</a></li>
                        <li>-<a href="{{ route('shop') }}"> Shop</a></li>
                        <li>-<span class="current"> Cart</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cart Area -->
<section class="shop_grid_area sec_padding shop_page_shop port_grid sopage_shop">
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

                <div class="cart-wrapper">
                    <div class="cart-table">
                        <table class="table table-hover cart-items-table">
                            <thead>
                                <tr>
                                    <th width="40%">PRODUCT</th>
                                    <th width="15%">PRICE</th>
                                    <th width="20%">QUANTITY</th>
                                    <th width="15%">TOTAL</th>
                                    <th width="10%">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($cart) && count($cart) > 0)
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @foreach ($cart as $product_id => $item)
                                        @php
                                            // Calculate discounted price
                                            $original_price = $item['price'];
                                            $discount_percentage = $item['discount'];
                                            $discounted_price = $original_price - ($original_price * $discount_percentage / 100);
                                            $item_total = $discounted_price * $item['quantity'];
                                            $subtotal += $item_total;
                                        @endphp
                                        <tr class="cart-item-row">
                                            <td>
                                                <div class="product-info">
                                                    <div class="product-name">{{ $item['name'] }}</div>
                                                    <div class="product-image">
                                                        <img src="{{ admnin_url . htmlspecialchars($item['image']) }}" alt="{{ $item['name'] }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="price-info">
                                                    @if ($discount_percentage > 0)
                                                        <div class="original-price">₹{{ number_format($original_price, 2) }}</div>
                                                        <div class="discounted-price">₹{{ number_format($discounted_price, 2) }}</div>
                                                        <div class="discount-badgee">-{{ $discount_percentage }}%</div>
                                                    @else
                                                        <div class="regular-price">₹{{ number_format($original_price, 2) }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('cart.update', $product_id) }}" method="POST" class="quantity-form">
                                                    @csrf
                                                    <div class="quantity-control">
                                                        <button type="button" class="qty-btn minus" onclick="decrementQty(this)">-</button>
                                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="qty-input">
                                                        <button type="button" class="qty-btn plus" onclick="incrementQty(this)">+</button>
                                                    </div>
                                                    <button type="submit" class="update-btn">
                                                        <i class="fa fa-refresh"></i> Update
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <div class="item-total">₹{{ number_format($item_total, 2) }}</div>
                                            </td>
                                            <td>
                                                <form action="{{ route('cart.remove', $product_id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="remove-btn">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="empty-cart">
                                            <div class="empty-cart-message">
                                                <i class="fa fa-shopping-cart fa-3x"></i>
                                                <p>Your cart is empty</p>
                                                <a href="{{ route('shop') }}" class="empty-cart-btn">Start Shopping</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    @if (!empty($cart) && count($cart) > 0)
                        <div class="cart-summary">
                            <div class="row" style="display: flex; flex-direction: column; margin-top: 20px; margin-bottom: 20px;">
                                <div class="col-md-12">
                                    <div class="cart-totals">
                                        <h3>Order Summary</h3>
                                        <table class="totals-table">
                                            <tr>
                                                <th>Subtotal</th>
                                                <td>₹{{ number_format($subtotal, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td>Free</td>
                                            </tr>
                                            <tr class="total-row">
                                                <th>Total</th>
                                                <td>₹{{ number_format($subtotal, 2) }}</td>
                                            </tr>
                                        </table>
                                        <div class="cart-actions">
                                            <a href="{{ route('shop') }}" class="continue-shopping">
                                                <i class="fa fa-arrow-left"></i> Continue Shopping
                                            </a>
                                            <a href="{{ route('checkout') }}" class="checkout-btn">
                                                Proceed to Checkout <i class="fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<style>

        /* General Styling */
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

        /* Alert Messages */
        .fade-message {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            animation: fadeOut 5s forwards;
            position: relative;
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            70% { opacity: 1; }
            100% { opacity: 0; }
        }

        /* Cart Wrapper */
        .cart-wrapper {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            padding: 30px;
            margin-bottom: 30px;
        }

        /* Cart Table */
        .cart-items-table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            overflow: hidden;
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

        .cart-item-row {
            transition: all 0.3s ease;
        }

        .cart-item-row:hover {
            background-color: #f9f9f9;
        }

        .cart-item-row td {
            padding: 20px 15px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        /* Product Info - Modified to put image on right */
        .product-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .product-image {
            width: 80px;
            height: 80px;
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
            padding-right: 10px;
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

        .discounted-price, .regular-price {
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

        /* Quantity Controls */
        .quantity-form {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
        }

        .qty-btn {
            background-color: #f8f8f8;
            border: none;
            color: #333;
            width: 30px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2em;
            transition: background-color 0.2s;
        }

        .qty-btn:hover {
            background-color: #e0e0e0;
        }

        .qty-input {
            width: 50px;
            height: 38px;
            border: none;
            text-align: center;
            font-weight: 500;
            -moz-appearance: textfield;
        }

        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .update-btn {
            background-color: #f0ad4e;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 0.9em;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .update-btn:hover {
            background-color: #ec971f;
        }

        /* Item Total */
        .item-total {
            font-weight: 600;
            font-size: 1.1em;
            color: #333;
        }

        /* Remove Button */
        .remove-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .remove-btn:hover {
            background-color: #c82333;
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

        /* Cart Summary */
        .cart-summary {
            margin-top: 30px;
        }

        .coupon-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }

        .coupon-section h4 {
            margin-bottom: 15px;
            font-size: 1.1em;
        }

        .coupon-form {
            display: flex;
            gap: 10px;
        }

        .coupon-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .coupon-btn {
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .coupon-btn:hover {
            background-color: #5a6268;
        }

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
        }

        .cart-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
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
        }

        .checkout-btn:hover {
            background-color: #d35400;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .cart-actions {
                flex-direction: column;
                gap: 15px;
            }

            .continue-shopping, .checkout-btn {
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

            .quantity-form {
                justify-content: flex-end;
            }

            .remove-btn {
                position: absolute;
                top: 10px;
                right: 10px;
            }
        }

</style>

<script>
function incrementQty(btn) {
    const input = btn.previousElementSibling;
    input.value = parseInt(input.value) + 1;
}

function decrementQty(btn) {
    const input = btn.nextElementSibling;
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

// Auto-hide alert messages
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const alerts = document.querySelectorAll('.fade-message');
        alerts.forEach(function(alert) {
            alert.style.display = 'none';
        });
    }, 5000);
});
</script>

@include('layouts.footer')
