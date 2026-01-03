<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\StoreImageController; // Tambahkan ini
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GeoController; // Pindahkan import GeoController ke sini

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;

// Customer Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/customer/dashboard', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('/customer/profile/edit', [CustomerController::class, 'editProfile'])->name('customer.profile.edit');
    Route::put('/customer/profile', [CustomerController::class, 'updateProfile'])->name('customer.profile.update');
    Route::get('/customer/orders', [CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/customer/orders/{order}', [CustomerController::class, 'showOrder'])->name('customer.orders.show');
});
Route::get('/', [HomeController::class, 'index']);
Route::get('/store-info', [HomeController::class, 'storeInfo'])->name('store.info');

// Public product routes (resourceful)

// Customer Registration Routes
use App\Http\Controllers\AuthController;
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Cart Routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::put('/update/{cart}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{cart}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::middleware(['auth'])->group(function () {
        Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [CartController::class, 'processCheckout'])->name('process-checkout');
        Route::get('/payment/confirm/{order}', [CartController::class, 'showPaymentConfirmation'])->name('payment.confirm');
        Route::post('/payment/upload/{order}', [CartController::class, 'uploadPaymentProof'])->name('payment.upload');
        Route::get('/success/{order}', [CartController::class, 'orderSuccess'])->name('success');
    });
    Route::get('/count', [CartController::class, 'getCartCount'])->name('count');
});

// Admin Routes
// Admin routes: controllers themselves will enforce admin access via BaseAdminController
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () { return redirect()->route('admin.dashboard'); });
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('products/export-pdf', [AdminProductController::class, 'exportPdf'])->name('products.export-pdf');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('store-images', StoreImageController::class)->only(['index', 'store', 'destroy']); // Tambahkan ini
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
    Route::get('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show']);
        Route::resource('reports', \App\Http\Controllers\Admin\ReportController::class)->only(['index']);
        Route::get('reports/cetak/pdf', [\App\Http\Controllers\Admin\ReportController::class, 'pdf'])->name('reports.pdf');
        Route::get('reports/stock', [\App\Http\Controllers\Admin\ReportController::class, 'stockReport'])->name('reports.stock');
        Route::get('reports/popular-products', [\App\Http\Controllers\Admin\ReportController::class, 'popularProductsReport'])->name('reports.popular-products');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('orders-statistics', [AdminOrderController::class, 'statistics'])->name('orders.statistics');

    // Store Settings
    Route::get('settings/store', [\App\Http\Controllers\Admin\StoreSettingController::class, 'index'])->name('settings.store.index');
    Route::put('settings/store', [\App\Http\Controllers\Admin\StoreSettingController::class, 'update'])->name('settings.store.update');

    // User Data Backup & Restore
    Route::get('users/backup', [AdminController::class, 'backupUsers'])->name('users.backup');
    Route::post('users/restore', [AdminController::class, 'restoreUsers'])->name('users.restore');
});

// Simple auth routes (login/logout) for admin access
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Public product routes (limited)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Legacy category controller kept for compatibility (admin has its own)
Route::resource('categories', CategoryController::class)->only(['index', 'show']);

