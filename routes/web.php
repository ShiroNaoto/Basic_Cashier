<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CartController;

Route::get('/', [DashboardController::class, 'index']);

Route::resource('products', ProductController::class);
Route::resource('sales', SaleController::class);

Route::resource('carts', CartController::class);
Route::delete('/carts/destroyCart', [CartController::class, 'destroyCart'])->name('carts.destroyCart');
Route::post('/addCart', [DashboardController::class, 'addCart'])->name('addCart');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('/orderlist', [CartController::class, 'orderlist'])->name('orderlist');
Route::post('/checkout', [CartController::class, 'processCheckout'])->name('processCheckout');

