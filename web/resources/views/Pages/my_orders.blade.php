@include('layouts.header')
@include('layouts.mobilemenu')

<!-- Breadcrumb Area -->
<div class="breadcumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 txtc text-center ccase">
                <div class="brpt brptsize">
                    <h1 class="brcrumb_title">My Orders</h1>
                </div>
                <div class="breadcumb-inner">
                    <ul>
                        <li>You Are Here: </li>
                        <li>- <a href="{{ route('home') }}">Home</a></li>
                        <li>- <a href="{{ route('myaccount') }}">My Account</a></li>
                        <li>- <span class="current">My Orders</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- My Orders Area -->
<section class="confirmation_area sec_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="confirmation_box">
                    <div class="confirmation_header text-center">
                        <i class="fa fa-shopping-cart confirmation_icon"></i>
                        <h2>My Orders</h2>
                        <p>View your order history below</p>
                    </div>

                    <div class="order_details">
                        @if (session('success'))
                            <div class="alert alert-success mb-4">
                                <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger mb-4">
                                <i class="fa fa-exclamation-circle mr-2"></i> {{ session('error') }}
                            </div>
                        @endif

                        <div class="order_summary">
                            <table class="order_items_table">
                                <thead>
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Payment Status</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($orders->count() > 0)
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->order_number }}</td>
                                                <td>{{ $order->created_at->format('F d, Y') }}</td>
                                                <td>₹{{ number_format($order->total, 2) }}</td>
                                                <td>
                                                    <span class="status_badge {{ $order->payment_status == 'paid' ? 'status_success' : 'status_pending' }}">
                                                        {{ ucfirst($order->payment_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="status_badge status_pending">
                                                        {{ ucfirst($order->order_status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('order.view', $order->order_number) }}" class="btnallt btnall btnallactive">View Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">No orders found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <!-- Pagination Links -->
                            <div class="pagination_area">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>

                    <div class="action_buttons text-center mt-4">
                        <a href="{{ route('myaccount') }}" class="continue_shopping_btn">Back to My Account</a>
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

.order_summary {
    margin-bottom: 30px;
}

.order_items_table {
    width: 100%;
    border-collapse: collapse;
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

.order_items_table td.text-center {
    text-align: center;
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

.btnallt {
    padding: 10px 20px; /* Updated to match myAccount.blade.php */
    border-radius: 4px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btnallactive {
    background-color: #e67e22;
    color: #fff;
    border: none;
}

.btnallactive:hover {
    background-color: #d35400;
}

.pagination_area {
    margin-top: 20px;
    text-align: center;
}

.pagination_area .pagination {
    justify-content: center;
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

    .order_items_table th,
    .order_items_table td {
        padding: 10px;
        font-size: 14px;
    }

    .btnallt {
        padding: 8px 15px;
        font-size: 14px;
    }

    .continue_shopping_btn,
    .my_orders_btn {
        display: block;
        margin: 10px auto;
        max-width: 220px;
    }
}

@media (max-width: 576px) {
    .order_items_table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
}
</style>

@include('layouts.footer')
