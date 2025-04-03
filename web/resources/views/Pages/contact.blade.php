@include('layouts.header')
@include('layouts.mobilemenu')
<!-- breadcumb area -->
        <div class="breadcumb-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 txtc  text-center ccase">
                        <div class="brpt brptsize">
                            <h1 class="brcrumb_title">Contact</h1>
                        </div>
                        <div class="breadcumb-inner">
                            <ul>
                                <li>You Here!- </li>
                                <li><a href="#">Home</a></li>
                                <li> -<span class="current">Contact</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End breadcumb area -->
        <!-- contact area -->
        <div class="con_page_area">
            <div class="container">
                <div class="row cont_inner">
                    <div class="col-lg-6 col-md-6">
                        <div class="cont_left">
                            <div class="apartment_area">
                                <div class="apartment_text">
                                    <h4>Our Contact</h4>
                                    <h2>Request a quote </h2>
                                </div>
                                <div class="witr_apartment_form">
                                    <form action="mail.php" method="post" id="contact-form">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6">
                                                <div class="twr_form_box">
                                                    <input type="text" name="name" placeholder="Name*">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="twr_form_box">
                                                    <input type="email" name="email" placeholder="Email*">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="twr_form_box">
                                                    <input type="number" name="number" placeholder="Phone*">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <div class="twr_form_box">
                                                    <input type="text" name="subject" placeholder="Subject*">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="twr_form_box">
                                                    <textarea name="comment" placeholder="Message*"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="contact_page_button text-left">
                                                    <button type="submit" name="ok" class="btn">Send Message</button>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 text-left">
                                                <p class="form-messege"></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="con_page_witr">
                            <div class="map_inner_area">
                                <iframe src="https://maps.google.com/maps?q=webitrangpur&t=m&z=10&output=embed&iwloc=near" title="webitrangpur"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@include('layouts.footer')
