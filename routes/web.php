<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromocodeController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');

// Маршруты аутентификации
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Маршруты для личного кабинета
Route::middleware('auth')->group(function () {
     // Профиль
     Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
     Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
     Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
     Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
     
     // Корзина
     Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
     Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
     Route::get('/cart/add-again/{product}/{quantity}', [CartController::class, 'addAgain'])->name('cart.add-again');
     Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
     Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
     Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
     
     // Заказы
     Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
     Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
     Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
     Route::post('/orders', [OrderController::class, 'placeOrder'])->name('orders.store');
});

// Маршруты для категорий и продуктов 
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

