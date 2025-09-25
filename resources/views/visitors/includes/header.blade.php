
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> TUNUNUE </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="description"
        content="Tununue is an ecommerce platform based in Kenya, revolutionizing the way people experience online shopping. By connecting buyers and sellers in a seamless, user-friendly marketplace, Tununue empowers local businesses to reach a wider audience while offering customers unparalleled access to a diverse range of products. From fashion and electronics to handmade crafts and fresh produce, Tununue brings the best of Kenya’s vibrant marketplaces to your fingertips.">
    <meta name="keywords" content="ecommerce,tununue,online,shopping">


    <!-- Web Application Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <!-- Chrome for Android theme color -->
    <meta name="theme-color" content="#000000">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Tununue">
    <link rel="icon" sizes="512x512" href="{{ asset('images/icons/icon-512x512.png') }}">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Tununue">
    <link rel="apple-touch-icon" href="{{ asset('images/icons/icon-512x512.png') }}">


    <link href="{{ asset('images/icons/splash-640x1136.png') }}"
        media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="{{ asset('images/icons/splash-750x1334.png') }}"
        media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="{{ asset('images/icons/splash-1242x2208.png') }}"
        media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)"
        rel="apple-touch-startup-image" />
    <link href="{{ asset('images/icons/splash-1125x2436.png') }}"
        media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)"
        rel="apple-touch-startup-image" />
    <link href="{{ asset('images/icons/splash-828x1792.png') }}"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="{{ asset('images/icons/splash-1242x2688.png') }}"
        media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)"
        rel="apple-touch-startup-image" />
    <link href="{{ asset('images/icons/splash-1536x2048.png') }}"
        media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="{{ asset('images/icons/splash-1668x2224.png') }}"
        media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="{{ asset('images/icons/splash-1668x2388.png') }}"
        media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />
    <link href="{{ asset('images/icons/splash-2048x2732.png') }}"
        media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)"
        rel="apple-touch-startup-image" />

    <!-- Tile for Win8 -->
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('images/icons/icon-512x512.png') }}">

    <script type="text/javascript">
        // Initialize the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('serviceworker.js', {
            scope: '.'
        }).then(function (registration) {
            // Registration was successful
        }, function (err) {
            // registration failed :(
        });
    }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/settings/67b5a3c7831f0.png') }}">
    <link rel="icon" href="{{ asset('uploads/settings/67b5a3c7831f0.png') }}" type="image/png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --background_color: #fafdff;
            --base_color: #ff6f20;
            --text_color: #121111;
            --feature_color: #f4f7f9;
            --footer_background_color: #121111;
            --footer_text_color: #f8f2f2;
            --navbar_color: #f4f7f9;
            --menu_color: #f4f7f9;
            --border_color: #e4e7e9;
            --success_color: #4bcf90;
            --warning_color: #e09079;
            --danger_color: #ff6d68;
            --base_color_10: #ff6f201a;
            --base_color_20: #ff6f2033;
            --base_color_30: #ff6f204d;
            --base_color_60: #ff6f2099;
        }

        .top_menu_icon {
            color: var(--base_color) !important;
        }

        .toast-success {
            background-color: #4bcf90 !important;
        }

        .toast-error {
            background-color: #ff6d68 !important;
        }

        .toast-warning {
            background-color: #e09079 !important;
        }

        .newsletter_form_wrapper .newsletter_form_inner .newsletter_form_thumb {
            height: 100%;
            background-image: url({{ asset('frontend/default/img/popup.png') }});
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        }

        .promotion_bar_wrapper {
            background-image: url({{ asset('uploads/images/22-02-2025/67b9bc1bbcb17.gif') }}) !important;
        }

        @media (max-width: 768px) {
            .newsletter_form_wrapper .newsletter_form_inner .newsletter_form_thumb {
                height: 100% !important;
            }
        }

        @media (max-width: 575.98px) {
            .fb_dialog_content iframe {
                bottom: 60px !important;
            }

            .newsletter_form_wrapper .newsletter_form_inner {
                width: 400px !important;
            }

            .newsletter_form_wrapper .newsletter_form_inner .newsletter_form_thumb {
                height: 600px !important;
                opacity: .3;
            }

            .newsletter_form_wrapper .newsletter_form_inner .newsletter_form {
                padding: 30px;
            }
        }

        @media (max-width: 395px) {
            .newsletter_form_wrapper .newsletter_form_inner {
                width: 385px !important;
            }

            .newsletter_form_wrapper .newsletter_form_inner .newsletter_form {
                top: 125px;
            }

            .message_div,
            .message_div_modal {
                min-height: 10px;
            }
        }

        @media (max-width: 375px) {
            .newsletter_form_wrapper .newsletter_form_inner {
                width: 345px !important;
            }

            .newsletter_form_wrapper .newsletter_form_inner {
                height: 550px !important;
            }

            .newsletter_form_wrapper .newsletter_form_inner .newsletter_form_thumb {
                height: 550px !important;
            }
        }

        @media only screen and (max-width: 896px) and (max-height: 414px) {
            .newsletter_form_wrapper .newsletter_form_inner {
                height: 410px;
            }
        }

        @media only screen and (max-width: 720px) and (max-height: 540px) {
            .newsletter_form_thumb {
                display: none !important;
            }

            .newsletter_form_wrapper .newsletter_form_inner {
                height: 335px;
                width: 600px;
            }
        }

        @media only screen and (max-width: 653px) and (max-height: 280px) {
            .newsletter_form_wrapper .newsletter_form_inner {
                height: 335px;
                width: 600px;
            }

            .newsletter_form_wrapper .newsletter_form_inner .newsletter_form h3 {
                font-size: 20px;
            }

            .newsletter_form_wrapper .newsletter_form_inner .newsletter_form p {
                margin: 5px 0 5px;
            }

            .newsletter_form_wrapper .newsletter_form_inner .close_modal {
                top: 30px;
            }
        }

        @media only screen and (max-width: 280px) and (max-height: 653px) {
            .newsletter_form_thumb {
                display: none !important;
            }

            .newsletter_form_wrapper .newsletter_form_inner {
                height: 400px !important;
                width: 260px !important;
            }

            #top_bar {
                display: none;
            }

            .newsletter_form_wrapper .newsletter_form_inner .newsletter_form {
                padding: 35px 10px;
                margin-top: 0px;
                top: 40px;
            }
        }

        .popular_search_lists .popular_search_list {
            overflow: hidden;
            word-wrap: break-word;
        }
    </style>
    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('frontend/amazy/compile_css/app.css') }}">

    <!-- Fix for missing UI icons and owl carousel images -->
    <style>
        /* Fix owl carousel video play icon */
        .owl-carousel .owl-video-play-icon {
            background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCA4MCA4MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBjeD0iNDAiIGN5PSI0MCIgcj0iNDAiIGZpbGw9InJnYmEoMCwwLDAsMC41KSIvPgo8cGF0aCBkPSJNMzAgMjVMNTUgNDBMMzAgNTVWMjVaIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4K') no-repeat center center;
            background-size: contain;
        }

        /* Fix UI icons by removing problematic background images */
        .ui-icon {
            background-image: none !important;
        }

        /* Add basic icon styles */
        .ui-icon:before {
            content: '';
            display: inline-block;
            width: 16px;
            height: 16px;
        }

        /* Hide elements that depend on missing images */
        .ui-icon-background {
            display: none !important;
        }

        /* Fix breadcrumb divider issue */
        .breadcrumb-item + .breadcrumb-item::before {
            content: "/" !important;
            float: left;
            padding-right: 0.5rem;
            color: #6c757d;
        }

        /* Alternative breadcrumb fix */
        :root {
            --bs-breadcrumb-divider: "/";
        }
    </style>
    <style>
        .banner_img {
            width: 100%;
            position: relative;
            overflow: hidden;
            display: block;
            padding-bottom: 31.5%;
        }

        .banner_img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>


    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script>
        const _config = {"currency_symbol":"KSh","currency_symbol_position":"left_with_space","decimal_limit":"2"};
        const _user_currency = [];

        // Update cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });

        function updateCartCount() {
            fetch('{{ route("cart.count") }}')
                .then(response => response.json())
                .then(data => {
                    const cartCountElements = document.querySelectorAll('.cart_count_bottom');
                    cartCountElements.forEach(element => {
                        element.textContent = data.count;
                    });
                })
                .catch(error => {
                    console.error('Error updating cart count:', error);
                });
        }
    </script>
</head>
