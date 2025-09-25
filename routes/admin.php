<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\MerchantApplicationController;
use Illuminate\Support\Facades\Route;

// Admin Dashboard Routes
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Products Management
    Route::resource('products', ProductController::class, ['as' => 'admin']);

    // Orders Management
    Route::resource('orders', OrderController::class, ['as' => 'admin']);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
    Route::get('orders/export', [OrderController::class, 'export'])->name('admin.orders.export');

    // Customers Management
    Route::get('customers', [CustomerController::class, 'index'])->name('admin.customers');
    Route::get('customers/{user}', [CustomerController::class, 'show'])->name('admin.customers.show');

    // Analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('admin.analytics');

    // Finance
    Route::get('finance', [FinanceController::class, 'index'])->name('admin.finance');

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('admin.reports');

    // Settings
    Route::get('settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('settings', [SettingController::class, 'update'])->name('admin.settings.update');

    // Support
    Route::get('support', [SupportController::class, 'index'])->name('admin.support');
    
    // Promotions Management
    Route::resource('promotions', PromotionController::class, ['as' => 'admin']);
    Route::get('promotions/banners/manage', [PromotionController::class, 'banners'])->name('admin.promotions.banners');
    Route::patch('promotions/{promotion}/toggle-status', [PromotionController::class, 'toggleStatus'])->name('admin.promotions.toggle-status');
    Route::patch('promotions/{promotion}/toggle-banner', [PromotionController::class, 'toggleBannerStatus'])->name('admin.promotions.toggle-banner');
    Route::post('promotions/{promotion}/duplicate', [PromotionController::class, 'duplicate'])->name('admin.promotions.duplicate');
    Route::get('promotions/analytics/performance', [PromotionController::class, 'analytics'])->name('admin.promotions.analytics');
    Route::get('promotions/export/csv', [PromotionController::class, 'export'])->name('admin.promotions.export');
    
    // Shipping
    Route::get('shipping', function() {
        return view('admin.shipping');
    })->name('admin.shipping');
    
    // Store
    Route::get('store', function() {
        return view('admin.store');
    })->name('admin.store');
    
    // Profile
    Route::get('profile', function() {
        return view('admin.profile');
    })->name('admin.profile');
    
    // Content Management
    Route::resource('content', ContentController::class, ['as' => 'admin']);
    
    // Merchant Applications Management
    Route::resource('merchant-applications', MerchantApplicationController::class, ['as' => 'admin'])->except(['create', 'store', 'edit', 'update']);
    Route::patch('merchant-applications/{application}/approve', [MerchantApplicationController::class, 'approve'])->name('admin.merchant-applications.approve');
    Route::patch('merchant-applications/{application}/reject', [MerchantApplicationController::class, 'reject'])->name('admin.merchant-applications.reject');
    Route::patch('merchant-applications/{application}/suspend', [MerchantApplicationController::class, 'suspend'])->name('admin.merchant-applications.suspend');
    Route::patch('merchant-applications/{application}/reactivate', [MerchantApplicationController::class, 'reactivate'])->name('admin.merchant-applications.reactivate');
    Route::get('merchant-applications/export/csv', [MerchantApplicationController::class, 'export'])->name('admin.merchant-applications.export');
});
