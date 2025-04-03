@include('layouts.mobilemenu')
@include('layouts.header')
    <!-- Refer and Earn Section -->
    <div class="refer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="refer-inner text-center">
                        <h2>Refer and Earn</h2>
                        <p>Invite your friends to Juyelas and earn rewards! For every friend who signs up and makes a purchase using your referral code, you’ll get a <strong>$10 discount</strong> on your next order. Your friend gets <strong>10% off</strong> their first purchase too!</p>
                        <form id="referForm">
                            <div class="twr_form_box">
                                <input type="email" placeholder="Friend's Email Address" required>
                            </div>
                            <button type="submit" class="btn-refer">Send Referral</button>
                        </form>
                        <div class="referral-code">
                            Your Referral Code: <span>JUYELAS123</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('layouts.footer')
