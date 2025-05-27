<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Change the root route to use HomeController or directly return home view
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{product}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');

// Add this line for the categories.show route (assuming you're using this route in your view)
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Your existing public routes
Route::post('/add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add.to.cart');

// Dashboard routes protected by authentication
Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	// Add your admin/dashboard routes here
	// For example:
	// Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
});

// Include the authentication routes
require __DIR__.'/auth.php';