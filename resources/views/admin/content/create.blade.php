@extends('admin.layouts.app')

@section('page-title', 'Create New Page')
@section('page-subtitle', 'Add a new documentation or content page')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="admin-card">
            <form action="{{ route('admin.content.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Page Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="page_type" class="form-label">Page Type *</label>
                            <select class="form-select @error('page_type') is-invalid @enderror" 
                                    id="page_type" name="page_type" required>
                                <option value="">Select Type</option>
                                @foreach($pageTypes as $value => $label)
                                    <option value="{{ $value }}" {{ old('page_type') == $value ? 'selected' : '' }}>
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
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

                <div class="form-group mb-3">
                    <label for="content" class="form-label">Content *</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" 
                              id="content" name="content" rows="15" required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">
                        You can use HTML tags for formatting. For documentation, consider using headings, lists, and code blocks.
                    </small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                      id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Brief description for search engines (max 255 characters)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                   id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Comma-separated keywords for SEO</small>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="featured_image" class="form-label">Featured Image</label>
                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                           id="featured_image" name="featured_image" accept="image/*">
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Recommended size: 1200x630px, Max size: 2MB</small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="published_at" class="form-label">Publish Date</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                   id="published_at" name="published_at" value="{{ old('published_at') }}">
                            @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" 
                           {{ old('is_featured') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">
                        Mark as Featured
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="admin-btn">
                        <i class="fas fa-save"></i> Create Page
                    </button>
                    <a href="{{ route('admin.content.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Page Type Information -->
        <div class="admin-card mb-4">
            <h5 class="mb-3">Page Types</h5>
            <div class="list-group list-group-flush">
                <div class="list-group-item border-0 px-0">
                    <h6 class="mb-1">Documentation</h6>
                    <small class="text-muted">Help articles and guides for users</small>
                </div>
                <div class="list-group-item border-0 px-0">
                    <h6 class="mb-1">FAQ</h6>
                    <small class="text-muted">Frequently asked questions</small>
                </div>
                <div class="list-group-item border-0 px-0">
                    <h6 class="mb-1">Terms & Conditions</h6>
                    <small class="text-muted">Legal terms and conditions</small>
                </div>
                <div class="list-group-item border-0 px-0">
                    <h6 class="mb-1">Privacy Policy</h6>
                    <small class="text-muted">Privacy and data protection policy</small>
                </div>
                <div class="list-group-item border-0 px-0">
                    <h6 class="mb-1">About Us</h6>
                    <small class="text-muted">Company information and story</small>
                </div>
                <div class="list-group-item border-0 px-0">
                    <h6 class="mb-1">Contact</h6>
                    <small class="text-muted">Contact information and form</small>
                </div>
            </div>
        </div>

        <!-- Content Guidelines -->
        <div class="admin-card">
            <h5 class="mb-3">Content Guidelines</h5>
            <ul class="list-unstyled">
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    Use clear, concise language
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    Include relevant headings and subheadings
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    Add images and examples where helpful
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    Keep documentation up to date
                </li>
                <li class="mb-2">
                    <i class="fas fa-check text-success me-2"></i>
                    Use SEO-friendly titles and descriptions
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate meta description from content
    const contentTextarea = document.getElementById('content');
    const metaDescriptionTextarea = document.getElementById('meta_description');
    
    contentTextarea.addEventListener('input', function() {
        if (!metaDescriptionTextarea.value) {
            const content = this.value;
            const plainText = content.replace(/<[^>]*>/g, ''); // Remove HTML tags
            const excerpt = plainText.substring(0, 150);
            if (excerpt.length === 150) {
                excerpt += '...';
            }
            metaDescriptionTextarea.value = excerpt;
        }
    });

    // Auto-generate meta keywords from title
    const titleInput = document.getElementById('title');
    const metaKeywordsInput = document.getElementById('meta_keywords');
    
    titleInput.addEventListener('input', function() {
        if (!metaKeywordsInput.value) {
            const title = this.value;
            const keywords = title.toLowerCase()
                .replace(/[^\w\s]/g, '') // Remove special characters
                .split(' ')
                .filter(word => word.length > 2) // Filter out short words
                .slice(0, 5) // Take first 5 words
                .join(', ');
            metaKeywordsInput.value = keywords;
        }
    });
});
</script>
@endpush
