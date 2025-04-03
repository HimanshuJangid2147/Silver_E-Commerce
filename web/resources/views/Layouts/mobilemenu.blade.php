            <!-- mobile menu -->
            <div class="mobile_logo_area">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="mobilemenu_con">
                                <div class="mobile_menu_logo text-center">
                                    <a href="{{ route('home') }}" title="juyelas">
                                        <img src="{{ asset('images/logo1.png') }}" alt="juyelas">
                                    </a>
                                </div>
                                <div class="mobile_menu_option">
                                    <div class="mobile_menu_o mobile_opicon">
                                        <i class="icofont-navigation-menu openclass"></i>
                                    </div>
                                    <div class="mobile_menu_inner mobile_p">
                                        <div class="mobile_menu_content">
                                            <div class="mobile_menu_logo text-center">
                                                <a href="{{ route('home') }}" title="juyelas">
                                                    <img src="{{ asset('images/logo1.png') }}" alt="juyelas">
                                                </a>
                                            </div>
                                            <div class="menu_area mobile-menu">
                                                <nav class="juyelas_menu">
                                                    <ul class="sub-menu">
                                                        <li><a href="{{ route('home') }}">Home</a></li>
                                                        <li><a href="{{ route('shop') }}">Product</a></li>
                                                        @if(!empty($productCategory) && $productCategory->count() > 0)
                                                        @foreach($productCategory as $category)
                                                        <li><a href="{{ route('shop', ['category_name' => $category->slug, 'category_id' => $category->category_id]) }}">{{ $category->category_name }}</a></li>
                                                        @endforeach
                                                        @else
                                                            <li><a href="#">No Categories</a></li>
                                                        @endif
                                                        <li><a href="{{ route('checkout') }}">Checkout</a></li>
                                                        <li><a href="{{ route('contact') }}">Contact</a></li>
                                                    </ul>
                                                </nav>
                                            </div>
                                            <div class="mobile_menu_o mobile_cicon">
                                                <i class="icofont-close closeclass"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mobile_overlay"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
