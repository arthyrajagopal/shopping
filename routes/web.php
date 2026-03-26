<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\WishlistController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/remove/{key}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/update/{key}', [CartController::class, 'update'])->name('cart.update');
});

Route::prefix('compare')->group(function () {
    Route::get('/', [CompareController::class, 'index'])->name('compare.index');
    Route::post('/add/{id}', [CompareController::class, 'add'])->name('compare.add');
    Route::delete('/remove/{id}', [CompareController::class, 'remove'])->name('compare.remove');
});

Route::prefix('wishlist')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/remove/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});