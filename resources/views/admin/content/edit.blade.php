@extends('admin.layouts.app')

@section('page-title', 'Edit Page')
@section('page-subtitle', 'Update page content and settings')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="admin-card">
            <form action="{{ route('admin.content.update', $page) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Page Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $page->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="page_type" class="form-label">Page Type *</label>
                            <select class="form-select @error('page_type') is-invalid @enderror" id="page_type" name="page_type" required>
                                @foreach($pageTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('page_type', $page->page_type) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('page_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="content" class="form-label">Content *</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" 
                              id="content" name="content" rows="15" required>{{ old('content', $page->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $page->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ old('status', $page->status) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                      id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $page->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="published_at" class="form-label">Published At</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                   id="published_at" name="published_at" 
                                   value="{{ old('published_at', $page->published_at ? $page->published_at->format('Y-m-d\TH:i') : '') }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <div class="form-check">
                        <input class="form-check-input @error('is_featured') is-invalid @enderror" 
                               type="checkbox" id="is_featured" name="is_featured" value="1" 
                               {{ old('is_featured', $page->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            Mark as Featured Page
                        </label>
                        @error('is_featured')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.content.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                    <div class="d-flex gap-2">
                        <button type="submit" class="admin-btn">
                            <i class="fas fa-save"></i> Update Page
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Featured Image -->
        <div class="admin-card">
            <h5 class="mb-3">Featured Image</h5>
            <div class="form-group mb-3">
                <label for="featured_image" class="form-label">Upload New Image</label>
                <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                       id="featured_image" name="featured_image" accept="image/*">
                @error('featured_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            @if($page->featured_image)
                <div class="mb-3">
                    <label class="form-label">Current Image</label>
                    <img src="{{ asset('storage/' . $page->featured_image) }}" 
                         alt="Featured Image" class="img-fluid rounded" style="max-width: 100%;">
                </div>
            @endif
        </div>

        <!-- Page Information -->
        <div class="admin-card">
            <h5 class="mb-3">Page Information</h5>
            <div class="mb-2">
                <strong>Slug:</strong> 
                <code>{{ $page->slug }}</code>
            </div>
            <div class="mb-2">
                <strong>Created:</strong> 
                {{ $page->created_at->format('M d, Y H:i') }}
            </div>
            <div class="mb-2">
                <strong>Last Updated:</strong> 
                {{ $page->updated_at->format('M d, Y H:i') }}
            </div>
            @if($page->author)
                <div class="mb-2">
                    <strong>Author:</strong> 
                    {{ $page->author->name }}
                </div>
            @endif
            <div class="mb-2">
                <strong>Views:</strong> 
                {{ number_format($page->view_count) }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugDisplay = document.querySelector('code');
    
    titleInput.addEventListener('input', function() {
        const slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slugDisplay.textContent = slug;
    });
});
</script>
@endpush
