<?php

use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\WaitingController;
use Illuminate\Support\Facades\Route;

// Vendor Waiting Page (for unverified vendors)
Route::prefix('vendor')->middleware(['auth', 'verified', 'role:vendor'])->group(function () {
    Route::get('/waiting', [WaitingController::class, 'index'])->name('vendor.waiting');
});

// Vendor Dashboard Routes (only for verified vendors)
Route::prefix('vendor')->middleware(['auth', 'verified', 'role:vendor', 'vendor.verified'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('vendor.dashboard');

    // Products Management
    Route::resource('products', \App\Http\Controllers\Vendor\ProductController::class, [
        'names' => [
            'index' => 'vendor.products',
            'create' => 'vendor.products.create',
            'store' => 'vendor.products.store',
            'show' => 'vendor.products.show',
            'edit' => 'vendor.products.edit',
            'update' => 'vendor.products.update',
            'destroy' => 'vendor.products.destroy',
        ]
    ]);

    Route::patch('/products/{id}/toggle-status', [\App\Http\Controllers\Vendor\ProductController::class, 'toggleStatus'])
        ->name('vendor.products.toggle-status');

    // Orders Management
    Route::get('/orders', [\App\Http\Controllers\Vendor\OrderController::class, 'index'])->name('vendor.orders');
    Route::get('/orders/export', [\App\Http\Controllers\Vendor\OrderController::class, 'export'])->name('vendor.orders.export');
    Route::get('/orders/{order}', [\App\Http\Controllers\Vendor\OrderController::class, 'show'])->name('vendor.orders.show');
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\Vendor\OrderController::class, 'updateStatus'])->name('vendor.orders.update-status');

    // Analytics & Reports
    Route::get('/analytics', [\App\Http\Controllers\Vendor\AnalyticsController::class, 'index'])->name('vendor.analytics');
    Route::get('/analytics/export', [\App\Http\Controllers\Vendor\AnalyticsController::class, 'export'])->name('vendor.analytics.export');

    Route::get('/reports', [\App\Http\Controllers\Vendor\ReportsController::class, 'index'])->name('vendor.reports');
    Route::get('/reports/export', [\App\Http\Controllers\Vendor\ReportsController::class, 'export'])->name('vendor.reports.export');

    // Profile & Settings
    Route::get('/profile', function () {
        return view('vendor.profile');
    })->name('vendor.profile');

    Route::get('/settings', function () {
        return view('vendor.settings');
    })->name('vendor.settings');

    // Store Management
    Route::get('/store', [\App\Http\Controllers\Vendor\StoreController::class, 'index'])->name('vendor.store');
    Route::post('/store/update', [\App\Http\Controllers\Vendor\StoreController::class, 'update'])->name('vendor.store.update');
    Route::post('/store/upload-logo', [\App\Http\Controllers\Vendor\StoreController::class, 'uploadLogo'])->name('vendor.store.upload-logo');
    Route::post('/store/upload-banner', [\App\Http\Controllers\Vendor\StoreController::class, 'uploadBanner'])->name('vendor.store.upload-banner');

    // Customers
    Route::get('/customers', function () {
        return view('vendor.customers');
    })->name('vendor.customers');

    // Promotions
    Route::get('/promotions', [\App\Http\Controllers\Vendor\PromotionsController::class, 'index'])->name('vendor.promotions');
    Route::get('/promotions/{promotion}', [\App\Http\Controllers\Vendor\PromotionsController::class, 'show'])->name('vendor.promotions.show');
    Route::get('/promotions/analytics/performance', [\App\Http\Controllers\Vendor\PromotionsController::class, 'analytics'])->name('vendor.promotions.analytics');
    Route::get('/promotions/export/data', [\App\Http\Controllers\Vendor\PromotionsController::class, 'export'])->name('vendor.promotions.export');

    // Shipping
    Route::get('/shipping', function () {
        return view('vendor.shipping');
    })->name('vendor.shipping');

    // Finance
    Route::get('/finance', [\App\Http\Controllers\Vendor\FinanceController::class, 'index'])->name('vendor.finance');
    Route::get('/finance/export', [\App\Http\Controllers\Vendor\FinanceController::class, 'export'])->name('vendor.finance.export');

    // Support
    Route::get('/support', function () {
        return view('vendor.support');
    })->name('vendor.support');
});
