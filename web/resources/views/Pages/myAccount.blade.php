@include('layouts.header')
@include('layouts.mobilemenu')

<!-- Breadcrumb Area -->
<div class="breadcumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 txtc text-center ccase">
                <div class="brpt brptsize">
                    <h1 class="brcrumb_title">My Account</h1>
                </div>
                <div class="breadcumb-inner">
                    <ul>
                        <li>You Are Here: </li>
                        <li>- <a href="{{ route('home') }}">Home</a></li>
                        <li>- <span class="current">My Account</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- My Account Area with Vertical Tabs -->
<section class="shop_grid_area sec_padding shop_page_shop port_grid sopage_shop">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="tts text-center mb-4">
                    <div class="ttin">
                        <h2 class="txbdstitle sttwo hlight">Manage Your Account</h2>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <!-- Vertical Tabs -->
                <ul class="nav flex-column nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">My Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="refer-tab" data-bs-toggle="tab" href="#refer" role="tab" aria-controls="refer" aria-selected="false">Refer Code</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="settings-tab" data-bs-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Account Settings</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
            <div class="col-lg-9">
                <!-- Tab Content -->
                <div class="tab-content" id="myTabContent">
                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h3 class="txbdstitle sttwo hlight">Profile</h3>
                        @if (session('success'))
                            <div class="alert alert-success mb-3">{{ session('success') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
                        @endif
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fullName">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" name="full_name" value="{{ old('full_name', Auth::user()->full_name) }}" readonly>
                                    @error('full_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" readonly>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}" readonly>
                                    @error('phone_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <button type="button" class="btnallt btnall btnallactive" id="editProfileBtn">Edit Profile</button>
                                    <button type="submit" class="btnallt btnall btnallactive d-none" id="saveProfileBtn">Save Changes</button>
                                    <button type="button" class="btnallt btnall btn-danger d-none" id="cancelEditBtn">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- My Orders Tab -->
                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                        <h3 class="txbdstitle sttwo hlight">My Orders</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($orders->count() > 0)
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                            <td>₹{{ number_format($order->total, 2) }}</td>
                                            <td>{{ ucfirst($order->order_status) }}</td>
                                            <td><a href="{{ route('order.view', $order->order_number) }}" class="btnallt btnall btnallactive">View</a></td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No orders found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $orders->links() }} <!-- Pagination links -->
                    </div>
                    <!-- Refer Code Tab -->
                    <div class="tab-pane fade" id="refer" role="tabpanel" aria-labelledby="refer-tab">
                        <h3 class="txbdstitle sttwo hlight">Refer Code</h3>
                        <p>Share your unique referral code with friends and earn rewards!</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="{{ Auth::user()->referral_code ?? 'JUYELAS' . Auth::user()->id }}" id="refer-code" readonly>
                            <button class="btnallt btnall btnallactive" type="button" onclick="copyReferCode()">Copy Code</button>
                        </div>
                        <p>Invite your friends to Juyelas and get ₹500 off your next purchase when they use your code!</p>
                    </div>
                    <!-- Account Settings Tab -->
                    <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                        <h3 class="txbdstitle sttwo hlight">Account Settings</h3>
                        @if (session('settings_success'))
                            <div class="alert alert-success mb-3">{{ session('settings_success') }}</div>
                        @endif
                        @if (session('settings_error'))
                            <div class="alert alert-danger mb-3">{{ session('settings_error') }}</div>
                        @endif
                        <form method="POST" action="{{ route('settings.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="currentPassword">Current Password</label>
                                <input type="password" class="form-control" id="currentPassword" name="current_password">
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="newPassword">New Password</label>
                                <input type="password" class="form-control" id="newPassword" name="new_password">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation">
                                @error('new_password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btnallt btnall btnallactive">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .nav-tabs .nav-link {
        border: none;
        border-left: 3px solid transparent;
        padding: 15px 20px;
        color: #333;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .nav-tabs .nav-link.active {
        border-left: 3px solid #e67e22;
        background-color: #f8f9fa;
        color: #e67e22;
    }

    .nav-tabs .nav-link:hover {
        background-color: #f1f1f1;
        color: #e67e22;
    }

    .tab-content {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    .btnallt {
        padding: 10px 20px;
        border-radius: 5px;
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

    .btn-danger {
        background-color: #dc3545;
        color: #fff;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .text-danger {
        font-size: 0.85em;
        display: block;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .nav-tabs {
            flex-direction: row;
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .nav-tabs .nav-link {
            padding: 10px 15px;
        }

        .tab-content {
            padding: 20px;
        }
    }
</style>

<script>
    // Edit Profile Button Functionality
    document.getElementById('editProfileBtn').addEventListener('click', function() {
        document.querySelectorAll('#profile input').forEach(input => input.removeAttribute('readonly'));
        this.classList.add('d-none');
        document.getElementById('saveProfileBtn').classList.remove('d-none');
        document.getElementById('cancelEditBtn').classList.remove('d-none');
    });

    document.getElementById('cancelEditBtn').addEventListener('click', function() {
        document.querySelectorAll('#profile input').forEach(input => {
            input.setAttribute('readonly', 'true');
            input.value = input.defaultValue; // Reset to original value
        });
        document.getElementById('editProfileBtn').classList.remove('d-none');
        document.getElementById('saveProfileBtn').classList.add('d-none');
        document.getElementById('cancelEditBtn').classList.add('d-none');
    });

    // Copy Referral Code
    function copyReferCode() {
        const referCode = document.getElementById('refer-code');
        referCode.select();
        navigator.clipboard.writeText(referCode.value)
            .then(() => alert('Referral code copied to clipboard!'))
            .catch(err => console.error('Failed to copy: ', err));
    }
</script>

@include('layouts.footer')
