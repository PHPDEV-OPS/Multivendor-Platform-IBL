@extends('admin.layouts.app')

@section('page-title', 'Banner Management')
@section('page-subtitle', 'Manage promotion banners across your store')

@section('content')
<div class="container-fluid">
    <!-- Header Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="admin-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">Banner Management</h5>
                        <p class="text-muted mb-0">Manage promotion banners and their display settings</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.promotions.create') }}" class="admin-btn">
                            <i class="fas fa-plus"></i> Create New Banner
                        </a>
                        <a href="{{ route('admin.promotions.index') }}" class="admin-btn admin-btn-outline">
                            <i class="fas fa-list"></i> All Promotions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Banner Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="admin-stats-card">
                <h3>{{ $stats['total_banners'] }}</h3>
                <p>Total Banners</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <h3>{{ $stats['active_banners'] }}</h3>
                <p>Active Banners</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <h3>{{ $stats['scheduled_banners'] }}</h3>
                <p>Scheduled Banners</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <h3>{{ $stats['expired_banners'] }}</h3>
                <p>Expired Banners</p>
            </div>
        </div>
    </div>

    <!-- Banner Positions -->
    @foreach($bannerPositions as $positionKey => $positionName)
    <div class="row mb-4">
        <div class="col-12">
            <div class="admin-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">{{ $positionName }}</h5>
                    <span class="badge bg-primary">{{ $bannersByPosition[$positionKey]->count() }} banners</span>
                </div>
                
                @if($bannersByPosition[$positionKey]->count() > 0)
                    <div class="row">
                        @foreach($bannersByPosition[$positionKey] as $banner)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="banner-preview-card">
                                <div class="banner-preview-header">
                                    <div class="banner-status-badge">
                                        @if($banner->is_active && $banner->start_date <= now() && $banner->end_date >= now())
                                            <span class="badge bg-success">Active</span>
                                        @elseif($banner->start_date > now())
                                            <span class="badge bg-warning">Scheduled</span>
                                        @else
                                            <span class="badge bg-danger">Expired</span>
                                        @endif
                                    </div>
                                    <div class="banner-actions">
                                        <button class="btn btn-sm btn-outline-primary" onclick="editBanner({{ $banner->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-{{ $banner->banner_is_active ? 'warning' : 'success' }}" 
                                                onclick="toggleBannerStatus({{ $banner->id }})" 
                                                title="{{ $banner->banner_is_active ? 'Disable' : 'Enable' }}">
                                            <i class="fas fa-{{ $banner->banner_is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteBanner({{ $banner->id }})" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="banner-preview-image">
                                    <img src="{{ $banner->banner_image_url }}" 
                                         alt="{{ $banner->banner_title ?? 'Banner' }}" 
                                         class="img-fluid w-100">
                                </div>
                                
                                <div class="banner-preview-info">
                                    <h6 class="banner-title">{{ $banner->banner_title ?? 'Untitled Banner' }}</h6>
                                    @if($banner->banner_subtitle)
                                        <p class="banner-subtitle text-muted">{{ $banner->banner_subtitle }}</p>
                                    @endif
                                    
                                    <div class="banner-details">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i> 
                                            {{ $banner->start_date->format('M d, Y') }} - {{ $banner->end_date->format('M d, Y') }}
                                        </small>
                                        @if($banner->banner_link)
                                            <br><small class="text-muted">
                                                <i class="fas fa-link"></i> 
                                                <a href="{{ $banner->banner_link }}" target="_blank">View Link</a>
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">No banners for this position</h6>
                        <p class="text-muted">Create a new banner to display in the {{ strtolower($positionName) }} position.</p>
                        <a href="{{ route('admin.promotions.create') }}" class="admin-btn">
                            <i class="fas fa-plus"></i> Create Banner
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    <!-- Live Preview Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="admin-card">
                <h5 class="mb-3">Live Preview</h5>
                <p class="text-muted mb-3">See how your banners will appear to visitors (with admin controls)</p>
                
                <div class="row">
                    <div class="col-12">
                        <h6 class="mb-2">Top Banner Preview:</h6>
                        @include('components.promotion-banner', ['position' => 'top', 'showAdminControls' => true])
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-8">
                        <h6 class="mb-2">Home Banner Preview:</h6>
                        @include('components.promotion-banner', ['position' => 'home_banner', 'showAdminControls' => true])
                    </div>
                    <div class="col-md-4">
                        <h6 class="mb-2">Sidebar Banner Preview:</h6>
                        @include('components.promotion-banner', ['position' => 'sidebar', 'showAdminControls' => true])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function editBanner(bannerId) {
    window.location.href = '{{ route("admin.promotions.edit", "") }}/' + bannerId;
}

function toggleBannerStatus(bannerId) {
    if (confirm('Are you sure you want to toggle this banner status?')) {
        fetch('{{ route("admin.promotions.toggle-banner", "") }}/' + bannerId, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
        fetch('{{ route("admin.promotions.destroy", "") }}/' + bannerId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
</script>

<style>
.banner-preview-card {
    border: 1px solid var(--border_color);
    border-radius: 12px;
    overflow: hidden;
    background: white;
    transition: all 0.3s ease;
}

.banner-preview-card:hover {
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.banner-preview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    background: var(--feature_color);
    border-bottom: 1px solid var(--border_color);
}

.banner-actions {
    display: flex;
    gap: 5px;
}

.banner-preview-image {
    height: 150px;
    overflow: hidden;
    position: relative;
}

.banner-preview-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.banner-preview-info {
    padding: 15px;
}

.banner-title {
    font-weight: 600;
    margin-bottom: 5px;
    color: var(--text_color);
}

.banner-subtitle {
    font-size: 0.875rem;
    margin-bottom: 10px;
}

.banner-details {
    font-size: 0.75rem;
}

.banner-details a {
    color: var(--base_color);
    text-decoration: none;
}

.banner-details a:hover {
    text-decoration: underline;
}

.admin-btn-outline {
    background: transparent;
    border: 2px solid var(--base_color);
    color: var(--base_color);
}

.admin-btn-outline:hover {
    background: var(--base_color);
    color: white;
}
</style>
@endsection
