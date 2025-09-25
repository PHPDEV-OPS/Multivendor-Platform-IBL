@extends('admin.layouts.app')

@section('page-title', $page->title)
@section('page-subtitle', 'Page Details')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Page Content -->
        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1">{{ $page->title }}</h4>
                    <p class="text-muted mb-0">Slug: {{ $page->slug }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.content.edit', $page) }}" class="admin-btn">
                        <i class="fas fa-edit"></i> Edit Page
                    </a>
                    <a href="{{ route('admin.content.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>

            <!-- Page Status and Type -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="text-center p-3 bg-light rounded">
                        <strong>Status</strong>
                        <div class="mt-1">
                            @if($page->status === 'published')
                                <span class="status-badge status-active">Published</span>
                            @elseif($page->status === 'draft')
                                <span class="status-badge status-pending">Draft</span>
                            @else
                                <span class="status-badge status-inactive">Archived</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-light rounded">
                        <strong>Type</strong>
                        <div class="mt-1">
                            <span class="badge bg-info">{{ $page->page_type_label }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-light rounded">
                        <strong>Views</strong>
                        <div class="mt-1">
                            <h5 class="mb-0">{{ number_format($page->view_count) }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-light rounded">
                        <strong>Featured</strong>
                        <div class="mt-1">
                            @if($page->is_featured)
                                <span class="badge bg-warning">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            @if($page->featured_image)
                <div class="mb-4">
                    <h5>Featured Image</h5>
                    <img src="{{ asset('storage/' . $page->featured_image) }}" 
                         alt="Featured Image" class="img-fluid rounded" style="max-width: 100%; max-height: 400px; object-fit: cover;">
                </div>
            @endif

            <!-- Page Content -->
            <div class="mb-4">
                <h5>Content</h5>
                <div class="bg-light p-4 rounded">
                    {!! nl2br(e($page->content)) !!}
                </div>
            </div>

            <!-- Meta Information -->
            @if($page->meta_description || $page->meta_keywords)
                <div class="mb-4">
                    <h5>SEO Information</h5>
                    @if($page->meta_description)
                        <div class="mb-2">
                            <strong>Meta Description:</strong>
                            <p class="text-muted mb-0">{{ $page->meta_description }}</p>
                        </div>
                    @endif
                    @if($page->meta_keywords)
                        <div class="mb-2">
                            <strong>Meta Keywords:</strong>
                            <p class="text-muted mb-0">{{ $page->meta_keywords }}</p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Page Information -->
        <div class="admin-card">
            <h5 class="mb-3">Page Information</h5>
            <div class="mb-3">
                <strong>Category:</strong>
                @if($page->category)
                    <span class="badge bg-secondary">{{ $page->category->name }}</span>
                @else
                    <span class="text-muted">No category</span>
                @endif
            </div>
            <div class="mb-3">
                <strong>Author:</strong>
                @if($page->author)
                    <div>{{ $page->author->name }}</div>
                    <small class="text-muted">{{ $page->author->email }}</small>
                @else
                    <span class="text-muted">Unknown</span>
                @endif
            </div>
            <div class="mb-3">
                <strong>Created:</strong>
                <div>{{ $page->created_at->format('M d, Y H:i') }}</div>
                <small class="text-muted">{{ $page->created_at->diffForHumans() }}</small>
            </div>
            <div class="mb-3">
                <strong>Last Updated:</strong>
                <div>{{ $page->updated_at->format('M d, Y H:i') }}</div>
                <small class="text-muted">{{ $page->updated_at->diffForHumans() }}</small>
            </div>
            @if($page->published_at)
                <div class="mb-3">
                    <strong>Published:</strong>
                    <div>{{ $page->published_at->format('M d, Y H:i') }}</div>
                    <small class="text-muted">{{ $page->published_at->diffForHumans() }}</small>
                </div>
            @endif
            @if($page->sort_order)
                <div class="mb-3">
                    <strong>Sort Order:</strong>
                    <div>{{ $page->sort_order }}</div>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="admin-card">
            <h5 class="mb-3">Quick Actions</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('admin.content.edit', $page) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Page
                </a>
                <a href="#" target="_blank" class="btn btn-outline-primary">
                    <i class="fas fa-external-link-alt"></i> Preview Page
                </a>
                <form action="{{ route('admin.content.destroy', $page) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100" 
                            onclick="return confirm('Are you sure you want to delete this page? This action cannot be undone.')">
                        <i class="fas fa-trash"></i> Delete Page
                    </button>
                </form>
            </div>
        </div>

        <!-- Page Statistics -->
        <div class="admin-card">
            <h5 class="mb-3">Statistics</h5>
            <div class="row text-center">
                <div class="col-6">
                    <div class="p-3 bg-light rounded">
                        <h4 class="mb-1">{{ number_format($page->view_count) }}</h4>
                        <small class="text-muted">Total Views</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 bg-light rounded">
                        <h4 class="mb-1">{{ $page->is_featured ? 'Yes' : 'No' }}</h4>
                        <small class="text-muted">Featured</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
