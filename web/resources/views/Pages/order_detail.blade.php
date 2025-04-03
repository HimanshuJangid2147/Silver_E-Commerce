@include('layouts.header')
@include('layouts.mobilemenu')

<!-- Breadcrumb Area -->
<div class="breadcumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 txtc text-center ccase">
                <div class="brpt brptsize">
                    <h1 class="brcrumb_title">Order Details</h1>
                </div>
                <div class="breadcumb-inner">
                    <ul>
                        <li>You Are Here: </li>
                        <li>- <a href="{{ route('home') }}">Home</a></li>
                        <li>- <a href="{{ route('myaccount') }}">My Account</a></li>
                        <li>- <span class="current">Order Details</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Area -->
<section class="confirmation_area sec_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="confirmation_box">
                    <div class="confirmation_header text-center">
                        <i class="fa fa-shopping-bag confirmation_icon"></i>
                        <h2>Order Details</h2>
                        <p>View the details of your order below</p>
                    </div>

                    <div class="order_details">
                        <div class="order_number">
                            <h4>Order Number: <span>{{ $order->order_number }}</span></h4>
                            <p>Date: {{ $order->created_at->format('F d, Y') }}</p>
                        </div>

                        <div class="order_summary">
                            <h4>Order Summary</h4>
                            <table class="order_items_table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>
                                                @if ($item->discount > 0)
                                                    <span
                                                        class="original_price">₹{{ number_format($item->price, 2) }}</span>
                                                    <span
                                                        class="discounted_price">₹{{ number_format($item->price - ($item->price * $item->discount) / 100, 2) }}</span>
                                                @else
                                                    ₹{{ number_format($item->price, 2) }}
                                                @endif
                                            </td>
                                            <td>₹{{ number_format($item->total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right">Subtotal:</td>
                                        <td>₹{{ number_format($order->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right">Coupon Discount:</td>
                                        <td>- ₹{{ number_format($order->discount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-right">Shipping:</td>
                                        <td>{{ $order->shipping > 0 ? '₹' . number_format($order->shipping, 2) : 'Free' }}
                                        </td>
                                    </tr>
                                    <tr class="total_row">
                                        <td colspan="3" class="text-right">Total:</td>
                                        <td>₹{{ number_format($order->total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="customer_details">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Billing Details</h4>
                                    <ul>
                                        <li><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}
                                        </li>
                                        <li><strong>Email:</strong> {{ $order->email }}</li>
                                        <li><strong>Phone:</strong> {{ $order->phone }}</li>
                                        <li><strong>Address:</strong> {{ $order->address }}</li>
                                        <li><strong>City:</strong> {{ $order->city }}</li>
                                        <li><strong>Zip:</strong> {{ $order->zip }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h4>Payment Information</h4>
                                    <ul>
                                        <li><strong>Payment Method:</strong>
                                            {{ $order->payment_method == 'cod' ? 'Cash On Delivery' : 'Online Payment' }}
                                        </li>
                                        <li><strong>Payment Status:</strong>
                                            <span
                                                class="status_badge {{ $order->payment_status == 'paid' ? 'status_success' : 'status_pending' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </li>
                                        <li><strong>Order Status:</strong>
                                            <span class="status_badge status_pending">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="action_buttons text-center mt-4">
                        <a href="{{ route('my.orders') }}" class="continue_shopping_btn">Back to My Orders</a>
                        <a href="{{ route('shop') }}" class="my_orders_btn">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .confirmation_area {
        padding: 60px 0;
        background-color: #f7f7f7;
    }

    .confirmation_box {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        padding: 40px;
        margin-bottom: 30px;
    }

    .confirmation_header {
        margin-bottom: 30px;
    }

    .confirmation_icon {
        font-size: 80px;
        color: #e67e22;
        margin-bottom: 20px;
        display: block;
    }

    .confirmation_header h2 {
        font-size: 32px;
        margin-bottom: 10px;
        color: #333;
        font-weight: 600;
    }

    .confirmation_header p {
        font-size: 16px;
        color: #666;
    }

    .order_details {
        border-top: 1px solid #eee;
        padding-top: 30px;
    }

    .order_number {
        margin-bottom: 25px;
    }

    .order_number h4 {
        font-size: 18px;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .order_number h4 span {
        font-weight: 400;
        color: #555;
    }

    .order_number p {
        color: #777;
        font-size: 14px;
    }

    .order_summary h4 {
        font-size: 20px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .order_items_table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .order_items_table th,
    .order_items_table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .order_items_table th {
        background-color: #f9f9f9;
        font-weight: 600;
        color: #333;
    }

    .order_items_table tbody tr:hover {
        background-color: #f9f9f9;
    }

    .original_price {
        text-decoration: line-through;
        color: #999;
        margin-right: 5px;
        font-size: 13px;
    }

    .discounted_price {
        color: #e74c3c;
        font-weight: 600;
    }

    .order_items_table tfoot tr td {
        padding: 12px 15px;
        text-align: right;
        font-weight: 500;
    }

    .total_row td {
        font-weight: 700 !important;
        font-size: 18px;
        color: #222;
        border-top: 2px solid #eee;
    }

    .customer_details {
        margin-top: 30px;
        border-top: 1px solid #eee;
        padding-top: 30px;
    }

    .customer_details h4 {
        font-size: 18px;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .customer_details ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .customer_details ul li {
        margin-bottom: 8px;
        font-size: 14px;
        color: #555;
    }

    .customer_details ul li strong {
        color: #333;
        margin-right: 5px;
    }

    .status_badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
    }

    .status_success {
        background-color: #d4edda;
        color: #155724;
    }

    .status_pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .action_buttons {
        margin-top: 40px;
    }

    .continue_shopping_btn,
    .my_orders_btn {
        display: inline-block;
        padding: 12px 25px;
        border-radius: 4px;
        font-weight: 600;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s ease;
        margin: 0 10px;
    }

    .continue_shopping_btn {
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        color: #333;
    }

    .continue_shopping_btn:hover {
        background-color: #e9ecef;
        color: #333;
    }

    .my_orders_btn {
        background-color: #e67e22;
        border: 1px solid #e67e22;
        color: #fff;
    }

    .my_orders_btn:hover {
        background-color: #d35400;
        border-color: #d35400;
        color: #fff;
    }

    @media (max-width: 768px) {
        .confirmation_box {
            padding: 25px;
        }

        .confirmation_icon {
            font-size: 60px;
        }

        .confirmation_header h2 {
            font-size: 24px;
        }

        .customer_details .col-md-6:last-child {
            margin-top: 30px;
        }

        .continue_shopping_btn,
        .my_orders_btn {
            display: block;
            margin: 10px auto;
            max-width: 220px;
        }
    }
</style>

@include('layouts.footer')
