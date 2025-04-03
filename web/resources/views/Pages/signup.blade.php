<!-- resources/views/signup.blade.php -->
@include('layouts.header')
@include('layouts.mobilemenu')

<!-- Sign Up Section -->
<div class="signup-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="signup-inner text-center">
                    <h2>Sign Up</h2>
                    @if (session('success'))
                        <p style="color: green;">{{ session('success') }}</p>
                    @endif
                    @if (session('error'))
                        <p style="color: red;">{{ session('error') }}</p>
                    @endif
                    <form id="signupForm" method="POST" action="{{ route('signup_submit') }}">
                        @csrf
                        <div class="twr_form_box">
                            <input type="text" name="full_name" placeholder="Full Name" required value="{{ old('full_name') }}">
                            @error('full_name')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="twr_form_box">
                            <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                            @error('email')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="twr_form_box">
                            <input type="tel" name="phone_number" placeholder="Phone Number"
                                   required pattern="[0-9]{10}" title="Please enter a 10-digit phone number" value="{{ old('phone_number') }}">
                            @error('phone_number')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="twr_form_box">
                            <input type="password" name="password" id="password" placeholder="Password" required>
                            @error('password')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="twr_form_box">
                            <input type="password" name="confirm_password" id="confirm_password"
                                   placeholder="Confirm Password" required>
                        </div>
                        <button type="submit" class="btn-signup" id="signupBtn">Sign Up</button>
                    </form>
                    <p>Already have an account? <a href="{{ route('login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('signupForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Passwords do not match!');
    }
});
</script>

@include('layouts.footer')
