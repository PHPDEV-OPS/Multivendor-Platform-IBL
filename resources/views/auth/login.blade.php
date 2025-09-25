<!doctype html>
<html class="no-js" lang="zxx">

<!doctype html>
<html  class="no-js"  lang="zxx">


<!-- Mirrored from tununue.com/login by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 12 Aug 2025 18:59:56 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>TUNUNUE</title>
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
                <img src="{{ asset('uploads/settings/67b5a3c7a2988.png') }}" alt="Tununue" title="Tununue">
            </a>
            <h3 class="m-0">Sign In</h3>
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
                <img src="{{ asset('frontend/amazy/img/svg/google_icon.svg') }}" alt="Sign In with Google" title="Sign In with Google">
                <h5 class="m-0 font_16 f_w_500">Sign In with Google</h5>
            </a>
            -->

            <div class="form_sep2 d-flex align-items-center">
                <span class="sep_line flex-fill"></span>
                <span class="form_sep_text font_14 f_w_500 ">Sign in with Email or Phone</span>
                <span class="sep_line flex-fill"></span>
            </div>
            <form action="{{ route('login') }}" method="POST" name="login" id="login_form">
                @csrf
                                <div class="row">
                    <div class="col-12 mb_20">
                        <label class="primary_label2">Email address <span>*</span> </label>
                        <input name="email" id="email" placeholder="Email address" value="{{ old('email') }}"
                               onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email address'"
                               class="primary_input3 radius_5px @error('email') is-invalid @enderror" type="email" required autofocus>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 mb_20">
                        <label class="primary_label2">Password <span>*</span></label>
                        <input name="password" id="password" placeholder="Min. 8 Character"
                               onfocus="this.placeholder = ''" onblur="this.placeholder = 'Min. 8 Character'"
                               class="primary_input3 radius_5px @error('password') is-invalid @enderror" type="password" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                                        <div class="col-12 mb_20">
                        <label class="primary_checkbox d-flex">
                            <input name="remember" id="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <span class="checkmark mr_15"></span>
                            <span class="label_name f_w_400 ">Remember me</span>
                        </label>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="amaz_primary_btn style2 radius_5px  w-100 text-uppercase  text-center mb_25" id="sign_in_btn">Sign In</button>
                                            </div>
                    <div class="col-12">
                        <p class="sign_up_text">Forgot Password? <a href="{{ route('password.request') }}">Click Here</a></p>
                    </div>
                    <div class="col-12">
                        <p class="sign_up_text">Don’t have an Account? <a href="{{ route('register') }}">Sign Up</a></p>
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
        document.getElementById("login_form").submit();
    }
</script>
<script>

(function($){
    "use strict";
    $(document).ready(function(){
        $('#submit_btn').removeAttr('disabled');
        $(document).on('submit', '#login_form', function(event){

            // Clear previous error messages
            $('.text-danger').text('');

            let email = $('#email').val();
            let password = $('#password').val();

            let val_check = 0;

            if(email == ''){
                $('#email').next('.text-danger').text('The email field is required.');
                val_check = 1;
            }

            if(password == ''){
                $('#password').next('.text-danger').text('The password field is required.');
                val_check = 1;
            }

            if(val_check == 1){
                event.preventDefault();
            }
        });


    });
})(jQuery);
</script>

</body>



</html>
