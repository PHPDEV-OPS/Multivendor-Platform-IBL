@extends('admin.layouts.app')

@section('page-title', 'Website Content Management')
@section('page-subtitle', 'Edit and manage content for each section of your website')

@section('content')
<div class="container-fluid">
    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="admin-stats-card">
                <h3>{{ $stats['active'] }}</h3>
                <p>Active Promotions</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <h3>{{ $stats['active_banners'] }}</h3>
                <p>Visible Banners</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <h3>{{ $stats['scheduled'] }}</h3>
                <p>Scheduled</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <h3>{{ $stats['expired'] }}</h3>
                <p>Expired</p>
            </div>
        </div>
    </div>

    <!-- Website Sections Management -->
    <div class="row">
        <div class="col-12">
            <div class="admin-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Website Sections Management</h5>
                    <div>
                        <a href="{{ route('admin.promotions.create') }}" class="admin-btn">
                            <i class="fas fa-plus"></i> Add New Content
                        </a>
                    </div>
                </div>
                <p class="text-muted mb-4">Edit content for each section of your website. Click on any section to manage its content.</p>
                
                <!-- Section 1: Top Banner -->
                <div class="website-section mb-4">
                    <div class="section-header" onclick="toggleSection('top-banner')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><i class="fas fa-arrow-up"></i> Top Banner Section</h6>
                                <small class="text-muted">Promotional banner at the top of the website</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2">{{ $promotions->where('banner_position', 'top')->where('banner_is_active', true)->count() }} Active</span>
                                <i class="fas fa-chevron-down" id="top-banner-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="section-content" id="top-banner-content" style="display: none;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="preview-area">
                                    <h6 class="mb-2">Preview:</h6>
                                    <div class="border rounded p-3 bg-light">
                                        @include('components.promotion-banner', ['position' => 'top', 'showAdminControls' => true])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="controls-area">
                                    <h6 class="mb-2">Controls:</h6>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.promotions.create') }}?position=top" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i> Add Top Banner
                                        </a>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="refreshSection('top')">
                                            <i class="fas fa-sync"></i> Refresh Preview
                                        </button>
                                    </div>
                                    <hr>
                                    <h6 class="mb-2">Current Banners:</h6>
                                    @foreach($promotions->where('banner_position', 'top') as $banner)
                                    <div class="banner-item mb-2 p-2 border rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                                                 alt="Banner" class="img-thumbnail me-2" style="width: 40px; height: 25px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <small class="d-block">{{ $banner->name }}</small>
                                                <span class="badge {{ $banner->banner_is_active ? 'bg-success' : 'bg-secondary' }} btn-sm">
                                                    {{ $banner->banner_is_active ? 'Active' : 'Hidden' }}
                                                </span>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.promotions.edit', $banner) }}" class="btn btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-danger" onclick="deletePromotion({{ $banner->id }})" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Home Banner -->
                <div class="website-section mb-4">
                    <div class="section-header" onclick="toggleSection('home-banner')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><i class="fas fa-home"></i> Home Banner Section</h6>
                                <small class="text-muted">Main banner on the homepage</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2">{{ $promotions->where('banner_position', 'home_banner')->where('banner_is_active', true)->count() }} Active</span>
                                <i class="fas fa-chevron-down" id="home-banner-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="section-content" id="home-banner-content" style="display: none;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="preview-area">
                                    <h6 class="mb-2">Preview:</h6>
                                    <div class="border rounded p-3 bg-light">
                                        @include('components.promotion-banner', ['position' => 'home_banner', 'showAdminControls' => true])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="controls-area">
                                    <h6 class="mb-2">Controls:</h6>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.promotions.create') }}?position=home_banner" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i> Add Home Banner
                                        </a>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="refreshSection('home_banner')">
                                            <i class="fas fa-sync"></i> Refresh Preview
                                        </button>
                                    </div>
                                    <hr>
                                    <h6 class="mb-2">Current Banners:</h6>
                                    @foreach($promotions->where('banner_position', 'home_banner') as $banner)
                                    <div class="banner-item mb-2 p-2 border rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                                                 alt="Banner" class="img-thumbnail me-2" style="width: 40px; height: 25px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <small class="d-block">{{ $banner->name }}</small>
                                                <span class="badge {{ $banner->banner_is_active ? 'bg-success' : 'bg-secondary' }} btn-sm">
                                                    {{ $banner->banner_is_active ? 'Active' : 'Hidden' }}
                                                </span>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.promotions.edit', $banner) }}" class="btn btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-danger" onclick="deletePromotion({{ $banner->id }})" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Sidebar Banner -->
                <div class="website-section mb-4">
                    <div class="section-header" onclick="toggleSection('sidebar-banner')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><i class="fas fa-columns"></i> Sidebar Banner Section</h6>
                                <small class="text-muted">Banners in the sidebar area</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2">{{ $promotions->where('banner_position', 'sidebar')->where('banner_is_active', true)->count() }} Active</span>
                                <i class="fas fa-chevron-down" id="sidebar-banner-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="section-content" id="sidebar-banner-content" style="display: none;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="preview-area">
                                    <h6 class="mb-2">Preview:</h6>
                                    <div class="border rounded p-3 bg-light">
                                        @include('components.promotion-banner', ['position' => 'sidebar', 'showAdminControls' => true])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="controls-area">
                                    <h6 class="mb-2">Controls:</h6>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.promotions.create') }}?position=sidebar" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i> Add Sidebar Banner
                                        </a>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="refreshSection('sidebar')">
                                            <i class="fas fa-sync"></i> Refresh Preview
                                        </button>
                                    </div>
                                    <hr>
                                    <h6 class="mb-2">Current Banners:</h6>
                                    @foreach($promotions->where('banner_position', 'sidebar') as $banner)
                                    <div class="banner-item mb-2 p-2 border rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                                                 alt="Banner" class="img-thumbnail me-2" style="width: 40px; height: 25px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <small class="d-block">{{ $banner->name }}</small>
                                                <span class="badge {{ $banner->banner_is_active ? 'bg-success' : 'bg-secondary' }} btn-sm">
                                                    {{ $banner->banner_is_active ? 'Active' : 'Hidden' }}
                                                </span>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.promotions.edit', $banner) }}" class="btn btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-danger" onclick="deletePromotion({{ $banner->id }})" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Category Banner -->
                <div class="website-section mb-4">
                    <div class="section-header" onclick="toggleSection('category-banner')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><i class="fas fa-tags"></i> Category Banner Section</h6>
                                <small class="text-muted">Banners on category pages</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2">{{ $promotions->where('banner_position', 'category_banner')->where('banner_is_active', true)->count() }} Active</span>
                                <i class="fas fa-chevron-down" id="category-banner-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="section-content" id="category-banner-content" style="display: none;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="preview-area">
                                    <h6 class="mb-2">Preview:</h6>
                                    <div class="border rounded p-3 bg-light">
                                        @include('components.promotion-banner', ['position' => 'category_banner', 'showAdminControls' => true])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="controls-area">
                                    <h6 class="mb-2">Controls:</h6>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.promotions.create') }}?position=category_banner" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i> Add Category Banner
                                        </a>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="refreshSection('category_banner')">
                                            <i class="fas fa-sync"></i> Refresh Preview
                                        </button>
                                    </div>
                                    <hr>
                                    <h6 class="mb-2">Current Banners:</h6>
                                    @foreach($promotions->where('banner_position', 'category_banner') as $banner)
                                    <div class="banner-item mb-2 p-2 border rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                                                 alt="Banner" class="img-thumbnail me-2" style="width: 40px; height: 25px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <small class="d-block">{{ $banner->name }}</small>
                                                <span class="badge {{ $banner->banner_is_active ? 'bg-success' : 'bg-secondary' }} btn-sm">
                                                    {{ $banner->banner_is_active ? 'Active' : 'Hidden' }}
                                                </span>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.promotions.edit', $banner) }}" class="btn btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-danger" onclick="deletePromotion({{ $banner->id }})" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 5: CTA Banner -->
                <div class="website-section mb-4">
                    <div class="section-header" onclick="toggleSection('cta-banner')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><i class="fas fa-ad"></i> CTA Banner Section (Ads Bar)</h6>
                                <small class="text-muted">Call-to-action banner in the middle section</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2">{{ $promotions->where('banner_position', 'cta_banner')->where('banner_is_active', true)->count() }} Active</span>
                                <i class="fas fa-chevron-down" id="cta-banner-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="section-content" id="cta-banner-content" style="display: none;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="preview-area">
                                    <h6 class="mb-2">Preview:</h6>
                                    <div class="border rounded p-3 bg-light">
                                        @include('components.promotion-banner', ['position' => 'cta_banner', 'showAdminControls' => true])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="controls-area">
                                    <h6 class="mb-2">Controls:</h6>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.promotions.create') }}?position=cta_banner" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i> Add CTA Banner
                                        </a>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="refreshSection('cta_banner')">
                                            <i class="fas fa-sync"></i> Refresh Preview
                                        </button>
                                    </div>
                                    <hr>
                                    <h6 class="mb-2">Current Banners:</h6>
                                    @foreach($promotions->where('banner_position', 'cta_banner') as $banner)
                                    <div class="banner-item mb-2 p-2 border rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                                                 alt="Banner" class="img-thumbnail me-2" style="width: 40px; height: 25px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <small class="d-block">{{ $banner->name }}</small>
                                                <span class="badge {{ $banner->banner_is_active ? 'bg-success' : 'bg-secondary' }} btn-sm">
                                                    {{ $banner->banner_is_active ? 'Active' : 'Hidden' }}
                                                </span>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.promotions.edit', $banner) }}" class="btn btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-danger" onclick="deletePromotion({{ $banner->id }})" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 6: Footer Banner -->
                <div class="website-section mb-4">
                    <div class="section-header" onclick="toggleSection('footer-banner')">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><i class="fas fa-arrow-down"></i> Footer Banner Section</h6>
                                <small class="text-muted">Banners at the bottom of the website</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success me-2">{{ $promotions->where('banner_position', 'footer')->where('banner_is_active', true)->count() }} Active</span>
                                <i class="fas fa-chevron-down" id="footer-banner-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="section-content" id="footer-banner-content" style="display: none;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="preview-area">
                                    <h6 class="mb-2">Preview:</h6>
                                    <div class="border rounded p-3 bg-light">
                                        @include('components.promotion-banner', ['position' => 'footer', 'showAdminControls' => true])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="controls-area">
                                    <h6 class="mb-2">Controls:</h6>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.promotions.create') }}?position=footer" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i> Add Footer Banner
                                        </a>
                                        <button class="btn btn-outline-secondary btn-sm" onclick="refreshSection('footer')">
                                            <i class="fas fa-sync"></i> Refresh Preview
                                        </button>
                                    </div>
                                    <hr>
                                    <h6 class="mb-2">Current Banners:</h6>
                                    @foreach($promotions->where('banner_position', 'footer') as $banner)
                                    <div class="banner-item mb-2 p-2 border rounded">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $banner->banner_image_url ?? asset('images/placeholder-banner.jpg') }}" 
                                                 alt="Banner" class="img-thumbnail me-2" style="width: 40px; height: 25px; object-fit: cover;">
                                            <div class="flex-grow-1">
                                                <small class="d-block">{{ $banner->name }}</small>
                                                <span class="badge {{ $banner->banner_is_active ? 'bg-success' : 'bg-secondary' }} btn-sm">
                                                    {{ $banner->banner_is_active ? 'Active' : 'Hidden' }}
                                                </span>
                                            </div>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.promotions.edit', $banner) }}" class="btn btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-danger" onclick="deletePromotion({{ $banner->id }})" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleSection(sectionId) {
    const content = document.getElementById(sectionId + '-content');
    const icon = document.getElementById(sectionId + '-icon');
    
    if (content.style.display === 'none') {
        content.style.display = 'block';
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    } else {
        content.style.display = 'none';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}

function refreshSection(position) {
    // Reload the page to refresh the banner preview
    location.reload();
}

function toggleBannerStatus(promotionId) {
    if (confirm('Are you sure you want to toggle this banner visibility?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('meta[name="_token"]')?.getAttribute('content') || 
                         '{{ csrf_token() }}';
        
        fetch('/admin/promotions/' + promotionId + '/toggle-banner', {
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

function deletePromotion(promotionId) {
    if (confirm('Are you sure you want to delete this promotion? This action cannot be undone.')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('meta[name="_token"]')?.getAttribute('content') || 
                         '{{ csrf_token() }}';
        
        fetch('/admin/promotions/' + promotionId, {
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
            alert('An error occurred while deleting the promotion.');
        });
    }
}
</script>

<style>
.admin-stats-card {
    background: linear-gradient(135deg, var(--base_color), #ff8f40);
    color: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    text-align: center;
}

.admin-stats-card h3 {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.admin-stats-card p {
    margin: 0;
    opacity: 0.9;
}

.website-section {
    border: 1px solid var(--border_color);
    border-radius: 12px;
    overflow: hidden;
    background: white;
}

.section-header {
    background: var(--feature_color);
    padding: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    border-bottom: 1px solid var(--border_color);
}

.section-header:hover {
    background: #e9ecef;
}

.section-content {
    padding: 20px;
}

.preview-area {
    background: white;
    border-radius: 8px;
}

.controls-area {
    background: var(--feature_color);
    padding: 15px;
    border-radius: 8px;
}

.banner-item {
    background: white;
    transition: all 0.3s ease;
}

.banner-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.border.rounded {
    border-color: var(--border_color) !important;
}

.bg-light {
    background-color: var(--feature_color) !important;
}
</style>
@endsection
