<?php

use Illuminate\Support\Facades\Route;

// User Dashboard Routes
Route::prefix('user')->middleware(['auth', 'verified', 'role:user'])->group(function () {
    // Dashboard
    Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');

    // Products Management
    Route::get('/products', function () {
        return view('user.products.index');
    })->name('user.products');

    Route::get('/products/create', function () {
        return view('user.products.create');
    })->name('user.products.create');

    Route::get('/products/{id}/edit', function ($id) {
        return view('user.products.edit', compact('id'));
    })->name('user.products.edit');

    // Orders Management
    Route::get('/orders', [App\Http\Controllers\User\OrderController::class, 'index'])->name('user.orders');
    Route::get('/orders/{id}', [App\Http\Controllers\User\OrderController::class, 'show'])->name('user.orders.show');
    Route::get('/orders/{id}/download-pdf', [App\Http\Controllers\User\OrderController::class, 'downloadPdf'])->name('user.orders.download-pdf');

    // Analytics & Reports
    Route::get('/analytics', function () {
        return view('user.analytics');
    })->name('user.analytics');

    Route::get('/reports', function () {
        return view('user.reports');
    })->name('user.reports');

    // Profile Management
    Route::get('/profile', [App\Http\Controllers\User\ProfileController::class, 'index'])->name('user.profile');
    Route::post('/profile/personal', [App\Http\Controllers\User\ProfileController::class, 'updatePersonal'])->name('user.profile.personal');
    Route::post('/profile/address', [App\Http\Controllers\User\ProfileController::class, 'updateAddress'])->name('user.profile.address');
    Route::post('/profile/picture', [App\Http\Controllers\User\ProfileController::class, 'updateProfilePicture'])->name('user.profile.picture');

    // Debug route
    Route::get('/profile/test', function() {
        $user = \Illuminate\Support\Facades\Auth::user();
        return response()->json([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'date_of_birth' => $user->date_of_birth,
            'gender' => $user->gender,
            'bio' => $user->bio,
            'primary_address' => $user->primary_address,
            'shipping_address' => $user->shipping_address,
            'profile_image' => $user->profile_image,
        ]);
    })->name('user.profile.test');

    // Store Management
    Route::get('/store', function () {
        return view('user.store');
    })->name('user.store');

    // Customers
    Route::get('/customers', function () {
        return view('user.customers');
    })->name('user.customers');

    // Promotions
    Route::get('/promotions', function () {
        return view('user.promotions');
    })->name('user.promotions');

    // Shipping
    Route::get('/shipping', function () {
        return view('user.shipping');
    })->name('user.shipping');

    // Finance
    Route::get('/finance', function () {
        return view('user.finance');
    })->name('user.finance');

    // Support
    Route::get('/support', function () {
        return view('user.support');
    })->name('user.support');
});
