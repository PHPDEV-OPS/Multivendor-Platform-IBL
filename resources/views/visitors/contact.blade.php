@extends('layouts.main')

@section('content')

<!-- Contact Section -->
<div class="contact_section section_spacing6">
    <div class="container-fluid p-0">
        <div class="row justify-content-center m-0">
            <div class="col-12 p-0">
                <div class="contact_map">
                    <div id="contact-map" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-xxl-8 col-xl-9 col-md-10 mx-auto">
                <div class="contact_address">
                    <div class="row justify-content-end row-gap-60">
                        <div class="col-lg-8">
                            <div class="contact_form_box">
                                <div class="contact_info mb_30">
                                    <div class="contact_title">
                                        <h4 class="font_24 f_w_700 mb_10">Get in touch</h4>
                                    </div>
                                    <div class="contact_description">
                                        Have questions or need assistance? We're here to help! Send us a message and we'll get back to you as soon as possible.
                                    </div>
                                </div>
                                
                                <form class="form-area contact-form send_query_form" id="contactForm" action="#" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <input name="name" id="name" placeholder="Enter Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Name'" class="primary_line_input style4 mb_20" type="text" required>
                                            <span class="text-danger" id="error_name"></span>
                                        </div>

                                        <div class="col-xl-12">
                                            <input name="email" id="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="primary_line_input style4 mb_20" type="email" required>
                                            <span class="text-danger" id="error_email"></span>
                                        </div>

                                        <div class="col-xl-12">
                                            <input name="phone" id="phone" placeholder="Enter phone number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter phone number'" class="primary_line_input style4 mb_20" type="tel">
                                            <span class="text-danger" id="error_phone_number"></span>
                                        </div>

                                        <div class="col-xl-12">
                                            <select name="query_type" id="query_type" class="amaz_select2 style2 wide mb_30 nc_select" required>
                                                <option value="">Select Query Type</option>
                                                <option value="1">Order</option>
                                                <option value="2">Payment</option>
                                                <option value="3">Product</option>
                                                <option value="4">General Inquiry</option>
                                                <option value="5">Technical Support</option>
                                            </select>
                                            <span class="text-danger" id="error_query_type"></span>
                                        </div>

                                        <div class="col-xl-12">
                                            <textarea class="primary_line_textarea style4 mb_40" id="message" name="message" placeholder="Write your message here..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Write your message here...'" rows="5" required></textarea>
                                            <span class="text-danger" id="error_message"></span>
                                        </div>
                                        
                                        <div class="col-lg-12 text-right send_query_btn">
                                            <div class="alert-msg"></div>
                                            <button type="submit" id="contactBtn" class="amaz_primary_btn style2 submit-btn text-center f_w_700 text-uppercase rounded-0 w-100 btn_1">
                                                <span class="btn-text">Send Message</span>
                                                <span class="btn-loading d-none">
                                                    <i class="fas fa-spinner fa-spin"></i> Sending...
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="contact_box_wrapper">
                                <div class="contact_box mb_30">
                                    <div class="d-flex gap-15 align-items-center">
                                        <div class="icon">
                                            <svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16.2059 0.424316V2.35275C18.1133 2.35275 19.9002 2.83486 21.5666 3.79908C23.1528 4.74321 24.4177 6.00875 25.3613 7.59569C26.3251 9.26299 26.8069 11.0508 26.8069 12.9592H28.7344C28.7344 10.6892 28.1622 8.58 27.0177 6.63147C25.9135 4.74321 24.4177 3.24666 22.5304 2.14183C20.5828 0.996821 18.4747 0.424316 16.2059 0.424316ZM6.23733 3.31697C5.69524 3.31697 5.22341 3.48772 4.82186 3.82921L1.71985 6.99305L1.8102 6.93279C1.30826 7.35464 0.97698 7.87692 0.816359 8.49965C0.675815 9.12237 0.71597 9.72501 0.936825 10.3076C1.499 11.8744 2.25191 13.4814 3.19556 15.1286C4.52069 17.3986 6.09679 19.4375 7.92386 21.2454C10.8552 24.1983 14.4993 26.5285 18.8562 28.236H18.8863C19.4685 28.4369 20.0508 28.477 20.633 28.3565C21.2354 28.236 21.7674 27.9748 22.2292 27.5731L25.271 24.5298C25.6725 24.128 25.8733 23.6359 25.8733 23.0533C25.8733 22.4507 25.6725 21.9485 25.271 21.5467L21.3257 17.5693C20.9242 17.1676 20.4222 16.9667 19.8199 16.9667C19.2176 16.9667 18.7156 17.1676 18.3141 17.5693L16.4167 19.4978C14.8908 18.7746 13.5657 17.8807 12.4413 16.816C11.317 15.7313 10.4235 14.4155 9.76097 12.8688L11.6884 10.9403C12.1101 10.4984 12.3209 9.97611 12.3209 9.37347C12.3209 8.75074 12.0799 8.24855 11.5981 7.86688L11.6884 7.95727L7.65281 3.82921C7.25126 3.48772 6.77943 3.31697 6.23733 3.31697ZM16.2059 4.28119V6.20963C17.4306 6.20963 18.555 6.51095 19.579 7.11358C20.623 7.71622 21.4462 8.53982 22.0485 9.58439C22.6508 10.6089 22.952 11.7338 22.952 12.9592H24.8795C24.8795 11.3923 24.4879 9.93593 23.7049 8.59004C22.9219 7.28433 21.8778 6.23976 20.5728 5.45633C19.2276 4.6729 17.772 4.28119 16.2059 4.28119ZM6.23733 5.24541C6.29757 5.24541 6.36784 5.27554 6.44815 5.3358L10.3934 9.37347C10.4135 9.45382 10.3934 9.52413 10.3332 9.58439L7.47211 12.4168L7.68293 13.0194L8.07444 13.8631C8.39568 14.5461 8.76712 15.209 9.18875 15.8518C9.771 16.7558 10.4135 17.5292 11.1162 18.172C12.0599 19.096 13.1942 19.9397 14.5194 20.703C15.1819 21.0847 15.7441 21.3659 16.2059 21.5467L16.8082 21.8179L19.7295 18.8951C19.7697 18.8549 19.7998 18.8349 19.8199 18.8349C19.84 18.8349 19.8701 18.8549 19.9102 18.8951L23.976 22.9629C24.0161 23.0031 24.0362 23.0332 24.0362 23.0533C24.0362 23.0533 24.0161 23.0734 23.976 23.1136L20.9643 26.0966C20.5226 26.4783 20.0407 26.5787 19.5187 26.398C15.4229 24.811 12.0097 22.6415 9.2791 19.8895C7.59258 18.2021 6.11687 16.2837 4.85197 14.1343C3.94848 12.5875 3.24576 11.091 2.74382 9.64466V9.61452C2.66351 9.43373 2.65347 9.22281 2.7137 8.98176C2.77393 8.72061 2.88436 8.51973 3.04498 8.37912L6.02652 5.3358C6.08675 5.27554 6.15702 5.24541 6.23733 5.24541ZM16.2059 8.13806V10.0665C17.009 10.0665 17.6917 10.3477 18.2538 10.9102C18.816 11.4727 19.0971 12.1556 19.0971 12.9592H21.0245C21.0245 12.0954 20.8037 11.2919 20.362 10.5486C19.9403 9.80536 19.3581 9.22281 18.6152 8.80096C17.8723 8.35903 17.0692 8.13806 16.2059 8.13806Z" fill="#1A1A1C"/>
                                            </svg>
                                        </div>
                                        <div class="contact_wiz_box">
                                            <span class="contact_box_title d-block lh-1 font_14 f_w_600">Call or WhatsApp</span>
                                            <h4 class="contact_box_desc mb-0 font_16 f_w_700">+254 725 960 665</h4>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="contact_box mb_30">
                                    <div class="d-flex gap-15 align-items-center">
                                        <div class="icon">
                                            <svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6.95455 0.625V2.59624L0.75 6.63565V23.375H25.5682V6.63565L19.3636 2.59624V0.625H6.95455ZM9.02273 2.69318H17.2955V10.6428L13.1591 13.3249L9.02273 10.6428V2.69318ZM10.0568 4.76136V6.82955H16.2614V4.76136H10.0568ZM6.95455 5.0522V9.28551L3.6907 7.18501L6.95455 5.0522ZM19.3636 5.0522L22.6275 7.18501L19.3636 9.28551V5.0522ZM10.0568 7.86364V9.93182H16.2614V7.86364H10.0568ZM2.81818 9.09162L13.1591 15.7809L23.5 9.09162V21.3068H2.81818V9.09162Z" fill="#202122"/>
                                            </svg>
                                        </div>
                                        <div class="contact_wiz_box">
                                            <span class="contact_box_title d-block lh-1 font_14 f_w_600">Get in touch</span>
                                            <h4 class="contact_box_desc mb-0 font_16 f_w_700">info@tununue.com</h4>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="contact_box mb_30">
                                    <div class="d-flex gap-15 align-items-center">
                                        <div class="icon">
                                            <i class="fas fa-map-marker-alt" style="font-size: 24px; color: #ff6f20;"></i>
                                        </div>
                                        <div class="contact_wiz_box">
                                            <span class="contact_box_title d-block lh-1 font_14 f_w_600">Head office</span>
                                            <h4 class="contact_box_desc mb-0 font_16 f_w_700">Nairobi, Kenya</h4>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="contact_box">
                                    <div class="contact_wiz_box">
                                        <span class="contact_box_title d-block lh-1 mb_3 font_14 f_w_600">Business Hours</span>
                                        <div class="business_hours">
                                            <p class="mb-2 font_14"><strong>Monday - Friday:</strong> 8:00 AM - 6:00 PM</p>
                                            <p class="mb-2 font_14"><strong>Saturday:</strong> 9:00 AM - 4:00 PM</p>
                                            <p class="mb-0 font_14"><strong>Sunday:</strong> Closed</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Additional Contact Info Section -->
<div class="additional_contact_section section_spacing6 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb_50">
                <h2 class="font_32 f_w_700 mb_10">Other Ways to Reach Us</h2>
                <p class="text-muted">We're here to help you with any questions or concerns</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb_30">
                <div class="contact_card text-center p_30 bg-white rounded">
                    <div class="icon mb_20">
                        <i class="fas fa-headset" style="font-size: 48px; color: #ff6f20;"></i>
                    </div>
                    <h4 class="font_18 f_w_600 mb_10">Customer Support</h4>
                    <p class="text-muted mb_15">Get help with your orders, products, or account</p>
                    <a href="tel:+254725960665" class="amaz_primary_btn style2">Call Now</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb_30">
                <div class="contact_card text-center p_30 bg-white rounded">
                    <div class="icon mb_20">
                        <i class="fas fa-comments" style="font-size: 48px; color: #ff6f20;"></i>
                    </div>
                    <h4 class="font_18 f_w_600 mb_10">Live Chat</h4>
                    <p class="text-muted mb_15">Chat with our support team in real-time</p>
                    <button class="amaz_primary_btn style2" onclick="alert('Live chat coming soon!')">Start Chat</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb_30">
                <div class="contact_card text-center p_30 bg-white rounded">
                    <div class="icon mb_20">
                        <i class="fas fa-envelope" style="font-size: 48px; color: #ff6f20;"></i>
                    </div>
                    <h4 class="font_18 f_w_600 mb_10">Email Support</h4>
                    <p class="text-muted mb_15">Send us an email and we'll respond within 24 hours</p>
                    <a href="mailto:info@tununue.com" class="amaz_primary_btn style2">Send Email</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact_section {
    background: #fff;
}

.contact_form_box {
    background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.contact_box_wrapper {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    height: fit-content;
}

.contact_box {
    padding: 20px 0;
    border-bottom: 1px solid #eee;
}

.contact_box:last-child {
    border-bottom: none;
}

.contact_box .icon {
    min-width: 50px;
    height: 50px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
}

.contact_box .icon svg {
    width: 24px;
    height: 24px;
}

.contact_box_title {
    color: #666;
    font-size: 14px;
    margin-bottom: 5px;
}

.contact_box_desc {
    color: #333;
    font-weight: 600;
}

.business_hours p {
    margin-bottom: 8px;
    color: #666;
}

.additional_contact_section {
    background: #f8f9fa;
}

.contact_card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #eee;
}

.contact_card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.contact_card .icon {
    margin-bottom: 20px;
}

.primary_line_input.style4 {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 12px 15px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.primary_line_input.style4:focus {
    border-color: #ff6f20;
    outline: none;
    box-shadow: 0 0 0 2px rgba(255, 111, 32, 0.1);
}

.primary_line_textarea.style4 {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 12px 15px;
    font-size: 14px;
    resize: vertical;
    transition: border-color 0.3s ease;
}

.primary_line_textarea.style4:focus {
    border-color: #ff6f20;
    outline: none;
    box-shadow: 0 0 0 2px rgba(255, 111, 32, 0.1);
}

.amaz_select2.style2 {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 12px 15px;
    font-size: 14px;
    background: #fff;
    width: 100%;
}

.amaz_select2.style2:focus {
    border-color: #ff6f20;
    outline: none;
    box-shadow: 0 0 0 2px rgba(255, 111, 32, 0.1);
}

.btn-loading {
    display: none;
}

.btn-loading.show {
    display: inline-block;
}

.alert-msg {
    margin-bottom: 15px;
}

.alert-msg .alert {
    border-radius: 5px;
    padding: 12px 15px;
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .contact_form_box,
    .contact_box_wrapper {
        padding: 20px;
    }
    
    .contact_section .row-gap-60 {
        row-gap: 30px;
    }
}
</style>

<script>
(function($){
    "use strict";
    $(document).ready(function(){
        
        // Contact form submission
        $('#contactForm').on('submit', function(e){
            e.preventDefault();
            
            // Clear previous errors
            $('.text-danger').text('');
            $('.alert-msg').html('');
            
            // Get form data
            let name = $('#name').val().trim();
            let email = $('#email').val().trim();
            let phone = $('#phone').val().trim();
            let query_type = $('#query_type').val();
            let message = $('#message').val().trim();
            
            let hasError = false;
            
            // Validation
            if(name === '') {
                $('#error_name').text('Name is required');
                hasError = true;
            }
            
            if(email === '') {
                $('#error_email').text('Email is required');
                hasError = true;
            } else if(!isValidEmail(email)) {
                $('#error_email').text('Please enter a valid email address');
                hasError = true;
            }
            
            if(query_type === '') {
                $('#error_query_type').text('Please select a query type');
                hasError = true;
            }
            
            if(message === '') {
                $('#error_message').text('Message is required');
                hasError = true;
            }
            
            if(hasError) {
                return false;
            }
            
            // Show loading state
            $('#contactBtn .btn-text').addClass('d-none');
            $('#contactBtn .btn-loading').removeClass('d-none');
            $('#contactBtn').prop('disabled', true);
            
            // Simulate form submission (replace with actual AJAX call)
            setTimeout(function(){
                // Show success message
                $('.alert-msg').html('<div class="alert alert-success">Thank you! Your message has been sent successfully. We\'ll get back to you soon.</div>');
                
                // Reset form
                $('#contactForm')[0].reset();
                
                // Reset button state
                $('#contactBtn .btn-text').removeClass('d-none');
                $('#contactBtn .btn-loading').addClass('d-none');
                $('#contactBtn').prop('disabled', false);
                
                // Scroll to top
                $('html, body').animate({
                    scrollTop: $('.contact_form_box').offset().top - 100
                }, 500);
                
            }, 2000);
        });
        
        // Email validation function
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        // Initialize select2 if available
        if($.fn.select2) {
            $('#query_type').select2({
                placeholder: 'Select Query Type',
                allowClear: true
            });
        }
        
                 // Smooth scroll for anchor links
         $('a[href^="#"]').on('click', function(e) {
             e.preventDefault();
             let target = $(this.getAttribute('href'));
             if(target.length) {
                 $('html, body').animate({
                     scrollTop: target.offset().top - 100
                 }, 500);
             }
         });
     });
 })(jQuery);

// Google Maps Integration
function initMap() {
    // Nairobi, Kenya coordinates
    const nairobi = { lat: -1.2921, lng: 36.8219 };
    
    // Create the map
    const map = new google.maps.Map(document.getElementById("contact-map"), {
        zoom: 15,
        center: nairobi,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        styles: [
            {
                "featureType": "all",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#f5f5f5"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#616161"
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.stroke",
                "stylers": [
                    {
                        "color": "#f5f5f5"
                    }
                ]
            },
            {
                "featureType": "administrative.land_parcel",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#bdbdbd"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#757575"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#e5e5e5"
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                ]
            },
            {
                "featureType": "road",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#ffffff"
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#757575"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#dadada"
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#616161"
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                ]
            },
            {
                "featureType": "transit.line",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#e5e5e5"
                    }
                ]
            },
            {
                "featureType": "transit.station",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#eeeeee"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [
                    {
                        "color": "#c9c9c9"
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "labels.text.fill",
                "stylers": [
                    {
                        "color": "#9e9e9e"
                    }
                ]
            }
        ]
    });

    // Create a marker for the business location
    const marker = new google.maps.Marker({
        position: nairobi,
        map: map,
        title: "Tununue - Nairobi Office",
        icon: {
            url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="20" fill="#ff6f20"/>
                    <circle cx="20" cy="20" r="8" fill="white"/>
                    <circle cx="20" cy="20" r="4" fill="#ff6f20"/>
                </svg>
            `),
            scaledSize: new google.maps.Size(40, 40),
            anchor: new google.maps.Point(20, 40)
        }
    });

    // Create info window
    const infoWindow = new google.maps.InfoWindow({
        content: `
            <div style="padding: 10px; max-width: 200px;">
                <h4 style="margin: 0 0 5px 0; color: #ff6f20; font-size: 16px;">Tununue</h4>
                <p style="margin: 0 0 5px 0; font-size: 14px;">Nairobi, Kenya</p>
                <p style="margin: 0; font-size: 12px; color: #666;">Head Office</p>
            </div>
        `
    });

    // Add click event to marker
    marker.addListener("click", () => {
        infoWindow.open(map, marker);
    });

    // Add hover effect
    marker.addListener("mouseover", () => {
        marker.setAnimation(google.maps.Animation.BOUNCE);
    });

    marker.addListener("mouseout", () => {
        marker.setAnimation(null);
    });
}

// Load Google Maps API
function loadGoogleMapsAPI() {
    const script = document.createElement('script');
    script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap';
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);
}

// Initialize map when page loads
$(document).ready(function() {
    loadGoogleMapsAPI();
});
</script>
@endsection