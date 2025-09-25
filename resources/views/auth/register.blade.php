<!doctype html>
<html class="no-js" lang="zxx">

<!doctype html>
<html  class="no-js"  lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('uploads/settings/67b5a3c7831f0.png') }}">

        <style>

        :root {
            --background_color : #fafdff;
            --base_color : #ff6f20;
            --text_color : #121111;
            --feature_color : #f4f7f9;
            --footer_background_color : #121111;
            --footer_text_color : #f8f2f2;
            --navbar_color : #f4f7f9;
            --menu_color : #f4f7f9;
            --border_color : #e4e7e9;
            --success_color : #4bcf90;
            --warning_color : #e09079;
            --danger_color : #ff6d68;
        }
    </style>
    <!-- CSS here -->
        <link rel="stylesheet"  href="{{ asset('frontend/amazy/compile_css/app.css') }}" >

        <!-- CSS here -->
</head>

<div class="amazy_login_area">
    <div class="amazy_login_area_left d-flex align-items-center justify-content-center">
        <div class="amazy_login_form">
            <a href="{{ route('home') }}" class="logo mb_50 d-block">
                <img src="{{ asset('uploads/settings/67b5a3c7a2988.png') }}" alt="{{ config('app.name', 'Laravel') }}" title="{{ config('app.name', 'Laravel') }}">
            </a>
            <h3 class="m-0">Sign Up</h3>
            <p class="support_text">See your growth and get consulting support!</p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <br>
            <!-- Google Login (Optional - can be implemented later) -->
            <!--
            <a href="#" class="google_logIn d-flex align-items-center justify-content-center">
                <img src="{{ asset('frontend/amazy/img/svg/google_icon.svg') }}" alt="Sign Up with Google" title="Sign Up with Google">
                <h5 class="m-0 font_16 f_w_500">Sign Up with Google</h5>
            </a>
            -->

            <div class="form_sep2 d-flex align-items-center">
                <span class="sep_line flex-fill"></span>
                <span class="form_sep_text font_14 f_w_500 ">Sign up with Email or Phone</span>
                <span class="sep_line flex-fill"></span>
            </div>

            <form action="{{ route('register') }}" method="POST" name="register" id="register_form">
                @csrf
                <!-- Default role for regular user registration -->
                <input type="hidden" name="role" value="user">
                <div class="row">
                    <div class="col-12 mb_20">
                        <label class="primary_label2">First Name <span>*</span></label>
                        <input name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="First Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'First Name'" class="primary_input3 radius_5px @error('first_name') is-invalid @enderror" type="text" required>
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mb_20">
                        <label class="primary_label2">Last Name</label>
                        <input name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Last Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last Name'" class="primary_input3 radius_5px @error('last_name') is-invalid @enderror" type="text">
                        @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mb_20">
                        <label class="primary_label2">Phone Or Email <span>*</span></label>
                        <input name="email" id="email" value="{{ old('email') }}" placeholder="Phone Or Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email or Phone'" class="primary_input3 radius_5px @error('email') is-invalid @enderror" type="text" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mb_20">
                        <label for="referral_code" class="primary_label2">Referral code (optional)</label>
                        <input name="referral_code" id="referral_code" value="{{ old('referral_code') }}" placeholder="Referral Code" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Referral Code'" class="primary_input3 radius_5px @error('referral_code') is-invalid @enderror" type="text">
                        @error('referral_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mb_20">
                        <label class="primary_label2">Password <span>*</span></label>
                        <input name="password" id="password" placeholder="Min. 8 Character" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Min. 8 Character'" class="primary_input3 radius_5px @error('password') is-invalid @enderror" type="password" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mb_20">
                        <label class="primary_label2" for="password-confirm">Confirm password <span>*</span></label>
                        <input name="password_confirmation" id="password-confirm" placeholder="Min. 8 Character" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Min. 8 Character'" class="primary_input3 radius_5px @error('password_confirmation') is-invalid @enderror" type="password" required>
                        @error('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 mb_20">
                        <label class="primary_checkbox d-flex">
                            <input id="policyCheck" type="checkbox" required>
                            <span class="checkmark mr_15"></span>
                            <span class="label_name f_w_400">By signing up, you agree to <a href="#" onclick="alert('Terms of Service page coming soon')">Terms of Service</a> and <a href="#" onclick="alert('Privacy Policy page coming soon')">Privacy Policy</a></span>
                        </label>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="amaz_primary_btn style2 radius_5px  w-100 text-uppercase  text-center mb_25" id="sign_in_btn">Sign Up</button>
                    </div>

                    <div class="col-12">
                        <p class="sign_up_text">Already have an Account? <a href="{{ route('login') }}">Sign In</a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="amazy_login_area_right d-flex align-items-center justify-content-center">
        <div class="amazy_login_area_right_inner d-flex align-items-center justify-content-center flex-column">
            <div class="thumb">
                <img class="img-fluid" src="{{ asset('uploads/images/19-02-2025/67b5b921ab625.png') }}" alt="Get an easy online shopping experience" title="Get an easy online shopping experience">
            </div>
            <div class="login_text d-flex align-items-center justify-content-center flex-column text-center">
                <h4>Get an easy online shopping experience.</h4>
                <p class="m-0">Consistent quality products and customer service..</p>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('frontend/amazy/compile_js/app.js') }}"></script>

<!-- Remove Google reCAPTCHA for now -->
<!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->
<script>
    function onSubmit(token) {
        document.getElementById("register_form").submit();
    }
</script>
<script>

(function($){
    "use strict";
    $(document).ready(function(){
        $(document).on('submit', '#register_form', function(event){
            let policyCheck = $('#policyCheck').prop('checked');

            if(!policyCheck){
                alert('Please agree with our policy privacy');
                event.preventDefault();
                return false;
            }
        });
    });
})(jQuery);
</script>

</body>

</html>
