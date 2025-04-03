@include('layouts.header')
@include('layouts.mobilemenu')
            <!-- Breadcrumb Area -->
            <div class="breadcumb-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 txtc text-center ccase">
                            <div class="brpt brptsize">
                                <h1 class="brcrumb_title">Order Tracking</h1>
                            </div>
                            <div class="breadcumb-inner">
                                <ul>
                                    <li>You Here!- </li>
                                    <li><a href="index.html">Home</a></li>
                                    <li> - <a href="my_account.html">My Account</a></li>
                                    <li> - <span class="current">Order Tracking</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Order Tracking Area -->
            <section class="shop_grid_area sec_padding shop_page_shop port_grid sopage_shop">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tts text-center mb-4">
                                <div class="ttin">
                                    <h2 class="txbdstitle sttwo hlight">Track Your Order</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mx-auto mb-5">
                            <!-- Tracking Form -->
                            <form id="track-form" class="mb-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="order-id" placeholder="Enter your Order ID (e.g., #12345)" required>
                                    <button type="submit" class="btnallt btnall btnallactive">Track Order</button>
                                </div>
                            </form>
                            <!-- Tracking Result -->
                            <div id="tracking-result" class="mt-3" style="display: none;">
                                <h4 class="txbdstitle">Order Status</h4>
                                <ul class="list-unstyled">
                                    <li><strong>Order ID:</strong> <span id="result-order-id"></span></li>
                                    <li><strong>Status:</strong> <span id="result-status"></span></li>
                                    <li><strong>Date:</strong> <span id="result-date"></span></li>
                                    <li><strong>Total:</strong> <span id="result-total"></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <!-- Recent Orders Table -->
                            <h3 class="txbdstitle sttwo hlight mb-3">Your Recent Orders</h3>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="recent-orders">
                                    <tr>
                                        <td>#12345</td>
                                        <td>2025-03-01</td>
                                        <td>$156.00</td>
                                        <td>Delivered</td>
                                        <td><a href="#" class="btnallt btnall btnallactive track-btn" data-order-id="#12345">Track</a></td>
                                    </tr>
                                    <tr>
                                        <td>#12346</td>
                                        <td>2025-02-28</td>
                                        <td>$356.00</td>
                                        <td>Shipped</td>
                                        <td><a href="#" class="btnallt btnall btnallactive track-btn" data-order-id="#12346">Track</a></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="text-center">No more orders found.</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center">
                                <a href="my_account.html#myaccount/orders" class="btnallt btnall btnallactive">View All Orders</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
@include('layouts.footer')
