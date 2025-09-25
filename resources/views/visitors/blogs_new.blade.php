@extends('welcome')

@section('content')

<!-- Page Title Section -->
<div class="breadcrumb_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <h1 class="page_title">Blog</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blog</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Blog Section -->
<div class="blog_section py-5">
    <div class="container">
        <div class="row">
            <!-- Main Blog Content -->
            <div class="col-lg-9">
                <div class="row">
                    <!-- Blog Posts Grid -->
                    <div class="col-12 mb-4">
                        <div class="blog-posts-container">
                            @if(isset($blogs) && $blogs->count() > 0)
                                @foreach($blogs as $blog)
                                    <div class="card mb-4 shadow-sm">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img src="{{ asset($blog['image']) }}" 
                                                     class="img-fluid rounded-start h-100 object-cover" 
                                                     alt="{{ $blog['title'] }}"
                                                     style="min-height: 200px; object-fit: cover;">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $blog['title'] }}</h5>
                                                    <p class="card-text">{{ $blog['excerpt'] }}</p>
                                                    <p class="card-text">
                                                        <small class="text-muted">
                                                            <i class="ti-calendar"></i> Published on {{ $blog['published_at']->format('M d, Y') }}
                                                            <span class="mx-2">|</span>
                                                            <i class="ti-user"></i> By {{ $blog['author'] }}
                                                            <span class="mx-2">|</span>
                                                            <i class="ti-tag"></i> {{ $blog['category'] }}
                                                        </small>
                                                    </p>
                                                    <a href="#" class="btn btn-primary btn-sm">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- No Posts Message -->
                                <div class="text-center py-5">
                                    <div class="card">
                                        <div class="card-body">
                                            <i class="ti-write text-muted" style="font-size: 3rem;"></i>
                                            <h4 class="mt-3">
                                                @if(isset($search) && $search)
                                                    No Blog Posts Found for "{{ $search }}"
                                                @else
                                                    No Blog Posts Found
                                                @endif
                                            </h4>
                                            <p class="text-muted">
                                                @if(isset($search) && $search)
                                                    Try searching with different keywords or browse all posts.
                                                @else
                                                    We're working on creating amazing content for you. Check back soon!
                                                @endif
                                            </p>
                                            @if(isset($search) && $search)
                                                <a href="{{ route('visitor.blogs') }}" class="btn btn-primary btn-sm">View All Posts</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="blog-sidebar">
                    <!-- Search Widget -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Search Posts</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('visitor.blogs') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search" 
                                           placeholder="Search posts..." value="{{ request('search') }}">
                                    <button class="btn btn-outline-secondary" type="submit">
                                        <i class="ti-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Categories</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#" class="text-decoration-none">Technology <span class="badge bg-secondary">5</span></a></li>
                                <li><a href="#" class="text-decoration-none">Shopping Tips <span class="badge bg-secondary">3</span></a></li>
                                <li><a href="#" class="text-decoration-none">Product Reviews <span class="badge bg-secondary">8</span></a></li>
                                <li><a href="#" class="text-decoration-none">News <span class="badge bg-secondary">2</span></a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Recent Posts Widget -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Recent Posts</h5>
                        </div>
                        <div class="card-body">
                            @if(isset($blogs) && $blogs->count() > 0)
                                @foreach($blogs->take(3) as $recentBlog)
                                    <div class="d-flex mb-3">
                                        <img src="{{ asset($recentBlog['image']) }}" 
                                             class="rounded me-3" width="60" height="60" style="object-fit: cover;">
                                        <div>
                                            <h6 class="mb-1">
                                                <a href="#" class="text-decoration-none">{{ Str::limit($recentBlog['title'], 30) }}</a>
                                            </h6>
                                            <small class="text-muted">{{ $recentBlog['published_at']->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted mb-0">No recent posts available.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Tags Widget -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Tags</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark">Shopping</span>
                                <span class="badge bg-light text-dark">Technology</span>
                                <span class="badge bg-light text-dark">Reviews</span>
                                <span class="badge bg-light text-dark">Tips</span>
                                <span class="badge bg-light text-dark">News</span>
                                <span class="badge bg-light text-dark">Trends</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles for Blog Page -->
<style>
    .breadcrumb_area {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 0;
        margin-bottom: 0;
    }
    
    .breadcrumb_area .page_title {
        color: white;
        margin-bottom: 10px;
        font-size: 2.5rem;
        font-weight: 600;
    }
    
    .breadcrumb_area .breadcrumb {
        background: transparent;
        margin-bottom: 0;
        padding: 0;
    }
    
    .breadcrumb_area .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }
    
    .breadcrumb_area .breadcrumb-item.active {
        color: white;
    }
    
    .blog_section {
        background-color: #f8f9fa;
        min-height: 70vh;
    }
    
    .blog-posts-container .card {
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .blog-posts-container .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .blog-sidebar .card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
    }
    
    .blog-sidebar .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom: none;
        font-weight: 600;
    }
    
    .object-cover {
        object-fit: cover;
    }
</style>

<!-- Preloader Management Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hide preloader after page loads
    const preloader = document.getElementById('pre-loader');
    if (preloader) {
        setTimeout(function() {
            preloader.style.opacity = '0';
            preloader.style.visibility = 'hidden';
            setTimeout(function() {
                preloader.style.display = 'none';
            }, 300);
        }, 500);
    }
});
</script>

@endsection
