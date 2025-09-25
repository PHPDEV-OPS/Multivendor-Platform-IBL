<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', Auth::id())
            ->with(['product', 'vendor'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('visitors.wishlist', compact('wishlistItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        $wishlistItem = Wishlist::firstOrCreate([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'vendor_id' => $product->vendor_id,
        ]);

        if ($wishlistItem->wasRecentlyCreated) {
            return response()->json([
                'result' => 1,
                'message' => 'Product added to wishlist successfully',
                'totalItems' => Wishlist::where('user_id', Auth::id())->count()
            ]);
        } else {
            return response()->json([
                'result' => 3,
                'message' => 'Product already in wishlist',
                'totalItems' => Wishlist::where('user_id', Auth::id())->count()
            ]);
        }
    }

    public function destroy($id)
    {
        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json([
                'result' => 1,
                'message' => 'Product removed from wishlist',
                'totalItems' => Wishlist::where('user_id', Auth::id())->count()
            ]);
        }

        return response()->json([
            'result' => 0,
            'message' => 'Product not found in wishlist'
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $wishlistItem = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlistItem) {
            // Remove from wishlist
            $wishlistItem->delete();
            return response()->json([
                'result' => 2,
                'message' => 'Product removed from wishlist',
                'totalItems' => Wishlist::where('user_id', Auth::id())->count(),
                'action' => 'removed'
            ]);
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'vendor_id' => $product->vendor_id,
            ]);
            
            return response()->json([
                'result' => 1,
                'message' => 'Product added to wishlist',
                'totalItems' => Wishlist::where('user_id', Auth::id())->count(),
                'action' => 'added'
            ]);
        }
    }

    public function count()
    {
        $count = Wishlist::where('user_id', Auth::id())->count();
        
        return response()->json([
            'count' => $count
        ]);
    }
}
