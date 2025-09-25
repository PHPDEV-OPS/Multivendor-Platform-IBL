<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $cartSummary = $this->getCartSummary($cartItems);
        
        return view('visitors.cart', compact('cartItems', 'cartSummary'));
    }

    public function add(Request $request): JsonResponse
    {
        // Debug: Log the incoming request data
        \Log::info('Cart add request:', [
            'all_data' => $request->all(),
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'qty' => $request->qty,
            'headers' => $request->headers->all()
        ]);

        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'sometimes|integer|min:1',
                'qty' => 'sometimes|integer|min:1', // Allow qty as alternative to quantity
            ], [
                'product_id.required' => 'Product ID is required.',
                'product_id.exists' => 'The selected product does not exist.',
                'quantity.integer' => 'Quantity must be a whole number.',
                'quantity.min' => 'Quantity must be at least 1.',
                'qty.integer' => 'Quantity must be a whole number.',
                'qty.min' => 'Quantity must be at least 1.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Cart validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        // Use qty if quantity is not provided (for backward compatibility)
        $quantity = $request->quantity ?? $request->qty ?? 1;

        $product = Product::findOrFail($request->product_id);
        
        // Check stock availability
        if ($product->stock_quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock. Only ' . $product->stock_quantity . ' items available.'
            ], 400);
        }

        $cartData = [
            'product_id' => $request->product_id,
            'quantity' => $quantity,
            'price' => $product->final_price,
            'options' => $request->options ?? null,
        ];

        // Add user_id or session_id
        if (auth()->check()) {
            $cartData['user_id'] = auth()->id();
        } else {
            $cartData['session_id'] = session()->getId();
        }

        // Check if product already in cart
        $existingCart = Cart::where('product_id', $request->product_id)
            ->where(function($query) {
                if (auth()->check()) {
                    $query->where('user_id', auth()->id());
                } else {
                    $query->where('session_id', session()->getId());
                }
            })
            ->first();

        if ($existingCart) {
            // Update quantity
            $newQuantity = $existingCart->quantity + $quantity;
            if ($product->stock_quantity < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Only ' . $product->stock_quantity . ' items available.'
                ], 400);
            }
            
            $existingCart->update(['quantity' => $newQuantity]);
            $cartItem = $existingCart;
        } else {
            // Create new cart item
            $cartItem = Cart::create($cartData);
        }

        $cartItems = $this->getCartItems();
        $cartSummary = $this->getCartSummary($cartItems);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $cartItems->count(),
            'cart_summary' => $cartSummary,
            'cart_item' => $cartItem->load('product'),
            'count_bottom' => $cartItems->count(),
            'cart_details_submenu' => view('visitors.includes.cart-submenu', compact('cartItems', 'cartSummary'))->render()
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::findOrFail($request->cart_id);
        
        // Check if user owns this cart item
        if (auth()->check() && $cartItem->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        if (!auth()->check() && $cartItem->session_id !== session()->getId()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Check stock availability
        if ($cartItem->product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock. Only ' . $cartItem->product->stock_quantity . ' items available.'
            ], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        $cartItems = $this->getCartItems();
        $cartSummary = $this->getCartSummary($cartItems);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully!',
            'cart_summary' => $cartSummary,
            'cart_item' => $cartItem->load('product')
        ]);
    }

    public function remove(Request $request): JsonResponse
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);

        $cartItem = Cart::findOrFail($request->cart_id);
        
        // Check if user owns this cart item
        if (auth()->check() && $cartItem->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        if (!auth()->check() && $cartItem->session_id !== session()->getId()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $cartItem->delete();

        $cartItems = $this->getCartItems();
        $cartSummary = $this->getCartSummary($cartItems);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart successfully!',
            'cart_count' => $cartItems->count(),
            'cart_summary' => $cartSummary,
            'count_bottom' => $cartItems->count(),
            'SubmenuCart' => view('visitors.includes.cart-submenu', compact('cartItems', 'cartSummary'))->render(),
            'MainCart' => view('visitors.includes.cart-main', compact('cartItems', 'cartSummary'))->render()
        ]);
    }

    public function clear(): JsonResponse
    {
        $query = Cart::query();
        
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('session_id', session()->getId());
        }

        $query->delete();

        $cartItems = collect();
        $cartSummary = [
            'subtotal' => 0,
            'total' => 0,
            'item_count' => 0
        ];

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully!',
            'cart_count' => 0,
            'cart_summary' => $cartSummary,
            'count_bottom' => 0,
            'SubmenuCart' => view('visitors.includes.cart-submenu', compact('cartItems', 'cartSummary'))->render(),
            'MainCart' => view('visitors.includes.cart-main', compact('cartItems', 'cartSummary'))->render()
        ]);
    }

    public function getCartCount(): JsonResponse
    {
        $cartItems = $this->getCartItems();
        
        return response()->json([
            'count' => $cartItems->count(),
            'total' => $cartItems->sum(function($item) {
                return $item->price * $item->quantity;
            })
        ]);
    }

    private function getCartItems()
    {
        $query = Cart::with(['product.vendor', 'product.category'])
            ->active();

        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('session_id', session()->getId());
        }

        return $query->get();
    }

    private function getCartSummary($cartItems)
    {
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        return [
            'subtotal' => $subtotal,
            'shipping' => 0, // Will be calculated during checkout
            'tax' => 0, // Will be calculated during checkout
            'discount' => 0, // Will be applied during checkout
            'total' => $subtotal,
            'item_count' => $cartItems->count()
        ];
    }
}
