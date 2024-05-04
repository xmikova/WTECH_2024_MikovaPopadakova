<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('landing');
});

Route::get('/landing', [LandingController::class, 'index'])->name('landing');
Route::get('/footer-contents', [FooterController::class, 'index'])->name('footer.contents');

Route::get('/category/{category}', [CategoryController::class, 'showByCategory'])->name('products.category');

Route::get('/products/{productId}', [ProductController::class, 'show'])->name('products.show');

Route::get('/products', [ProductsController::class, 'searchProducts'])->name('products.search');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('product.update');

});

Route::get('/admin', [AdminController::class, 'index'])->name('admin');



Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');


Route::get('/delivery', [CartDeliveryController::class, 'index'])->name('delivery.index');
Route::post('/delivery/store', [CartDeliveryController::class, 'storeDelivery'])->name('delivery.store');

Route::get('/payment', [CartPaymentController::class, 'index'])->name('payment.index');
Route::post('/payment/store', [CartPaymentController::class, 'storePayment'])->name('payment.store');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');



require __DIR__.'/auth.php';
