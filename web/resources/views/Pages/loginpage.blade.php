<!-- resources/views/login.blade.php -->
@include('layouts.header')
@include('layouts.mobilemenu')
@if (session('status'))
    <p style="color: blue;">{{ session('status') }}</p>
@endif
<!-- Login Section -->
<div class="login-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="login-inner text-center">
                    <h2>Login</h2>
                    @if (session('success'))
                        <p style="color: green;">{{ session('success') }}</p>
                    @endif
                    @if (session('error'))
                        <p style="color: red;">{{ session('error') }}</p>
                    @endif
                    <form id="loginForm" method="POST" action="{{ route('login_submit') }}">
                        @csrf
                        <div class="twr_form_box">
                            <input type="text" name="login" placeholder="Email or Phone Number" required value="{{ old('login') }}">
                            @error('login')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="twr_form_box">
                            <input type="password" name="password" placeholder="Password" required>
                            @error('password')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn-login" id="loginBtn">Login</button>
                    </form>
                    <p>Don't have an account? <a href="{{ route('signup') }}">Sign Up</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
