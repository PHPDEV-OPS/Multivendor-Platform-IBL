<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $vendor = Auth::user();
        $products = Product::where('vendor_id', $vendor->id)
            ->with('category')
            ->latest()
            ->paginate(20);

        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        return view('vendor.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_alert' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,draft',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_new' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
        ]);

        $vendor = Auth::user();

        // Generate SKU if not provided
        $sku = $request->sku ?: $this->generateSKU($request->name);

        // Handle main image upload
        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $mainImagePath = $this->uploadImage($request->file('main_image'), 'products');
        }

        // Handle additional images
        $additionalImages = [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $additionalImages[] = $this->uploadImage($image, 'products');
            }
        }

        $product = Product::create([
            'vendor_id' => $vendor->id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'short_description' => $request->short_description,
            'sku' => $sku,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'cost_price' => $request->cost_price,
            'stock_quantity' => $request->stock_quantity,
            'min_stock_alert' => $request->min_stock_alert ?: 5,
            'weight' => $request->weight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'main_image' => $mainImagePath,
            'images' => $additionalImages,
            'status' => $request->status,
            'is_featured' => $request->boolean('is_featured'),
            'is_bestseller' => $request->boolean('is_bestseller'),
            'is_new' => $request->boolean('is_new'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords ? explode(',', $request->meta_keywords) : [],
        ]);

        return redirect()->route('vendor.products')
            ->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $vendor = Auth::user();
        $product = Product::where('vendor_id', $vendor->id)
            ->findOrFail($id);
        $categories = Category::active()->orderBy('name')->get();

        return view('vendor.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $vendor = Auth::user();
        $product = Product::where('vendor_id', $vendor->id)
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock_alert' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,draft',
            'is_featured' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_new' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
        ]);

        // Handle main image upload
        $mainImagePath = $product->main_image;
        if ($request->hasFile('main_image')) {
            // Delete old image
            if ($mainImagePath) {
                Storage::disk('public')->delete($mainImagePath);
            }
            $mainImagePath = $this->uploadImage($request->file('main_image'), 'products');
        }

        // Handle additional images
        $additionalImages = $product->images ?? [];
        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $additionalImages[] = $this->uploadImage($image, 'products');
            }
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'short_description' => $request->short_description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'cost_price' => $request->cost_price,
            'stock_quantity' => $request->stock_quantity,
            'min_stock_alert' => $request->min_stock_alert ?: 5,
            'weight' => $request->weight,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'main_image' => $mainImagePath,
            'images' => $additionalImages,
            'status' => $request->status,
            'is_featured' => $request->boolean('is_featured'),
            'is_bestseller' => $request->boolean('is_bestseller'),
            'is_new' => $request->boolean('is_new'),
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords ? explode(',', $request->meta_keywords) : [],
        ]);

        return redirect()->route('vendor.products')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $vendor = Auth::user();
        $product = Product::where('vendor_id', $vendor->id)
            ->findOrFail($id);

        // Delete images
        if ($product->main_image) {
            Storage::disk('public')->delete($product->main_image);
        }

        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('vendor.products')
            ->with('success', 'Product deleted successfully!');
    }

    public function toggleStatus($id)
    {
        $vendor = Auth::user();
        $product = Product::where('vendor_id', $vendor->id)
            ->findOrFail($id);

        $product->update([
            'status' => $product->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully!',
            'status' => $product->status
        ]);
    }

    private function generateSKU($productName)
    {
        $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $productName), 0, 3));
        $timestamp = time();
        return $prefix . '-' . $timestamp;
    }

    private function uploadImage($image, $folder)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs("uploads/images/{$folder}", $filename, 'public');
        return $path;
    }
}
