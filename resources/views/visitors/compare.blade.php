@extends('layouts.main')

@section('content')
<!-- compare_banner::start  -->
<div class="amaz_section section_spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title text-center mb_50">
                    <h2>Compare Products</h2>
                    <p>Compare your selected items side by side</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- compare_banner::end  -->

<!-- compare_content::start  -->
<div class="amaz_section section_spacing">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="compare_content">
                    @if($compareItems->isEmpty())
                    <!-- Empty compare state -->
                    <div class="empty_compare text-center" id="empty_compare">
                        <div class="empty_icon mb_30">
                            <i class="ti-control-shuffle" style="font-size: 80px; color: #fd4949;"></i>
                        </div>
                        <h4 class="mb_20">No products to compare</h4>
                        <p class="mb_30">Add products to your compare list to see them side by side.</p>
                        <a href="{{ url('/') }}" class="amaz_primary_btn">Continue Shopping</a>
                    </div>
                    @else

                    <!-- Compare items -->
                    <div class="compare_items" id="compare_items">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4>Comparing {{ $compareItems->count() }} Products</h4>
                            <button onclick="clearCompare()" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash me-1"></i>Clear All
                            </button>
                        </div>

                        <!-- Compare Table -->
                        <div class="table-responsive">
                            <table class="table compare_table">
                                <tbody>
                                    <!-- Product Images -->
                                    <tr>
                                        <td class="compare_label"><strong>Product</strong></td>
                                        @foreach($compareItems as $product)
                                        <td class="text-center">
                                            <div class="compare_product_image">
                                                <a href="{{ route('product.show', $product->slug) }}">
                                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('frontend/amazy/img/default-product.png') }}"
                                                         alt="{{ $product->name }}"
                                                         class="product_image">
                                                </a>
                                                <button onclick="removeFromCompare({{ $product->id }})"
                                                        class="remove_compare_btn"
                                                        title="Remove from Compare">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </td>
                                        @endforeach
                                    </tr>

                                    <!-- Product Names -->
                                    <tr>
                                        <td class="compare_label"><strong>Name</strong></td>
                                        @foreach($compareItems as $product)
                                        <td class="text-center">
                                            <h6 class="product_name">
                                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                            </h6>
                                        </td>
                                        @endforeach
                                    </tr>

                                    <!-- Product Prices -->
                                    <tr>
                                        <td class="compare_label"><strong>Price</strong></td>
                                        @foreach($compareItems as $product)
                                        <td class="text-center">
                                            <div class="product_price">
                                                @if($product->sale_price && $product->sale_price < $product->price)
                                                    <span class="current_price">KES {{ number_format($product->sale_price, 0) }}</span>
                                                    <span class="old_price">KES {{ number_format($product->price, 0) }}</span>
                                                @else
                                                    <span class="current_price">KES {{ number_format($product->price, 0) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        @endforeach
                                    </tr>

                                    <!-- Product Categories -->
                                    <tr>
                                        <td class="compare_label"><strong>Category</strong></td>
                                        @foreach($compareItems as $product)
                                        <td class="text-center">{{ $product->category->name ?? 'N/A' }}</td>
                                        @endforeach
                                    </tr>

                                    <!-- Product Vendors -->
                                    <tr>
                                        <td class="compare_label"><strong>Vendor</strong></td>
                                        @foreach($compareItems as $product)
                                        <td class="text-center">{{ $product->vendor->name ?? 'N/A' }}</td>
                                        @endforeach
                                    </tr>

                                    <!-- Stock Status -->
                                    <tr>
                                        <td class="compare_label"><strong>Stock</strong></td>
                                        @foreach($compareItems as $product)
                                        <td class="text-center">
                                            @if($product->stock_quantity > 0)
                                                <span class="badge bg-success">In Stock ({{ $product->stock_quantity }})</span>
                                            @else
                                                <span class="badge bg-danger">Out of Stock</span>
                                            @endif
                                        </td>
                                        @endforeach
                                    </tr>

                                    <!-- Actions -->
                                    <tr>
                                        <td class="compare_label"><strong>Actions</strong></td>
                                        @foreach($compareItems as $product)
                                        <td class="text-center">
                                            <div class="compare_actions">
                                                @if($product->stock_quantity > 0)
                                                    <button onclick="addToCart({{ $product->id }})"
                                                            class="btn btn-primary btn-sm mb-2 w-100">
                                                        <i class="fas fa-shopping-cart me-1"></i>Add to Cart
                                                    </button>
                                                @endif
                                                <a href="{{ route('product.show', $product->slug) }}"
                                                   class="btn btn-outline-primary btn-sm w-100">
                                                    <i class="fas fa-eye me-1"></i>View Details
                                                </a>
                                            </div>
                                        </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- compare_content::end  -->
@endsection

@push('styles')
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

    .product_widget5 .thumb {
        height: 300px;
        width: 300px;
    }

    .product_widget5 .thumb img {
        max-width: 295px;
        max-height: 295px;
        object-fit: contain;
    }

    .product_widget5 .product__meta .product_banding {
        min-height: 20px;
    }

    .compare_empty {
        text-align: center;
        padding: 60px 20px 20px;
        color: #666;
        font-size: 1.5rem;
        margin-bottom: 0;
    }

    .comparing_box_area {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 40px;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .amaz_section {
        background-color: #f8f9fa;
        min-height: 70vh;
    }

    /* Compare table styles when products are added */
    .compare_table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .compare_table th,
    .compare_table td {
        padding: 15px;
        text-align: center;
        border: 1px solid #e4e7e9;
    }

    .compare_table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .compare_table .product_image {
        width: 150px;
        height: 150px;
        object-fit: contain;
        border-radius: 8px;
    }

    .compare_table .product_name {
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .compare_table .product_price {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--base_color, #ff6f20);
    }

    .remove_compare_btn {
        background: #dc3545;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .remove_compare_btn:hover {
        background: #c82333;
        transform: translateY(-2px);
    }

    .reset_compare_btn {
        background: var(--base_color, #ff6f20);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .reset_compare_btn:hover {
        background: #e55a1a;
        transform: translateY(-2px);
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .breadcrumb_area .page_title {
            font-size: 2rem;
        }

        .comparing_box_area {
            padding: 20px;
        }

        .compare_table {
            font-size: 14px;
        }

        .compare_table th,
        .compare_table td {
            padding: 10px 5px;
        }

        .compare_table .product_image {
            width: 100px;
            height: 100px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration
    const _config = {
        "currency_symbol": "KSh",
        "currency_symbol_position": "left_with_space",
        "decimal_limit": "2"
    };

    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Remove product from compare
    window.removeFromCompare = function(product_id) {
        if (!product_id) return;

        // Show loading
        const preloader = document.getElementById('pre-loader');
        if (preloader) preloader.style.display = 'block';

        const data = {
            '_token': token,
            'product_id': product_id
        };

        fetch('{{ route("compare.remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (preloader) preloader.style.display = 'none';

            if (data.success) {
                // Reload the page to update the compare list
                location.reload();
            } else {
                showToast(data.message || 'Error removing product', 'error');
            }
        })
        .catch(error => {
            if (preloader) preloader.style.display = 'none';
            console.error('Error:', error);
            showToast('Error removing product from compare list', 'error');
        });
    };

    // Clear all compare items
    window.clearCompare = function() {
        if (!confirm('Are you sure you want to clear all compare items?')) return;

        const preloader = document.getElementById('pre-loader');
        if (preloader) preloader.style.display = 'block';

        fetch('{{ route("compare.clear") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({'_token': token})
        })
        .then(response => response.json())
        .then(data => {
            if (preloader) preloader.style.display = 'none';

            if (data.success) {
                location.reload();
            } else {
                showToast('Error clearing compare list', 'error');
            }
        })
        .catch(error => {
            if (preloader) preloader.style.display = 'none';
            console.error('Error:', error);
            showToast('Error clearing compare list', 'error');
        });
    };

    // Reset compare list
    window.resetCompare = function() {
        if (!confirm('Are you sure you want to clear all products from compare list?')) {
            return;
        }

        // Show loading
        const preloader = document.getElementById('pre-loader');
        if (preloader) preloader.style.display = 'block';

        const data = {
            '_token': token
        };

        fetch('/compare/reset', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (preloader) preloader.style.display = 'none';

            if (data.success) {
                // Update compare list
                document.getElementById('compare_list_div').innerHTML = data.page;

                // Update compare count
                const compareCountElements = document.querySelectorAll('.compare_count');
                compareCountElements.forEach(el => el.textContent = data.totalItems);

                // Show success message
                showToast('Compare reset successfully', 'success');
            }
        })
        .catch(error => {
            if (preloader) preloader.style.display = 'none';
            console.error('Error:', error);
            showToast('Error resetting compare list', 'error');
        });
    };

    // Simple toast notification function
    function showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#4bcf90' : type === 'error' ? '#ff6d68' : '#17a2b8'};
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            z-index: 9999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        toast.textContent = message;

        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);

        // Remove after 3 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }
});
</script>
@endpush
