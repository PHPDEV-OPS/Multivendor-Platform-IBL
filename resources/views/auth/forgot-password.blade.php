<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>TUNUNUE - Forgot Password</title>
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
    <link rel="stylesheet" href="{{ asset('frontend/amazy/compile_css/app.css') }}">
</head>

<body>
    <div class="amazy_login_area">
        <div class="amazy_login_area_left d-flex align-items-center justify-content-center">
            <div class="amazy_login_form">
                <a href="{{ route('home') }}" class="logo mb_50 d-block">
                    <img src="{{ asset('uploads/settings/67b5a3c7a2988.png') }}" alt="Tununue" title="Tununue">
                </a>
                <h3 class="m-0">Forgot Password?</h3>
                <p class="support_text">No problem. Just let us know your email address and we will email you a password reset link.</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success mb-4" style="background-color: var(--success_color); color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger mb-4" style="background-color: var(--danger_color); color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST" id="email_form">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb_20">
                            <label class="primary_label2">Email Address <span>*</span></label>
                            <input name="email" id="email" type="email" placeholder="Email Address" value="{{ old('email') }}"
                                   onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'"
                                   class="primary_input3 radius_5px @error('email') is-invalid @enderror" required autofocus>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="amaz_primary_btn style2 radius_5px w-100 text-uppercase text-center mb_25" id="send_link_btn">
                                Send Password Reset Link
                            </button>
                        </div>
                        <div class="col-12">
                            <p class="sign_up_text">Remember your password? <a href="{{ route('login') }}">Back to Login</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="amazy_login_area_right d-flex align-items-center justify-content-center">
            <div class="amazy_login_area_right_inner d-flex align-items-center justify-content-center flex-column">
                <div class="thumb">
                    <img class="img-fluid" src="{{ asset('uploads/images/19-02-2025/67b5b9534f5f7.png') }}" alt="Reset your password" title="Reset your password">
                </div>
                <div class="login_text d-flex align-items-center justify-content-center flex-column text-center">
                    <h4>Reset your password</h4>
                    <p class="m-0">Consistent quality and experience across all platforms and devices.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('frontend/amazy/compile_js/app.js') }}"></script>

    <!-- Form validation script -->
    <script>
    (function($){
        "use strict";
        $(document).ready(function(){
            // Remove any disabled attribute from submit button
            $('#send_link_btn').removeAttr('disabled');
            
            // Debug: Log form submission attempts
            console.log('Forgot password form loaded');
            
            // Form submission handler
            $(document).on('submit', '#email_form', function(event){
                console.log('Form submission attempted');
                
                // Clear previous error messages
                $('.text-danger').text('');

                let email = $('#email').val().trim();
                let val_check = 0;

                // Basic email validation
                if(email == ''){
                    $('#email').next('.text-danger').text('The email field is required.');
                    val_check = 1;
                } else if(!isValidEmail(email)) {
                    $('#email').next('.text-danger').text('Please enter a valid email address.');
                    val_check = 1;
                }

                if(val_check == 1){
                    console.log('Form validation failed');
                    event.preventDefault();
                    return false;
                }
                
                console.log('Form validation passed, submitting...');
                // If validation passes, allow form submission
                return true;
            });
            
            // Email validation function
            function isValidEmail(email) {
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
            
            // Debug: Check if CSRF token exists
            let csrfToken = $('input[name="_token"]').val();
            console.log('CSRF Token exists:', !!csrfToken);
            
            // Debug: Check form action
            let formAction = $('#email_form').attr('action');
            console.log('Form action:', formAction);
        });
    })(jQuery);
    </script>
</body>
</html>
