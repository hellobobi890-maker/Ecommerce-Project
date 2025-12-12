<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [\App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [\App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');
Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{id}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

Route::controller(\App\Http\Controllers\PageController::class)->group(function () {
    Route::get('/about-us', 'about')->name('pages.about');
    Route::get('/contact-us', 'contact')->name('pages.contact');
    Route::get('/privacy-policy', 'privacy')->name('pages.privacy');
    Route::get('/return-policy', 'returnPolicy')->name('pages.return-policy');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');

    // Wishlist Routes
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [\App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [\App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);
});

require __DIR__ . '/auth.php';
