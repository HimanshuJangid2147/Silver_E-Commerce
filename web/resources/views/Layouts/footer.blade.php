<footer>
    <!-- footer area -->
    <div class="witrfm_area">
        <div class="footer-middle">
            <div class="container">
                <div class="row">
                    <div class="juyelas_theme_widget juyelas_f_color col-sm-12 col-md-6 col-lg-3">
                        <div class="widget widget_twr_description_widget">
                            <div class="juyelas-description-area">
                                <a href="#">
                                    <img src="{{ asset('images/logo2.png') }}" alt="image">
                                </a>
                                <p>Lorem ipsum dolor sit amet, conse
                                    elit, sedid do eiusmod temporincidi
                                    ut labore et dolore.Lorem ipsum dolor sit amet, conse
                                    elit, sedid do eiusmod
                                </p>
                                <p class="phone"><a href="#"> </a></p>
                                <div class="social-icons">
                                    <a href="#"><i class="ti-facebook"></i></a>
                                    <a href="#"><i class="fa fa-x-twitter"></i></a>
                                    <a href="#"><i class="ti-pinterest"></i></a>
                                    <a href="#"><i class="ti-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="juyelas_theme_widget juyelas_f_color col-sm-12 col-md-6 col-lg-3">
                        <div class="widget widget_nav_menu">
                            <h2 class="widget-title">Categories</h2>
                            <div class="menu-about-us-container">
                                <ul id="menu-about-us" class="menu">
                                    @if(!empty($productCategory) && $productCategory->count() > 0)
                                    @foreach($productCategory as $category)
                                    <li><a href="{{ route('shop', ['category_name' => $category->slug, 'category_id' => $category->category_id]) }}">{{ $category->category_name }}</a></li>
                                    @endforeach
                                    @else
                                        <li><a href="#">No Categories</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="juyelas_theme_widget juyelas_f_color col-sm-12 col-md-6 col-lg-3">
                        <div class="widget widget_nav_menu">
                            <h2 class="widget-title">Our Policies</h2>
                            <div class="menu-information-container">
                                <ul id="menu-information" class="menu">
                                    <li><a href="{{ route('about') }}">About Us</a></li>
                                    <li><a href="{{ route('policies.show', 'privacy-policy') }}">Privacy Policy</a></li>
                                    <li><a href="{{ route('policies.show', 'terms-and-conditions') }}">Terms and Conditions</a></li>
                                    <li><a href="{{ route('policies.show', 'shipping-and-return') }}">Shipping and Return</a></li>
                                    <li><a href="{{ route('policies.show', 'refund-policy') }}">Refund Policy</a></li>
                                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="juyelas_theme_widget juyelas_f_color col-sm-12 col-md-6 col-lg-3">
                        <div class="widget widget_mc4wp_form_widget">
                            <h2 class="widget-title">Our Newsletter</h2>
                            <form class="mc4wp-form mc4wp-form-12748" method="post">
                                <div class="mc4wp-form-fields">
                                    <p>Sign up for the latest Ice offers and
                                        exclusives.
                                    </p>
                                    <p>
                                        <input type="email" name="email" placeholder="Email Address">
                                        <button type="submit" value="Subscribe">
                                            <span>Subscribe</span>
                                        </button>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END FOOTER MIDDLE AREA -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copy-right-text">
                            <p>
                                Copyright � juyelas all rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

    <!-- JS Files -->
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/venobox.min.js') }}"></script>
    <script src="{{ asset('js/jquery.appear.js') }}"></script>
    <script src="{{ asset('js/jquery.knob.js') }}"></script>
    <script src="{{ asset('js/theme-pluginjs.js') }}"></script>
    <script src="{{ asset('js/jquery.meanmenu.js') }}"></script>
    <script src="{{ asset('js/ajax-mail.js') }}"></script>
    <script src="{{ asset('js/imagemagnifine.js') }}"></script>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('js/slider.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
