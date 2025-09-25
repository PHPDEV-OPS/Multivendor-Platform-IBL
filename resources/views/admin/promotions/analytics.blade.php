@extends('admin.layouts.app')

@section('page-title', 'Promotion Analytics')
@section('page-subtitle', 'Track promotion and banner performance')

@section('content')
<div class="container-fluid">
    <!-- Analytics Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-primary">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stats-content">
                        <h4>{{ $promotionStats->sum('total_revenue') ? '$' . number_format($promotionStats->sum('total_revenue'), 2) : '$0.00' }}</h4>
                        <p>Total Revenue</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-success">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stats-content">
                        <h4>{{ $promotionStats->sum('total_orders') }}</h4>
                        <p>Total Orders</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-warning">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <div class="stats-content">
                        <h4>{{ $promotionStats->sum('used_count') }}</h4>
                        <p>Total Redemptions</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="admin-stats-card">
                <div class="d-flex align-items-center">
                    <div class="stats-icon bg-info">
                        <i class="fas fa-image"></i>
                    </div>
                    <div class="stats-content">
                        <h4>{{ $bannerStats->where('banner_is_active', true)->count() }}</h4>
                        <p>Active Banners</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Promotion Performance -->
        <div class="col-md-8">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">Promotion Performance</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Promotion</th>
                                    <th>Code</th>
                                    <th>Revenue</th>
                                    <th>Orders</th>
                                    <th>Usage</th>
                                    <th>Conversion Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($promotionStats as $stat)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-1">{{ $stat->name }}</h6>
                                            <small class="text-muted">{{ $stat->used_count }} redemptions</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $stat->code }}</span>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($stat->total_revenue ?? 0, 2) }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $stat->total_orders ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <small>{{ $stat->used_count }}/{{ $stat->usage_limit ?: '∞' }}</small>
                                            @if($stat->usage_limit)
                                                <div class="progress mt-1" style="height: 4px;">
                                                    <div class="progress-bar" style="width: {{ ($stat->used_count / $stat->usage_limit) * 100 }}%"></div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($stat->total_orders > 0)
                                            <span class="badge bg-success">{{ number_format(($stat->used_count / $stat->total_orders) * 100, 1) }}%</span>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-chart-bar fa-3x mb-3"></i>
                                            <h5>No promotion data available</h5>
                                            <p>Create promotions to see analytics here</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banner Performance -->
        <div class="col-md-4">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">Banner Performance</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($bannerStats as $banner)
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                @if($banner->banner_image)
                                    <img src="{{ asset('storage/' . $banner->banner_image) }}" 
                                         alt="Banner" class="img-thumbnail me-3" 
                                         style="width: 60px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 40px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $banner->banner_title ?: $banner->name }}</h6>
                                    <small class="text-muted">{{ $banner->banner_position ?? 'N/A' }}</small>
                                    <div class="mt-1">
                                        <span class="badge {{ $banner->banner_is_active ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $banner->banner_is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <small class="text-muted ms-2">{{ $banner->used_count }} uses</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-image fa-2x mb-2"></i>
                                <p>No banner data available</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="admin-card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.promotions.create') }}" class="admin-btn admin-btn-outline">
                            <i class="fas fa-plus me-2"></i>Create New Promotion
                        </a>
                        <a href="{{ route('admin.promotions.export') }}" class="admin-btn admin-btn-outline">
                            <i class="fas fa-download me-2"></i>Export Data
                        </a>
                        <a href="{{ route('admin.promotions.index') }}" class="admin-btn admin-btn-outline">
                            <i class="fas fa-list me-2"></i>View All Promotions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">Revenue by Promotion Type</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="admin-card">
                <div class="card-header">
                    <h5 class="mb-0">Banner Performance</h5>
                </div>
                <div class="card-body">
                    <canvas id="bannerChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'doughnut',
        data: {
            labels: @json($promotionStats->pluck('name')),
            datasets: [{
                data: @json($promotionStats->pluck('total_revenue')),
                backgroundColor: [
                    '#FF6384',
                    '#36A2EB',
                    '#FFCE56',
                    '#4BC0C0',
                    '#9966FF',
                    '#FF9F40'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Banner Chart
    const bannerCtx = document.getElementById('bannerChart').getContext('2d');
    const bannerChart = new Chart(bannerCtx, {
        type: 'bar',
        data: {
            labels: @json($bannerStats->pluck('banner_title')),
            datasets: [{
                label: 'Usage Count',
                data: @json($bannerStats->pluck('used_count')),
                backgroundColor: '#36A2EB'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush
