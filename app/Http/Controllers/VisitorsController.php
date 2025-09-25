<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class VisitorsController extends Controller
{
    public function index()
    {
        // Get featured products from vendors
        $featuredProducts = Product::with(['vendor', 'category'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        // Get best seller products
        $bestSellers = Product::with(['vendor', 'category'])
            ->where('status', 'active')
            ->where('is_bestseller', true)
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        // Get new products
        $newProducts = Product::with(['vendor', 'category'])
            ->where('status', 'active')
            ->where('is_new', true)
            ->where('stock_quantity', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        return view('visitors.index', compact('featuredProducts', 'bestSellers', 'newProducts'));
    }

    public function about()
    {
        return view('visitors.about');
    }

    public function blogs()
    {
        return view('visitors.blogs');
    }

    public function contact()
    {
        return view('visitors.contact');
    }

    public function categories()
    {
        $categories = Category::with(['children' => function ($query) {
                $query->active()->orderBy('sort_order');
            }])
            ->withCount(['products' => function ($query) {
                $query->where('status', 'active')->where('stock_quantity', '>', 0);
            }])
            ->withCount(['children' => function ($query) {
                $query->active();
            }])
            ->active()
            ->root()
            ->orderBy('sort_order')
            ->get();

        // Load product counts for child categories
        $categories->load(['children' => function ($query) {
            $query->withCount(['products' => function ($query) {
                $query->where('status', 'active')->where('stock_quantity', '>', 0);
            }]);
        }]);

        return view('visitors.categories', compact('categories'));
    }

    public function categoryProducts($slug)
    {
        $category = Category::where('slug', $slug)
            ->with(['products' => function ($query) {
                $query->where('status', 'active')
                    ->where('stock_quantity', '>', 0)
                    ->with(['vendor', 'category']);
            }])
            ->firstOrFail();

        $products = $category->products()->paginate(20);

        return view('visitors.category-products', compact('category', 'products'));
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with(['vendor', 'category', 'reviews.user'])
            ->firstOrFail();

        // Increment view count
        $product->increment('view_count');

        return view('visitors.product-detail', compact('product'));
    }

    public function compare()
    {
        $compareList = session('compare_list', []);

        if (empty($compareList)) {
            $compareItems = collect();
        } else {
            $compareItems = Product::whereIn('id', $compareList)
                ->where('status', 'active')
                ->with(['vendor', 'category'])
                ->get();
        }

        return view('visitors.compare', compact('compareItems'));
    }

    public function track()
    {
        return view('visitors.track');
    }

    public function trackOrder(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string'
        ]);

        $order = Order::where('order_number', $request->order_number)
            ->with(['user', 'items.product', 'vendor'])
            ->first();

        if (!$order) {
            return back()->with('error', 'Order not found. Please check your order number and try again.');
        }

        return view('visitors.track-result', compact('order'));
    }

    public function wishlist()
    {
        return view('visitors.wishlist');
    }

    public function cart()
    {
        return view('visitors.cart');
    }

    public function merchant()
    {
        return view('visitors.merchant');
    }

    public function merchantApply()
    {
        return view('visitors.merchant-apply');
    }

    public function quickView(Request $request)
    {
        $productId = $request->input('product_id');

        $product = Product::with(['vendor', 'category', 'reviews.user'])
            ->where('id', $productId)
            ->where('status', 'active')
            ->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Return the product data as JSON for AJAX requests
        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'description' => $product->description,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'stock_quantity' => $product->stock_quantity,
                'thumbnail' => $product->thumbnail,
                'images' => $product->images,
                'vendor' => $product->vendor ? [
                    'name' => $product->vendor->shop_name,
                    'id' => $product->vendor->id
                ] : null,
                'category' => $product->category ? [
                    'name' => $product->category->name,
                    'slug' => $product->category->slug
                ] : null,
                'reviews_count' => $product->reviews->count(),
                'average_rating' => $product->reviews->avg('rating') ?? 0,
            ]
        ]);
    }
    public function mpesa(Request $request){
        dd($request);




    }
}
