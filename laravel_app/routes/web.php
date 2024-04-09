<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;

Route::get('/index', [LandingController::class, 'index'])->name('landing');
Route::get('/products/{category}', [ProductController::class, 'showByCategory'])->name('products.category');
