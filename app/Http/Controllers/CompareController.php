<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CompareController extends Controller
{
    public function index()
    {
        $compareItems = $this->getCompareItems();
        return view('visitors.compare', compact('compareItems'));
    }

    public function add(Request $request)
    {
        // Debug: Log the incoming request data
        \Log::info('Compare add request:', [
            'all_data' => $request->all(),
            'product_id' => $request->product_id,
            'headers' => $request->headers->all()
        ]);

        try {
            $request->validate([
                'product_id' => 'required|exists:products,id'
            ], [
                'product_id.required' => 'Product ID is required.',
                'product_id.exists' => 'The selected product does not exist.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Compare validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }

        $productId = $request->product_id;
        
        // Get current compare list from session
        $compareList = Session::get('compare_list', []);
        
        // Check if product already in compare list
        if (in_array($productId, $compareList)) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in compare list'
            ]);
        }
        
        // Limit to 4 products for comparison
        if (count($compareList) >= 4) {
            return response()->json([
                'success' => false,
                'message' => 'You can compare maximum 4 products at a time'
            ]);
        }
        
        // Add product to compare list
        $compareList[] = $productId;
        Session::put('compare_list', $compareList);
        
        \Log::info('Product added to compare list:', [
            'product_id' => $productId,
            'total_items' => count($compareList),
            'compare_list' => $compareList
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to compare list successfully',
            'totalItems' => count($compareList)
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $productId = $request->product_id;
        
        // Get current compare list from session
        $compareList = Session::get('compare_list', []);
        
        // Remove product from compare list
        $compareList = array_filter($compareList, function($id) use ($productId) {
            return $id != $productId;
        });
        
        // Reset array keys
        $compareList = array_values($compareList);
        
        Session::put('compare_list', $compareList);
        
        return response()->json([
            'success' => true,
            'message' => 'Product removed from compare list',
            'totalItems' => count($compareList)
        ]);
    }

    public function clear()
    {
        Session::forget('compare_list');
        
        return response()->json([
            'success' => true,
            'message' => 'Compare list cleared',
            'totalItems' => 0
        ]);
    }

    public function count()
    {
        $compareList = Session::get('compare_list', []);
        
        return response()->json([
            'totalItems' => count($compareList)
        ]);
    }

    public function checkProduct($productId)
    {
        $compareList = Session::get('compare_list', []);
        $isInCompare = in_array($productId, $compareList);
        
        return response()->json([
            'isInCompare' => $isInCompare,
            'totalItems' => count($compareList)
        ]);
    }

    public function getCompareList()
    {
        $compareList = Session::get('compare_list', []);
        
        return response()->json([
            'compareList' => $compareList,
            'totalItems' => count($compareList)
        ]);
    }

    private function getCompareItems()
    {
        $compareList = Session::get('compare_list', []);
        
        if (empty($compareList)) {
            return collect();
        }
        
        return Product::whereIn('id', $compareList)
            ->where('status', 'active')
            ->with(['vendor', 'category'])
            ->get();
    }
}
