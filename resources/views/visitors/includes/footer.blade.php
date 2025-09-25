    <!-- Footer Banner -->
    @include('components.promotion-banner', ['position' => 'footer'])
    
    <!-- FOOTER::START  -->
    <footer class="home_three_footer">
        <div class="main_footer_wrap">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-6 footer_links_50 ">
                        <div class="footer_widget">
                            <ul class="footer_links">
                                <li><a href="{{ route('about-us') }}">About Us</a></li>
                                <li><a href="{{ route('blogs') }}">Blog</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 footer_links_50 ">
                        <div class="footer_widget">
                            <ul class="footer_links">
                                @auth
                                    <li><a href="{{ route(Auth::user()->getDashboardRoute()) }}">Dashboard</a></li>
                                    <li><a href="{{ route('profile.edit') }}">My Profile</a></li>
                                    @if(Auth::user()->isUser())
                                        <li><a href="{{ route('user.orders') }}">My Orders</a></li>
                                    @else
                                        <li><a href="{{ route('login') }}">My Orders</a></li>
                                    @endif
                                @else
                                    <li><a href="{{ route('login') }}">Dashboard</a></li>
                                    <li><a href="{{ route('login') }}">My Profile</a></li>
                                    <li><a href="{{ route('login') }}">My Orders</a></li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-3 col-md-6">
                        <div class="footer_widget">

                            <div class="apps_boxs">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3  col-md-6">
                        <div class="footer_widget">
                            <div class="footer_title">
                                <h3>JOIN OUR MAILING LIST</h3>
                            </div>
                            <div class="subcribe-form mb_20 theme_mailChimp2" id="mc_embed_signup">
                                <form id="subscriptionForm" method="POST" action="#" class="subscription relative">
                                    @csrf
                                    <input name="email" id="subscription_email_id" class="form-control"
                                        placeholder="Enter email address" type="email" required>
                                    <div class="message_div d-none">
                                    </div>
                                    <button id="subscribeBtn" type="submit">Subscribe</button>
                                    <div class="info"></div>
                                </form>
                            </div>
                            <div class="social__Links">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright_area p-0">
            <div class="container">
                <div class="footer_border m-0"></div>
                <div class="row">
                    <div class="col-md-12">
                                                    <div class="copy_right_text d-flex align-items-center gap_20 flex-wrap justify-content-between">
                                Copyright © TUNUNUE&nbsp; LTD. <div class="footer_list_links">
                                    <a href="{{ route('contact-us') }}">Help &amp; Contact</a>
                                    <a href="{{ route('track-order') }}">Track Order</a>
                                    <a href="#" onclick="alert('Return & Exchange feature coming soon!')">Return &amp; Exchange</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Handle subscription form submission
        document.addEventListener('DOMContentLoaded', function() {
            const subscriptionForm = document.getElementById('subscriptionForm');
            const subscribeBtn = document.getElementById('subscribeBtn');
            
            if (subscriptionForm) {
                subscriptionForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const email = document.getElementById('subscription_email_id').value;
                    
                    if (!email) {
                        alert('Please enter a valid email address');
                        return;
                    }
                    
                    // Show loading state
                    subscribeBtn.textContent = 'Subscribing...';
                    subscribeBtn.disabled = true;
                    
                    // Simulate subscription (replace with actual API call)
                    setTimeout(function() {
                        alert('Thank you for subscribing to our newsletter!');
                        subscriptionForm.reset();
                        subscribeBtn.textContent = 'Subscribe';
                        subscribeBtn.disabled = false;
                    }, 1000);
                });
            }
        });
    </script>
