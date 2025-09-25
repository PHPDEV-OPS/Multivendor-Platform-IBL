<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitorsController;
use Illuminate\Support\Facades\Route;

// Main home page
Route::get('/', [VisitorsController::class, 'index'])->name('home');

// About page
Route::get('/about-us', [VisitorsController::class, 'about'])->name('about-us');

// Blog page
Route::get('/blogs', [VisitorsController::class, 'blogs'])->name('blogs');
Route::get('/track-order', [VisitorsController::class, 'track'])->name('track-order');
Route::post('/track-order', [VisitorsController::class, 'trackOrder'])->name('track-order.search');
Route::get('/categories', [VisitorsController::class, 'categories'])->name('categories');
Route::get('/category/{slug}', [VisitorsController::class, 'categoryProducts'])->name('category.products');
Route::get('/product/{slug}', [VisitorsController::class, 'productDetail'])->name('product.show');

// Compare routes
Route::get('/compare', [App\Http\Controllers\CompareController::class, 'index'])->name('compare');
Route::post('/compare/add', [App\Http\Controllers\CompareController::class, 'add'])->name('compare.add');
Route::post('/compare/remove', [App\Http\Controllers\CompareController::class, 'remove'])->name('compare.remove');
Route::post('/compare/clear', [App\Http\Controllers\CompareController::class, 'clear'])->name('compare.clear');
Route::get('/compare/count', [App\Http\Controllers\CompareController::class, 'count'])->name('compare.count');
Route::get('/compare/check/{productId}', [App\Http\Controllers\CompareController::class, 'checkProduct'])->name('compare.check');
Route::get('/compare/list', [App\Http\Controllers\CompareController::class, 'getCompareList'])->name('compare.list');
// Cart routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/store', [App\Http\Controllers\CartController::class, 'add'])->name('cart.store'); // Alias for cart.add
Route::post('/cart/delete', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.delete'); // Alias for cart.remove
Route::post('/cart/delete-all', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.delete-all'); // Alias for cart.clear
Route::put('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'getCartCount'])->name('cart.count');

// Checkout routes
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/waiting/{orderNumber}', [App\Http\Controllers\CheckoutController::class, 'waiting'])->name('order.waiting');
Route::get('/order/success/{orderNumber}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('order.success');
Route::get('/order/status/{orderNumber}', [App\Http\Controllers\CheckoutController::class, 'checkStatus'])->name('order.status');

// Debug route to test order lookup by CheckoutRequestID
Route::get('/debug/find-order/{checkoutRequestId}', function($checkoutRequestId) {
    $order = \App\Models\Order::where('checkout_request_id', $checkoutRequestId)
        ->where('payment_status', 'pending')
        ->first();

    $allPendingOrders = \App\Models\Order::where('payment_status', 'pending')
        ->whereNotNull('checkout_request_id')
        ->get(['id', 'order_number', 'checkout_request_id', 'created_at']);

    return response()->json([
        'searched_for' => $checkoutRequestId,
        'found_order' => $order,
        'all_pending_orders_with_checkout_id' => $allPendingOrders
    ]);
})->name('debug.find-order');
Route::get('/merchant', [VisitorsController::class, 'merchant'])->name('merchant');
Route::get('/merchant/apply', [VisitorsController::class, 'merchantApply'])->name('merchant.apply');
// Quick view route
Route::post('/item-details-for-get-modal.html', [VisitorsController::class, 'quickView'])->name('quick.view');
// Contact page
Route::get('/contact-us', [VisitorsController::class, 'contact'])->name('contact-us');
Route::get('/compare', [VisitorsController::class, 'compare'])->name('compare');
Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist');

// Wishlist API routes
Route::middleware('auth')->group(function () {
    Route::post('/wishlist/store', [App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::post('/wishlist/toggle', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist/count', [App\Http\Controllers\WishlistController::class, 'count'])->name('wishlist.count');
});

// Remove generic dashboard route - users should go to role-specific dashboards
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/vendor.php';
require __DIR__.'/user.php';
require __DIR__.'/admin.php';



Route ::post('/callback', [App\Http\Controllers\CheckoutController::class, 'callback'])->name('callback');

// Test PDF generation route
Route::get('/test-pdf', function() {
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.orders.pdf', [
        'order' => \App\Models\Order::with(['items.product', 'user'])->first()
    ]);
    $pdf->setPaper([0, 0, 226.77, 841.89], 'portrait');
    $pdf->setOptions([
        'isHtml5ParserEnabled' => true,
        'isPhpEnabled' => true,
        'defaultFont' => 'DejaVuSansMono',
        'dpi' => 96,
        'defaultPaperSize' => 'custom'
    ]);
    return $pdf->stream('test.pdf');
})->name('test.pdf');

// Test password reset route
Route::get('/test-password-reset', function() {
    $user = \App\Models\User::first();
    if ($user) {
        $token = \Illuminate\Support\Facades\Password::createToken($user);
        return response()->json([
            'user_email' => $user->email,
            'token' => $token,
            'reset_url' => route('password.reset', $token)
        ]);
    }
    return response()->json(['error' => 'No users found']);
})->name('test.password.reset');
