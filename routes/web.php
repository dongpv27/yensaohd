<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VNPayController;

Route::get('/', [ProductController::class, 'home'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/promotions', [ProductController::class, 'promotions']);

// News
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show']);

// Contact
Route::get('/contact', function () {
    return view('pages.contact');
});
Route::post('/contact/send', function (Illuminate\Http\Request $request) {
    // Validate the form
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);
    
    // Here you can send email or save to database
    // For now, just redirect back with success message
    return redirect()->back()->with('success', 'Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.');
});

// About
Route::get('/about', function () {
    return view('pages.about');
});

// Cart
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add/{product}', [CartController::class, 'add']);
Route::post('/cart/remove/{id}', [CartController::class, 'remove']);
Route::post('/cart/clear', [CartController::class, 'clear']);
Route::post('/cart/update/{id}', [CartController::class, 'update']);
Route::get('/checkout', [CartController::class, 'checkout']);
Route::post('/checkout', [CartController::class, 'processCheckout']);
Route::get('/order-confirmation', [CartController::class, 'orderConfirmation']);

// VNPay payment routes
Route::get('/vnpay/return', [VNPayController::class, 'return'])->name('vnpay.return');

// Admin routes (protected)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'destroy']);
    Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('news', AdminNewsController::class);
    Route::resource('users', AdminUserController::class);
});

// Simple auth routes (login/logout) used by middleware
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Test route to add sample cart items
Route::get('/test-cart', function () {
    $products = \App\Models\Product::take(3)->get();
    $cart = [];
    
    foreach ($products as $index => $product) {
        $cart[$product->id] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $index + 1,
            'image' => $product->image ?? 'products/error-404.png'
        ];
    }
    
    session(['cart' => $cart]);
    
    return redirect('/')->with('cart_success', 'Đã thêm ' . count($cart) . ' sản phẩm vào giỏ hàng!');
});
