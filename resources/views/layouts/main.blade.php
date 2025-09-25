<!doctype html>
<html class="no-js" lang="zxx">

@include('visitors.includes.header')

<body>

    @include('visitors.includes.preloader')
    <!-- preloader:end  -->
    <!-- promotion_bar_wrapper::start  -->
    <!-- position-fixed>> add this class to use this  -->
    @include('visitors.includes.promotionbar')
    <!-- promotion_bar_wrapper::end  -->

    <!-- HEADER::START -->
     <input type="hidden" id="url" value="{{ url('/') }}">
    <input type="hidden" id="just_url" value="">
    <!-- HEADER::START -->
    @include('visitors.includes.top-nav')
    <!--/ HEADER::END -->

    <!--/ HEADER::END -->


    @yield('content')

    @include('visitors.includes.footer')
    <!-- FOOTER::END  -->
    <!-- checkout_login_form:start -->
    @include('visitors.includes.checkoutloginform')
    <!-- checkout_login_form:end  -->

    <div id="cart_data_show_div">
        <!-- side_chartView_total::start  -->
        <!-- side_chartView_total::end  -->
        <!-- shoping_cart::start  -->
        <div class="shoping_wrapper d-none">
            <!-- <div class="dark_overlay"></div> -->
            <div class="shoping_cart">
                <div class="shoping_cart_inner">
                    <div class="cart_header d-flex justify-content-between">
                        <div class="cart_header_text">
                            <h4>Shoping Cart</h4>
                            <p>0 Item’s selected</p>
                        </div>
                        <div class="chart_close">
                            <i class="ti-close"></i>
                        </div>
                    </div>
                </div>
                <div class="shoping_cart_subtotal d-flex justify-content-between align-items-center">
                    <h4 class="m-0">Subtotal</h4>
                    <span>KSh 0.00</span>
                </div>
                <div class="view_checkout_btn d-flex justify-content-end mb_30 flex-column gap_10">
                    <a href="{{ route('cart') }}" class="amaz_primary_btn style2 text-uppercase ">View Shopping Cart</a>
                </div>
            </div>
        </div>
        <!-- shoping_cart::end  -->
    </div>
    <div id="cart_success_modal_div">
        <!-- wallet_modal::start  -->
        <div class="modal fade theme_modal2" id="cart_add_modal" tabindex="-1" role="dialog"
            aria-labelledby="theme_modal" aria-hidden="true">
            <div class="modal-dialog max_width_430 modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body p-0">
                        <div class="add_cart_modalAdded">
                            <button type="button" class="close_modal_icon" data-bs-dismiss="modal">
                                <i class="ti-close"></i>
                            </button>
                            <div
                                class="product_checked_box d-flex flex-column justify-content-center align-items-center">
                                <svg id="checked" width="30" height="30" viewBox="0 0 30 30">
                                    <g id="Group_1587" data-name="Group 1587" transform="translate(7.118 3.77)">
                                        <g id="Group_1586" data-name="Group 1586">
                                            <path id="Path_3246" data-name="Path 3246"
                                                d="M143.592,64.66a1.131,1.131,0,0,0-1.6,0L128.426,78.189l-4.895-5.316a1.131,1.131,0,0,0-1.664,1.532l5.692,6.182a1.13,1.13,0,0,0,.808.365h.024a1.132,1.132,0,0,0,.8-.33l14.4-14.363A1.131,1.131,0,0,0,143.592,64.66Z"
                                                transform="translate(-121.568 -64.327)" fill="#4cb473" />
                                        </g>
                                    </g>
                                    <g id="Group_1589" data-name="Group 1589">
                                        <g id="Group_1588" data-name="Group 1588">
                                            <path id="Path_3247" data-name="Path 3247"
                                                d="M28.869,13.869A1.131,1.131,0,0,0,27.739,15,12.739,12.739,0,1,1,15,2.261,1.131,1.131,0,1,0,15,0,15,15,0,1,0,30,15,1.131,1.131,0,0,0,28.869,13.869Z"
                                                fill="#4cb473" />
                                        </g>
                                    </g>
                                </svg>
                                <h4>Item added to your cart</h4>
                            </div>
                            <div class="cart_added_box">
                                <a id="cart_suceess_url"
                                    class="cart_added_box_item d-flex align-items-center gap_25 flex-sm-wrap flex-md-nowrap">
                                    <div class="thumb">
                                        <img class="img-fluid" id="cart_suceess_thumbnail"
                                            src="{{ asset('frontend/amazy/img/cart_added_thumb.png') }}"
                                            alt="" title="">
                                    </div>
                                    <div class="cart_added_content">
                                        <h4 id="cart_suceess_name"></h4>
                                        <h5 id="cart_suceess_price"></h5>
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex flex-column gap_10">
                                <a href="{{ route('cart') }}" class="amaz_primary_btn style2 text-uppercase ">View cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- wallet_modal::end  -->
    </div>
    <input type="hidden" id="login_check" value="{{ auth()->check() ? '1' : '0' }}">
    <div class="add-product-to-cart-using-modal">

    </div>

    <!-- about:start  -->
    <div class="modal fade login_modal about_modal" id="asq_about_form" tabindex="-1" role="dialog"
        aria-labelledby="asq_about_form" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div data-bs-dismiss="modal" class="close_modal">
                        <i class="ti-close"></i>
                    </div>
                    <!-- infix_login_area::start  -->
                    <div class="infix_login_area p-0">
                        <div class="login_area_inner">
                            <h3 class="sign_up_text mb_20 fs-5">Have A question?</h3>
                            <form action="#">
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea placeholder="Your Message" class="primary_textarea3 mb_20 bg-white"></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <input placeholder="Your Name" type="text"
                                            class="primary_input3 mb_20 bg-white">
                                    </div>
                                    <div class="col-md-12">
                                        <input placeholder="Email" type="email"
                                            class="primary_input3 mb_20 bg-white">
                                    </div>
                                    <div class="col-md-12">
                                        <input placeholder="Your Phone" type="text"
                                            class="primary_input3 mb_30 bg-white">
                                    </div>
                                    <div class="col-12">
                                        <button class="home10_primary_btn2 text-center f_w_700">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- infix_login_area::end  -->

                </div>
            </div>
        </div>
    </div>
    <!-- about:end  -->

    <!-- shiping_modal:start  -->
    <div class="modal fade login_modal shiping_modal" id="shiping_modal" tabindex="-1" role="dialog"
        aria-labelledby="shiping_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div data-bs-dismiss="modal" class="close_modal">
                        <i class="ti-close"></i>
                    </div>
                    <!-- infix_login_area::start  -->
                    <div class="infix_login_area p-0">
                        <div class="login_area_inner">
                            <h3 class="sign_up_text mb_10 fs-5 mt-0">SHIPPING</h3>
                            <ul class="ps-3 mb_30">
                                <li class="list_disc">Complimentary ground shipping within 1 to 7 business days</li>
                                <li class="list_disc">In-store collection available within 1 to 7 business days</li>
                                <li class="list_disc">Next-day and Express delivery options also available</li>
                                <li class="list_disc">Purchases are delivered in an orange box tied with a Bolduc
                                    ribbon, with the exception of certain items</li>
                                <li class="list_disc">See the delivery FAQs for details on shipping methods, costs and
                                    delivery times</li>
                                <li class="list_disc">Easy and complimentary, within 14 days</li>
                            </ul>
                            <h3 class="sign_up_text mb_10 fs-5 mt-0">RETURNS AND EXCHANGES</h3>
                            <ul class="ps-3">
                                <li class="list_disc">Easy and complimentary, within 14 days</li>
                                <li class="list_disc">See conditions and procedure in our return FAQs</li>
                            </ul>
                        </div>
                    </div>
                    <!-- infix_login_area::end  -->

                </div>
            </div>
        </div>
    </div>
    <!-- shiping_modal:end  -->

    <!-- size_modal:start  -->
    <div class="modal fade login_modal size_modal" id="size_modal" tabindex="-1" role="dialog"
        aria-labelledby="size_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div data-bs-dismiss="modal" class="close_modal">
                        <i class="ti-close"></i>
                    </div>
                    <!-- infix_login_area::start  -->
                    <div class="infix_login_area p-0">
                        <div class="login_area_inner text-center">
                            <h3 class="theme_text3  mb-1 fs-4 f_w_700">SIZE GUIDE</h3>
                            <p class="mb_10">This is an approximate conversion table to help you find your size.</p>
                            <div class="table-responsive">
                                <table class="table size_table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Italian</th>
                                            <th>Spanish</th>
                                            <th>German</th>
                                            <th>UK</th>
                                            <th>USA</th>
                                            <th>Japanese</th>
                                            <th>Chinese</th>
                                            <th>Russian</th>
                                            <th>Korean</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>34</td>
                                            <td>30</td>
                                            <td>28</td>
                                            <td>04</td>
                                            <td>00</td>
                                            <td>3</td>
                                            <td>155/75A</td>
                                            <td>36</td>
                                            <td>44</td>
                                        </tr>
                                        <tr>
                                            <td>34</td>
                                            <td>30</td>
                                            <td>28</td>
                                            <td>04</td>
                                            <td>00</td>
                                            <td>3</td>
                                            <td>155/75A</td>
                                            <td>36</td>
                                            <td>44</td>
                                        </tr>
                                        <tr>
                                            <td>34</td>
                                            <td>30</td>
                                            <td>28</td>
                                            <td>04</td>
                                            <td>00</td>
                                            <td>3</td>
                                            <td>155/75A</td>
                                            <td>36</td>
                                            <td>44</td>
                                        </tr>
                                        <tr>
                                            <td>34</td>
                                            <td>30</td>
                                            <td>28</td>
                                            <td>04</td>
                                            <td>00</td>
                                            <td>3</td>
                                            <td>155/75A</td>
                                            <td>36</td>
                                            <td>44</td>
                                        </tr>
                                        <tr>
                                            <td>34</td>
                                            <td>30</td>
                                            <td>28</td>
                                            <td>04</td>
                                            <td>00</td>
                                            <td>3</td>
                                            <td>155/75A</td>
                                            <td>36</td>
                                            <td>44</td>
                                        </tr>
                                        <tr>
                                            <td>34</td>
                                            <td>30</td>
                                            <td>28</td>
                                            <td>04</td>
                                            <td>00</td>
                                            <td>3</td>
                                            <td>155/75A</td>
                                            <td>36</td>
                                            <td>44</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- infix_login_area::end  -->

                </div>
            </div>
        </div>
    </div>
    <!-- size_modal:end  -->


    <!-- checkot_login_form_reg:start -->
    <div class="modal fade login_modal" id="checkot_login_form_reg" tabindex="-1" role="dialog"
        aria-labelledby="checkot_login_form_reg" aria-hidden="true">
        <div class="modal-dialog style2 modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div data-bs-dismiss="modal" class="close_modal">
                        <i class="ti-close"></i>
                    </div>
                    <!-- amaz_checkout_loginArea::start  -->
                    <div class="amaz_checkout_loginArea p-0">
                        <div class="login_area_inner">
                            <h4 class="text-start">Welcome! <br> Create an account within a minute.</h4>
                            <form action="#">
                                <div class="row">
                                    <div class="col-12">
                                        <input name="name" placeholder="Enter Name"
                                            onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Name'"
                                            class="primary_line_input mb_20" required="" type="text">

                                        <input name="email" placeholder="Type e-mail address"
                                            pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$"
                                            onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Type e-mail address'"
                                            class="primary_line_input mb_10" required="" type="email">
                                        <input name="password" placeholder="Enter password"
                                            onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Enter password'"
                                            class="primary_line_input mb-0" required="" type="password">
                                        <input name="password" placeholder="Re-enter password"
                                            onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = 'Re-enter password'"
                                            class="primary_line_input mb_10" required="" type="password">
                                    </div>
                                    <div class="col-12">
                                        <div class="remember_pass mb_55 justify-content-start">
                                            <label class="primary_checkbox d-flex ">
                                                <input checked="" type="checkbox">
                                                <span class="checkmark mr_15"></span>
                                            </label>
                                            <p class="font_14 f_w_500 mb-0 check_text">By signing up, you agree to <a
                                                    class="text_underline" href="#"> Terms of Service</a> and <a
                                                    class="text_underline">Privacy Policy.</a></p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button
                                            class="amaz_primary_btn style2 radius_5px  w-100 text-uppercase  text-center">Sign
                                            Up</button>
                                    </div>
                                    <div class="col-12">
                                        <p class="sign_up_text text-center">Already have an account? <a
                                                data-bs-toggle="modal" data-bs-dismiss="modal" href="#"
                                                data-bs-target="#checkot_login_form">Login</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- amaz_checkout_loginArea::end  -->
                </div>
            </div>
        </div>
    </div>
    <!-- checkot_login_form_reg:end  -->



    <div id="back-top" style="display: none;">
        <a title="Go to Top" href="#"><i class="fas fa-chevron-up"></i></a>
    </div>



    <!--ALL JS SCRIPTS -->
    @include('visitors.includes.scripts')

</body>

</html>
