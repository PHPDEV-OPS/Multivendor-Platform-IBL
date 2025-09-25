@extends('layouts.main')

@section('content')


    <!-- About Hero Section -->
    <section class="about_hero_section section_spacing6" style="background: linear-gradient(135deg, #ff6f20 0%, #ff8c42 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about_hero_content">
                    <h1 class="text-white mb_20 f_w_700" style="font-size: 3.5rem;">About Tununue</h1>
                    <p class="text-white mb_30" style="font-size: 1.2rem; line-height: 1.8;">
                        Revolutionizing e-commerce in Kenya by connecting buyers and sellers in a seamless,
                        user-friendly marketplace that empowers local businesses and offers customers
                        unparalleled access to diverse products.
                    </p>
                    <div class="hero_stats d-flex flex-wrap gap_30">
                        <div class="stat_item text-center">
                            <h3 class="text-white f_w_700 mb_5">1000+</h3>
                            <p class="text-white mb_0">Happy Customers</p>
                        </div>
                        <div class="stat_item text-center">
                            <h3 class="text-white f_w_700 mb_5">500+</h3>
                            <p class="text-white mb_0">Local Sellers</p>
                        </div>
                        <div class="stat_item text-center">
                            <h3 class="text-white f_w_700 mb_5">10K+</h3>
                            <p class="text-white mb_0">Products</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about_hero_image text-center">
                    <img src="{{ asset('frontend/amazy/img/about-hero.png') }}" alt="About Tununue" class="img-fluid"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display:none; background: rgba(255,255,255,0.1); padding: 60px; border-radius: 20px; color: white;">
                        <i class="fas fa-store" style="font-size: 4rem; margin-bottom: 20px;"></i>
                        <h3>Your Trusted Marketplace</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision Section -->
<section class="mission_vision_section section_spacing6">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb_30">
                <div class="mission_card h-100 p_30" style="background: #f8f9fa; border-radius: 15px; border-left: 5px solid #ff6f20;">
                    <div class="card_icon mb_20">
                        <i class="fas fa-bullseye" style="font-size: 3rem; color: #ff6f20;"></i>
                    </div>
                    <h3 class="mb_20 f_w_700">Our Mission</h3>
                    <p class="mb_0" style="line-height: 1.8; color: #666;">
                        To empower local businesses in Kenya by providing them with a digital platform to reach
                        wider audiences while offering customers convenient access to quality products from
                        trusted local sellers.
                    </p>
                </div>
            </div>
            <div class="col-lg-6 mb_30">
                <div class="vision_card h-100 p_30" style="background: #f8f9fa; border-radius: 15px; border-left: 5px solid #ff6f20;">
                    <div class="card_icon mb_20">
                        <i class="fas fa-eye" style="font-size: 3rem; color: #ff6f20;"></i>
                    </div>
                    <h3 class="mb_20 f_w_700">Our Vision</h3>
                    <p class="mb_0" style="line-height: 1.8; color: #666;">
                        To become Kenya's leading e-commerce platform, fostering economic growth by connecting
                        communities through technology and creating opportunities for local entrepreneurs to thrive
                        in the digital economy.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- What We Offer Section -->
<section class="services_section section_spacing6" style="background: #f8f9fa;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb_50">
                <h2 class="f_w_700 mb_20">What We Offer</h2>
                <p class="mb_0" style="color: #666; font-size: 1.1rem;">
                    Discover the comprehensive services that make Tununue your preferred shopping destination
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb_30">
                <div class="service_card text-center p_30 h-100" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <div class="service_icon mb_20">
                        <i class="fas fa-shopping-cart" style="font-size: 3rem; color: #ff6f20;"></i>
                    </div>
                    <h4 class="mb_15 f_w_600">Diverse Product Range</h4>
                    <p class="mb_0" style="color: #666; line-height: 1.6;">
                        From fashion and electronics to handmade crafts and fresh produce,
                        find everything you need in one place.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb_30">
                <div class="service_card text-center p_30 h-100" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <div class="service_icon mb_20">
                        <i class="fas fa-shield-alt" style="font-size: 3rem; color: #ff6f20;"></i>
                    </div>
                    <h4 class="mb_15 f_w_600">Secure Transactions</h4>
                    <p class="mb_0" style="color: #666; line-height: 1.6;">
                        Shop with confidence knowing your payments are protected with
                        state-of-the-art security measures.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb_30">
                <div class="service_card text-center p_30 h-100" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <div class="service_icon mb_20">
                        <i class="fas fa-truck" style="font-size: 3rem; color: #ff6f20;"></i>
                    </div>
                    <h4 class="mb_15 f_w_600">Fast Delivery</h4>
                    <p class="mb_0" style="color: #666; line-height: 1.6;">
                        Enjoy quick and reliable delivery services across Kenya,
                        with real-time tracking for your orders.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb_30">
                <div class="service_card text-center p_30 h-100" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <div class="service_icon mb_20">
                        <i class="fas fa-headset" style="font-size: 3rem; color: #ff6f20;"></i>
                    </div>
                    <h4 class="mb_15 f_w_600">24/7 Support</h4>
                    <p class="mb_0" style="color: #666; line-height: 1.6;">
                        Our dedicated customer support team is always ready to help
                        you with any questions or concerns.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb_30">
                <div class="service_card text-center p_30 h-100" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <div class="service_icon mb_20">
                        <i class="fas fa-mobile-alt" style="font-size: 3rem; color: #ff6f20;"></i>
                    </div>
                    <h4 class="mb_15 f_w_600">Mobile Friendly</h4>
                    <p class="mb_0" style="color: #666; line-height: 1.6;">
                        Shop on the go with our mobile-optimized platform that works
                        seamlessly on all devices.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb_30">
                <div class="service_card text-center p_30 h-100" style="background: white; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                    <div class="service_icon mb_20">
                        <i class="fas fa-handshake" style="font-size: 3rem; color: #ff6f20;"></i>
                    </div>
                    <h4 class="mb_15 f_w_600">Local Business Support</h4>
                    <p class="mb_0" style="color: #666; line-height: 1.6;">
                        We're committed to supporting local entrepreneurs and helping
                        them grow their businesses online.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why_choose_section section_spacing6">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb_30">
                <div class="why_choose_content">
                    <h2 class="f_w_700 mb_30">Why Choose Tununue?</h2>
                    <div class="feature_list">
                        <div class="feature_item d-flex align-items-start mb_20">
                            <div class="feature_icon me_20">
                                <i class="fas fa-check-circle" style="color: #ff6f20; font-size: 1.5rem;"></i>
                            </div>
                            <div class="feature_text">
                                <h5 class="mb_5 f_w_600">Trusted Local Sellers</h5>
                                <p class="mb_0" style="color: #666;">All our sellers are verified and trusted local businesses</p>
                            </div>
                        </div>
                        <div class="feature_item d-flex align-items-start mb_20">
                            <div class="feature_icon me_20">
                                <i class="fas fa-check-circle" style="color: #ff6f20; font-size: 1.5rem;"></i>
                            </div>
                            <div class="feature_text">
                                <h5 class="mb_5 f_w_600">Quality Guarantee</h5>
                                <p class="mb_0" style="color: #666;">We ensure all products meet our quality standards</p>
                            </div>
                        </div>
                        <div class="feature_item d-flex align-items-start mb_20">
                            <div class="feature_icon me_20">
                                <i class="fas fa-check-circle" style="color: #ff6f20; font-size: 1.5rem;"></i>
                            </div>
                            <div class="feature_text">
                                <h5 class="mb_5 f_w_600">Easy Returns</h5>
                                <p class="mb_0" style="color: #666;">Simple and hassle-free return process</p>
                            </div>
                        </div>
                        <div class="feature_item d-flex align-items-start mb_20">
                            <div class="feature_icon me_20">
                                <i class="fas fa-check-circle" style="color: #ff6f20; font-size: 1.5rem;"></i>
                            </div>
                            <div class="feature_text">
                                <h5 class="mb_5 f_w_600">Competitive Prices</h5>
                                <p class="mb_0" style="color: #666;">Best prices guaranteed with regular deals and discounts</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb_30">
                <div class="why_choose_image text-center">
                    <img src="{{ asset('frontend/amazy/img/why-choose.png') }}" alt="Why Choose Tununue" class="img-fluid"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                    <div style="display:none; background: #f8f9fa; padding: 60px; border-radius: 20px;">
                        <i class="fas fa-star" style="font-size: 4rem; color: #ff6f20; margin-bottom: 20px;"></i>
                        <h3>Excellence in Service</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="contact_cta_section section_spacing6" style="background: linear-gradient(135deg, #ff6f20 0%, #ff8c42 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="text-white f_w_700 mb_20">Ready to Start Shopping?</h2>
                <p class="text-white mb_30" style="font-size: 1.1rem;">
                    Join thousands of satisfied customers who trust Tununue for their online shopping needs.
                </p>
                <div class="cta_buttons">
                    <a href="{{ url('/') }}" class="amaz_primary_btn style2 me_20 mb_20">Start Shopping</a>
                    <a href="{{ url('/contact') }}" class="amaz_primary_btn style3 mb_20">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
