@props(['position' => 'top', 'class' => '', 'showAdminControls' => false])

@php
    // Get active banner promotions for the specified position
    $banners = \App\Models\Promotion::where('banner_is_active', true)
        ->where('banner_position', $position)
        ->where('is_active', true)
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->whereNotNull('banner_image')
        ->orderBy('created_at', 'desc')
        ->get();
@endphp

@if($banners->count() > 0)
    @if($position === 'home_banner')
        <div class="bannerUi_active owl-carousel home_banner_section mb-4" id="home-banner-carousel">
            @foreach($banners as $banner)
                <div class="item">
                    <a class="banner_img" href="{{ $banner->banner_link ?? route('categories') }}" target="_blank">
                        <img class="img-fluid" src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                             alt="{{ $banner->banner_title ?? 'Home Banner' }}" 
                             title="{{ $banner->banner_title ?? 'Home Banner' }}"
                             onerror="this.src='{{ asset('images/placeholder-banner.jpg') }}'">
                        
                        @if($showAdminControls)
                            <div class="banner-admin-controls position-absolute top-0 end-0 p-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-light btn-sm" 
                                            onclick="editBanner({{ $banner->id }})" 
                                            title="Edit Banner">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light btn-sm" 
                                            onclick="toggleBannerStatus({{ $banner->id }})" 
                                            title="{{ $banner->banner_is_active ? 'Disable' : 'Enable' }} Banner">
                                        <i class="fas fa-{{ $banner->banner_is_active ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-light btn-sm" 
                                            onclick="deleteBanner({{ $banner->id }})" 
                                            title="Delete Banner">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                        
                        @if($banner->banner_title || $banner->banner_subtitle)
                            <div class="banner-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                <div class="text-center banner-content">
                                    @if($banner->banner_title)
                                        <h2 class="banner-title mb-3">{{ $banner->banner_title }}</h2>
                                    @endif
                                    @if($banner->banner_subtitle)
                                        <p class="banner-subtitle mb-0">{{ $banner->banner_subtitle }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    @else
        @foreach($banners as $banner)
            <div class="promotion-banner {{ $class }}" id="promotion-banner-{{ $banner->id }}-{{ $position }}">
                @if($position === 'top')
                    <div class="promotion_bar position-relative top-0 start-0 w-100 d-lg-block">
                        <a href="{{ $banner->banner_link ?? route('categories') }}" target="_blank"
                            class="promotion_bar_wrapper d-flex align-items-center position-relative">
                                                     <img class="img-fluid w-100" src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                                  alt="{{ $banner->banner_title ?? 'Promotion Banner' }}" 
                                  title="{{ $banner->banner_title ?? 'Promotion Banner' }}"
                                  style="max-height: 80px; object-fit: cover;"
                                  onerror="this.src='{{ asset('images/placeholder-banner.jpg') }}'">
                            
                            @if($showAdminControls)
                                <div class="banner-admin-controls position-absolute top-0 end-0 p-2">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="editBanner({{ $banner->id }})" 
                                                title="Edit Banner">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="toggleBannerStatus({{ $banner->id }})" 
                                                title="{{ $banner->banner_is_active ? 'Disable' : 'Enable' }} Banner">
                                            <i class="fas fa-{{ $banner->banner_is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="deleteBanner({{ $banner->id }})" 
                                                title="Delete Banner">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            
                            <span class="close_promobar gj-cursor-pointer d-inline-flex align-items-center justify-content-center"
                                onclick="closeBanner({{ $banner->id }}, '{{ $position }}')">
                                <i class="ti-close"></i>
                            </span>
                        </a>
                    </div>
                @elseif($position === 'sidebar')
                    <div class="sidebar_banner mb-3">
                        <a href="{{ $banner->banner_link ?? route('categories') }}" class="d-block position-relative">
                                                     <img class="img-fluid w-100 rounded" src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                                  alt="{{ $banner->banner_title ?? 'Sidebar Banner' }}" 
                                  title="{{ $banner->banner_title ?? 'Sidebar Banner' }}"
                                  onerror="this.src='{{ asset('images/placeholder-banner.jpg') }}'">
                            
                            @if($showAdminControls)
                                <div class="banner-admin-controls position-absolute top-0 end-0 p-2">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="editBanner({{ $banner->id }})" 
                                                title="Edit Banner">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="toggleBannerStatus({{ $banner->id }})" 
                                                title="{{ $banner->banner_is_active ? 'Disable' : 'Enable' }} Banner">
                                            <i class="fas fa-{{ $banner->banner_is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="deleteBanner({{ $banner->id }})" 
                                                title="Delete Banner">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            
                            @if($banner->banner_title)
                                <div class="banner-caption mt-2">
                                    <h6 class="mb-1">{{ $banner->banner_title }}</h6>
                                    @if($banner->banner_subtitle)
                                        <small class="text-muted">{{ $banner->banner_subtitle }}</small>
                                    @endif
                                </div>
                            @endif
                        </a>
                    </div>
                @elseif($position === 'footer')
                    <div class="footer_banner mt-4">
                        <a href="{{ $banner->banner_link ?? route('categories') }}" class="d-block position-relative">
                                                     <img class="img-fluid w-100 rounded" src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                                  alt="{{ $banner->banner_title ?? 'Footer Banner' }}" 
                                  title="{{ $banner->banner_title ?? 'Footer Banner' }}"
                                  style="max-height: 200px; object-fit: cover;"
                                  onerror="this.src='{{ asset('images/placeholder-banner.jpg') }}'">
                            
                            @if($showAdminControls)
                                <div class="banner-admin-controls position-absolute top-0 end-0 p-2">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="editBanner({{ $banner->id }})" 
                                                title="Edit Banner">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="toggleBannerStatus({{ $banner->id }})" 
                                                title="{{ $banner->banner_is_active ? 'Disable' : 'Enable' }} Banner">
                                            <i class="fas fa-{{ $banner->banner_is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="deleteBanner({{ $banner->id }})" 
                                                title="Delete Banner">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </a>
                    </div>
                @elseif($position === 'category_banner')
                    <div class="category_banner mb-4">
                        <a href="{{ $banner->banner_link ?? route('categories') }}" class="d-block position-relative">
                                                     <img class="img-fluid w-100 rounded" src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                                  alt="{{ $banner->banner_title ?? 'Category Banner' }}" 
                                  title="{{ $banner->banner_title ?? 'Category Banner' }}"
                                  style="max-height: 300px; object-fit: cover;"
                                  onerror="this.src='{{ asset('images/placeholder-banner.jpg') }}'">
                            
                            @if($showAdminControls)
                                <div class="banner-admin-controls position-absolute top-0 end-0 p-3">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="editBanner({{ $banner->id }})" 
                                                title="Edit Banner">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="toggleBannerStatus({{ $banner->id }})" 
                                                title="{{ $banner->banner_is_active ? 'Disable' : 'Enable' }} Banner">
                                            <i class="fas fa-{{ $banner->banner_is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-light btn-sm" 
                                                onclick="deleteBanner({{ $banner->id }})" 
                                                title="Delete Banner">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif
                            
                            @if($banner->banner_title || $banner->banner_subtitle)
                                <div class="banner-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
                                    <div class="text-center banner-content">
                                        @if($banner->banner_title)
                                            <h3 class="banner-title mb-3">{{ $banner->banner_title }}</h3>
                                        @endif
                                        @if($banner->banner_subtitle)
                                            <p class="banner-subtitle mb-0">{{ $banner->banner_subtitle }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </a>
                    </div>
                @elseif($position === 'cta_banner')
                    <div class="cta_banner_section mb-4">
                        <div class="amaz_section">
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="amaz_cta_box">
                                            <div class="row justify-content-center">
                                                <a href="{{ $banner->banner_link ?? route('categories') }}" class="col-xl-12 random_ads_div position-relative">
                                                    <img class="img-fluid w-100" 
                                                         src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                                                         alt="{{ $banner->banner_title ?? 'CTA Banner' }}" 
                                                         title="{{ $banner->banner_title ?? 'CTA Banner' }}"
                                                         onerror="this.src='{{ asset('images/placeholder-banner.jpg') }}'">
                                                    
                                                    @if($showAdminControls)
                                                        <div class="banner-admin-controls position-absolute top-0 end-0 p-2">
                                                            <div class="btn-group btn-group-sm" role="group">
                                                                <button type="button" class="btn btn-outline-light btn-sm" 
                                                                        onclick="editBanner({{ $banner->id }})" 
                                                                        title="Edit Banner">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-outline-light btn-sm" 
                                                                        onclick="toggleBannerStatus({{ $banner->id }})" 
                                                                        title="{{ $banner->banner_is_active ? 'Disable' : 'Enable' }} Banner">
                                                                    <i class="fas fa-{{ $banner->banner_is_active ? 'eye-slash' : 'eye' }}"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-outline-light btn-sm" 
                                                                        onclick="deleteBanner({{ $banner->id }})" 
                                                                        title="Delete Banner">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @endif
@endif

<script>
function closeBanner(bannerId, position) {
    const bannerElement = document.getElementById('promotion-banner-' + bannerId + '-' + position);
    if (bannerElement) {
        bannerElement.style.display = 'none';
        // Store in localStorage to remember user preference
        localStorage.setItem('closed_banner_' + bannerId + '_' + position, 'true');
    }
}

@if($showAdminControls)
function editBanner(bannerId) {
    window.location.href = '/admin/promotions/' + bannerId + '/edit';
}

function toggleBannerStatus(bannerId) {
    if (confirm('Are you sure you want to toggle this banner status?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('meta[name="_token"]')?.getAttribute('content') || 
                         '{{ csrf_token() }}';
        
        fetch('/admin/promotions/' + bannerId + '/toggle-banner', {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the banner status.');
        });
    }
}

function deleteBanner(bannerId) {
    if (confirm('Are you sure you want to delete this banner? This action cannot be undone.')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('meta[name="_token"]')?.getAttribute('content') || 
                         '{{ csrf_token() }}';
        
        fetch('/admin/promotions/' + bannerId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while deleting the banner.');
        });
    }
}
@endif

// Check for previously closed banners on page load
document.addEventListener('DOMContentLoaded', function() {
    @foreach($banners as $banner)
        if (localStorage.getItem('closed_banner_{{ $banner->id }}_{{ $position }}') === 'true') {
            const bannerElement = document.getElementById('promotion-banner-{{ $banner->id }}-{{ $position }}');
            if (bannerElement) {
                bannerElement.style.display = 'none';
            }
        }
    @endforeach

    // Initialize Owl Carousel for home banner if it exists
    if (document.getElementById('home-banner-carousel')) {
        // Destroy existing instance if any
        try {
            $('#home-banner-carousel').owlCarousel('destroy');
        } catch (e) {
            // Instance doesn't exist, continue
        }
        
        // Initialize new instance
        $('#home-banner-carousel').owlCarousel({
            loop: true,
            margin: 0,
            nav: false, // Remove navigation buttons
            dots: true,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    }
});
</script>

<style>
.banner-overlay {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.2) 50%, rgba(0, 0, 0, 0.4) 100%);
    border-radius: 0.375rem;
    backdrop-filter: blur(2px);
}

.banner-content {
    background: transparent;
    padding: 2rem 3rem;
    border-radius: 15px;
    max-width: 80%;
}

.banner-title {
    font-family: 'Poppins', 'Montserrat', 'Segoe UI', sans-serif;
    font-weight: 800;
    font-size: 2.5rem;
    line-height: 1.2;
    color: #ffffff;
    text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.8), -1px -1px 2px rgba(255, 255, 255, 0.3);
    margin-bottom: 1rem;
    letter-spacing: -0.5px;
    text-transform: uppercase;
    position: relative;
}

.banner-title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #ffffff, #f0f0f0);
    border-radius: 2px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.banner-subtitle {
    font-family: 'Poppins', 'Montserrat', 'Segoe UI', sans-serif;
    font-size: 1.2rem;
    font-weight: 500;
    color: #ffffff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8), -1px -1px 2px rgba(255, 255, 255, 0.3);
    line-height: 1.4;
    letter-spacing: 0.5px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .banner-content {
        padding: 1.5rem 2rem;
        max-width: 90%;
        background: transparent;
    }
    
    .banner-title {
        font-size: 1.8rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8), -1px -1px 2px rgba(255, 255, 255, 0.3);
    }
    
    .banner-subtitle {
        font-size: 1rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8), -1px -1px 1px rgba(255, 255, 255, 0.3);
    }
}

@media (max-width: 480px) {
    .banner-content {
        padding: 1rem 1.5rem;
        max-width: 95%;
        background: transparent;
    }
    
    .banner-title {
        font-size: 1.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8), -1px -1px 2px rgba(255, 255, 255, 0.3);
    }
    
    .banner-subtitle {
        font-size: 0.9rem;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8), -1px -1px 1px rgba(255, 255, 255, 0.3);
    }
}

.home_banner_section,
.category_banner {
    position: relative;
}

.sidebar_banner img {
    transition: transform 0.3s ease;
}

.sidebar_banner:hover img {
    transform: scale(1.05);
}

.banner-admin-controls {
    z-index: 10;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.promotion-banner:hover .banner-admin-controls {
    opacity: 1;
}

.banner-admin-controls .btn {
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.banner-admin-controls .btn:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
}

.banner-admin-controls .btn i {
    font-size: 0.875rem;
}

/* Banner slider specific styles */
.bannerUi_active {
    position: relative;
    overflow: hidden;
}

.bannerUi_active .item {
    position: relative;
}

.bannerUi_active .banner_img {
    display: block;
    position: relative;
    overflow: hidden;
}

.bannerUi_active .banner_img img {
    width: 100%;
    height: auto;
    object-fit: cover;
}

/* Owl Carousel Navigation - Hidden since nav is disabled */
.bannerUi_active .owl-nav {
    display: none;
}

/* Owl Carousel Dots */
.bannerUi_active .owl-dots {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
}

.bannerUi_active .owl-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    transition: all 0.3s ease;
}

.bannerUi_active .owl-dot.active {
    background: rgba(255, 255, 255, 1);
    transform: scale(1.2);
}

/* Fade animation */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }
    to {
        opacity: 0;
    }
}

.fadeIn {
    animation: fadeIn 0.5s ease-in;
}

.fadeOut {
    animation: fadeOut 0.5s ease-out;
}
</style>
