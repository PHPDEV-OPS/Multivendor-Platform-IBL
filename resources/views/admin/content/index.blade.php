@extends('layouts.unified')

@section('page-title', 'Content Management')
@section('page-subtitle', 'Manage your documentation and content pages')

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Content Management</h4>
        <p class="text-muted mb-0">Manage your documentation and content pages</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.content.create') }}" class="admin-btn">
            <i class="fas fa-plus"></i> Add New Page
        </a>
        <button class="admin-btn">
            <i class="fas fa-download"></i> Export
        </button>
    </div>
</div>

<!-- Content Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['total']) }}</h3>
                    <p>Total Pages</p>
                    <small class="text-success">All content</small>
                </div>
                <div>
                    <i class="fas fa-file-alt fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['published']) }}</h3>
                    <p>Published</p>
                    <small class="text-success">{{ $stats['total'] > 0 ? round(($stats['published'] / $stats['total']) * 100) : 0 }}% of total</small>
                </div>
                <div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['draft']) }}</h3>
                    <p>Drafts</p>
                    <small class="text-warning">{{ $stats['total'] > 0 ? round(($stats['draft'] / $stats['total']) * 100) : 0 }}% of total</small>
                </div>
                <div>
                    <i class="fas fa-edit fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="admin-stats-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3>{{ number_format($stats['documentation']) }}</h3>
                    <p>Documentation</p>
                    <small class="text-info">Help articles</small>
                </div>
                <div>
                    <i class="fas fa-book fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="admin-card mb-4">
    <form method="GET" action="{{ route('admin.content.index') }}">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="search" class="form-label">Search Content</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Title, content, slug..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="page_type" class="form-label">Page Type</label>
                    <select class="form-select" id="page_type" name="page_type">
                        <option value="">All Types</option>
                        <option value="page" {{ request('page_type') === 'page' ? 'selected' : '' }}>Page</option>
                        <option value="documentation" {{ request('page_type') === 'documentation' ? 'selected' : '' }}>Documentation</option>
                        <option value="faq" {{ request('page_type') === 'faq' ? 'selected' : '' }}>FAQ</option>
                        <option value="terms" {{ request('page_type') === 'terms' ? 'selected' : '' }}>Terms</option>
                        <option value="privacy" {{ request('page_type') === 'privacy' ? 'selected' : '' }}>Privacy</option>
                        <option value="about" {{ request('page_type') === 'about' ? 'selected' : '' }}>About</option>
                        <option value="contact" {{ request('page_type') === 'contact' ? 'selected' : '' }}>Contact</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route('admin.content.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Content Table -->
<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" class="form-check-input" id="selectAll">
                    </th>
                    <th>Page</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                <tr>
                    <td>
                        <input type="checkbox" class="form-check-input page-checkbox" value="{{ $page->id }}">
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($page->featured_image)
                                <img src="{{ asset('storage/' . $page->featured_image) }}" alt="Page" 
                                     class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-file-alt text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-1">{{ $page->title }}</h6>
                                <small class="text-muted">{{ $page->slug }}</small>
                                @if($page->is_featured)
                                    <span class="badge bg-warning ms-2">Featured</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $page->page_type_label }}</span>
                    </td>
                    <td>
                        @if($page->category)
                            <span class="badge bg-secondary">{{ $page->category->name }}</span>
                        @else
                            <span class="text-muted">No category</span>
                        @endif
                    </td>
                    <td>
                        @if($page->author)
                            <div>
                                <strong>{{ $page->author->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $page->author->email }}</small>
                            </div>
                        @else
                            <span class="text-muted">Unknown</span>
                        @endif
                    </td>
                    <td>
                        @if($page->status === 'published')
                            <span class="status-badge status-active">Published</span>
                        @elseif($page->status === 'draft')
                            <span class="status-badge status-pending">Draft</span>
                        @else
                            <span class="status-badge status-inactive">Archived</span>
                        @endif
                    </td>
                    <td>
                        <div class="text-center">
                            <strong>{{ number_format($page->view_count) }}</strong>
                            <br>
                            <small class="text-muted">views</small>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong>{{ $page->updated_at->format('Y-m-d') }}</strong>
                            <br>
                            <small class="text-muted">{{ $page->updated_at->diffForHumans() }}</small>
                        </div>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.content.show', $page) }}"><i class="fas fa-eye"></i> View</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.content.edit', $page) }}"><i class="fas fa-edit"></i> Edit</a></li>
                                <li><a class="dropdown-item" href="#" target="_blank"><i class="fas fa-external-link-alt"></i> Preview</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.content.destroy', $page) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this page?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-file-alt fa-3x mb-3"></i>
                            <h5>No content found</h5>
                            <p>There are no pages matching your criteria.</p>
                            <a href="{{ route('admin.content.create') }}" class="admin-btn">
                                <i class="fas fa-plus"></i> Create Your First Page
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($pages->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $pages->appends(request()->query())->links() }}
    </div>
    @endif
</div>

<!-- Bulk Actions -->
<div class="admin-card mt-4" id="bulkActions" style="display: none;">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <span id="selectedCount">0</span> pages selected
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" id="bulkPublish">
                <i class="fas fa-check"></i> Publish Selected
            </button>
            <button class="btn btn-outline-warning" id="bulkDraft">
                <i class="fas fa-edit"></i> Mark as Draft
            </button>
            <button class="btn btn-outline-danger" id="bulkDelete">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const pageCheckboxes = document.querySelectorAll('.page-checkbox');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');

    // Select all functionality
    selectAll.addEventListener('change', function() {
        pageCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    // Individual checkbox functionality
    pageCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActions();
        });
    });

    function updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('.page-checkbox:checked');
        const count = checkedBoxes.length;
        
        selectedCount.textContent = count;
        
        if (count > 0) {
            bulkActions.style.display = 'block';
        } else {
            bulkActions.style.display = 'none';
            selectAll.checked = false;
        }
    }
});
</script>
@endpush
