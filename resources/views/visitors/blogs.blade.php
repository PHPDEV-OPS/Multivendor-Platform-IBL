@extends('layouts.main')

@section('content')
<!-- Banner Section -->
<div class="banner_section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @include('visitors.includes.banner')
            </div>
        </div>
    </div>
</div>

<!-- Blog Section -->
<div class="amazy_blog_section section_spacing6">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <!-- Blog Header -->
                <div class="blog_header mb_30">
                    <h2 class="font_24 f_w_700 mb_10">Latest Blog Posts</h2>
                    <p class="text-muted">Discover the latest insights, tips, and stories from our community</p>
                </div>
                
                <div class="row">
                    <!-- Sample Blog Post 1 -->
                    <div class="col-lg-6 col-md-6 mb_30">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog_img">
                                    <a href="#">
                                        <img class="img-fluid" src="{{ asset('uploads/images/22-02-2025/67b9bfd32db59.webp') }}" alt="Blog Post 1" title="Blog Post 1">
                                    </a>
                                </div>
                                <div class="blog_content p_20">
                                    <div class="blog_meta d-flex align-items-center mb_10">
                                        <span class="date font_12 f_w_400">January 15, 2025</span>
                                        <span class="category font_12 f_w_400 ml_20">Technology</span>
                                    </div>
                                    <h4 class="font_16 f_w_600 mb_10">
                                        <a href="#" class="text-dark">The Future of E-commerce: Trends to Watch in 2025</a>
                                    </h4>
                                    <p class="font_14 f_w_400 text-muted mb_15">
                                        Discover the latest trends shaping the future of online shopping and how they will impact your business...
                                    </p>
                                    <a href="#" class="read_more font_14 f_w_500">Read More <i class="ti-arrow-right ml_5"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sample Blog Post 2 -->
                    <div class="col-lg-6 col-md-6 mb_30">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog_img">
                                    <a href="#">
                                        <img class="img-fluid" src="{{ asset('uploads/images/22-02-2025/67b9bfe9bb5de.webp') }}" alt="Blog Post 2" title="Blog Post 2">
                                    </a>
                                </div>
                                <div class="blog_content p_20">
                                    <div class="blog_meta d-flex align-items-center mb_10">
                                        <span class="date font_12 f_w_400">January 12, 2025</span>
                                        <span class="category font_12 f_w_400 ml_20">Business</span>
                                    </div>
                                    <h4 class="font_16 f_w_600 mb_10">
                                        <a href="#" class="text-dark">10 Essential Tips for Successful Online Business</a>
                                    </h4>
                                    <p class="font_14 f_w_400 text-muted mb_15">
                                        Learn the key strategies and best practices that successful online entrepreneurs use to grow their businesses...
                                    </p>
                                    <a href="#" class="read_more font_14 f_w_500">Read More <i class="ti-arrow-right ml_5"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sample Blog Post 3 -->
                    <div class="col-lg-6 col-md-6 mb_30">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog_img">
                                    <a href="#">
                                        <img class="img-fluid" src="{{ asset('uploads/images/22-02-2025/67b9c001dae04.webp') }}" alt="Blog Post 3" title="Blog Post 3">
                                    </a>
                                </div>
                                <div class="blog_content p_20">
                                    <div class="blog_meta d-flex align-items-center mb_10">
                                        <span class="date font_12 f_w_400">January 10, 2025</span>
                                        <span class="category font_12 f_w_400 ml_20">Marketing</span>
                                    </div>
                                    <h4 class="font_16 f_w_600 mb_10">
                                        <a href="#" class="text-dark">Digital Marketing Strategies That Actually Work</a>
                                    </h4>
                                    <p class="font_14 f_w_400 text-muted mb_15">
                                        Explore proven digital marketing techniques that can help you reach your target audience and drive sales...
                                    </p>
                                    <a href="#" class="read_more font_14 f_w_500">Read More <i class="ti-arrow-right ml_5"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sample Blog Post 4 -->
                    <div class="col-lg-6 col-md-6 mb_30">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog_img">
                                    <a href="#">
                                        <img class="img-fluid" src="{{ asset('uploads/images/22-02-2025/67b9c01735d51.webp') }}" alt="Blog Post 4" title="Blog Post 4">
                                    </a>
                                </div>
                                <div class="blog_content p_20">
                                    <div class="blog_meta d-flex align-items-center mb_10">
                                        <span class="date font_12 f_w_400">January 8, 2025</span>
                                        <span class="category font_12 f_w_400 ml_20">Customer Service</span>
                                    </div>
                                    <h4 class="font_16 f_w_600 mb_10">
                                        <a href="#" class="text-dark">Building Customer Loyalty in the Digital Age</a>
                                    </h4>
                                    <p class="font_14 f_w_400 text-muted mb_15">
                                        Discover how to create lasting relationships with your customers through excellent service and engagement...
                                    </p>
                                    <a href="#" class="read_more font_14 f_w_500">Read More <i class="ti-arrow-right ml_5"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sample Blog Post 5 -->
                    <div class="col-lg-6 col-md-6 mb_30">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog_img">
                                    <a href="#">
                                        <img class="img-fluid" src="{{ asset('uploads/images/22-02-2025/67b9c032f17bb.webp') }}" alt="Blog Post 5" title="Blog Post 5">
                                    </a>
                                </div>
                                <div class="blog_content p_20">
                                    <div class="blog_meta d-flex align-items-center mb_10">
                                        <span class="date font_12 f_w_400">January 5, 2025</span>
                                        <span class="category font_12 f_w_400 ml_20">Productivity</span>
                                    </div>
                                    <h4 class="font_16 f_w_600 mb_10">
                                        <a href="#" class="text-dark">Productivity Hacks for Entrepreneurs</a>
                                    </h4>
                                    <p class="font_14 f_w_400 text-muted mb_15">
                                        Learn time management techniques and productivity tools that can help you work smarter, not harder...
                                    </p>
                                    <a href="#" class="read_more font_14 f_w_500">Read More <i class="ti-arrow-right ml_5"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sample Blog Post 6 -->
                    <div class="col-lg-6 col-md-6 mb_30">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog_img">
                                    <a href="#">
                                        <img class="img-fluid" src="{{ asset('uploads/images/22-02-2025/67b9c052c0585.webp') }}" alt="Blog Post 6" title="Blog Post 6">
                                    </a>
                                </div>
                                <div class="blog_content p_20">
                                    <div class="blog_meta d-flex align-items-center mb_10">
                                        <span class="date font_12 f_w_400">January 3, 2025</span>
                                        <span class="category font_12 f_w_400 ml_20">Innovation</span>
                                    </div>
                                    <h4 class="font_16 f_w_600 mb_10">
                                        <a href="#" class="text-dark">Innovation in E-commerce: What's Next?</a>
                                    </h4>
                                    <p class="font_14 f_w_400 text-muted mb_15">
                                        Explore the cutting-edge technologies and innovations that are transforming the e-commerce landscape...
                                    </p>
                                    <a href="#" class="read_more font_14 f_w_500">Read More <i class="ti-arrow-right ml_5"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="pagination_wrapper d-flex justify-content-center mt_30">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-xl-3 col-lg-3">
                <div class="blog_sidebar_wrap mb_30">
                    <!-- Sidebar Banner -->
                    @include('components.promotion-banner', ['position' => 'sidebar'])
                    
                    <!-- Search Form -->
                    <form action="{{ url('/blog') }}" name="sidebar_search">
                        <div class="input-group theme_search_field4 w-100 mb_20 style2">
                            <div class="input-group-prepend">
                                <button class="btn" type="button"> <i class="ti-search"></i> </button>
                            </div>
                            <input type="text" class="form-control search_input" id="sidebarSearchInput"
                                placeholder="Search Post" value="" name="query" required>
                        </div>
                    </form>

                    <!-- Categories -->
                    <div class="blog_sidebar_box mb_20">
                        <h4 class="font_18 f_w_700 mb_10">Categories</h4>
                        <div class="home6_border w-100 mb_20"></div>
                        <ul class="Check_sidebar mb-0">
                            <li><a href="#" class="d-flex justify-content-between align-items-center">Technology <span>(5)</span></a></li>
                            <li><a href="#" class="d-flex justify-content-between align-items-center">Business <span>(8)</span></a></li>
                            <li><a href="#" class="d-flex justify-content-between align-items-center">Marketing <span>(12)</span></a></li>
                            <li><a href="#" class="d-flex justify-content-between align-items-center">Customer Service <span>(6)</span></a></li>
                            <li><a href="#" class="d-flex justify-content-between align-items-center">Productivity <span>(4)</span></a></li>
                            <li><a href="#" class="d-flex justify-content-between align-items-center">Innovation <span>(7)</span></a></li>
                        </ul>
                    </div>

                    <!-- Popular Posts -->
                    <div class="blog_sidebar_box mb_15">
                        <h4 class="font_18 f_w_700 mb_10">Popular Posts</h4>
                        <div class="home6_border w-100 mb_20"></div>
                        <div class="news_lists">
                            <div class="news_list d-flex align-items-center mb_15">
                                <div class="news_thumb mr_15">
                                    <img src="{{ asset('uploads/images/22-02-2025/67b9bfd32db59.webp') }}" alt="Popular Post 1" class="img-fluid" style="width: 60px; height: 60px; object-fit: cover;">
                                </div>
                                <div class="news_content">
                                    <h6 class="font_14 f_w_600 mb_5"><a href="#" class="text-dark">The Future of E-commerce</a></h6>
                                    <span class="font_12 f_w_400 text-muted">Jan 15, 2025</span>
                                </div>
                            </div>
                            <div class="news_list d-flex align-items-center mb_15">
                                <div class="news_thumb mr_15">
                                    <img src="{{ asset('uploads/images/22-02-2025/67b9bfe9bb5de.webp') }}" alt="Popular Post 2" class="img-fluid" style="width: 60px; height: 60px; object-fit: cover;">
                                </div>
                                <div class="news_content">
                                    <h6 class="font_14 f_w_600 mb_5"><a href="#" class="text-dark">10 Essential Business Tips</a></h6>
                                    <span class="font_12 f_w_400 text-muted">Jan 12, 2025</span>
                                </div>
                            </div>
                            <div class="news_list d-flex align-items-center mb_15">
                                <div class="news_thumb mr_15">
                                    <img src="{{ asset('uploads/images/22-02-2025/67b9c001dae04.webp') }}" alt="Popular Post 3" class="img-fluid" style="width: 60px; height: 60px; object-fit: cover;">
                                </div>
                                <div class="news_content">
                                    <h6 class="font_14 f_w_600 mb_5"><a href="#" class="text-dark">Digital Marketing Strategies</a></h6>
                                    <span class="font_12 f_w_400 text-muted">Jan 10, 2025</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keywords/Tags -->
                    <div class="blog_sidebar_box mb_30 p-0 border-0">
                        <h4 class="font_18 f_w_700 mb_10">Keywords</h4>
                        <div class="home6_border w-100 mb_20"></div>
                        <div class="keyword_lists d-flex align-items-center flex-wrap gap_10">
                            <a href="#" class="keyword_tag">E-commerce</a>
                            <a href="#" class="keyword_tag">Business</a>
                            <a href="#" class="keyword_tag">Marketing</a>
                            <a href="#" class="keyword_tag">Technology</a>
                            <a href="#" class="keyword_tag">Innovation</a>
                            <a href="#" class="keyword_tag">Productivity</a>
                            <a href="#" class="keyword_tag">Customer Service</a>
                            <a href="#" class="keyword_tag">Digital</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
