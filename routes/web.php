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

Route::get('/', function () {
    return view('welcome'); // Или ваша главная страница
})->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home'); // Или другое имя маршрута

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
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::post('/profile/add-category', [ProfileController::class, 'addCategory'])->name('profile.add-category');
    Route::post('/profile/add-product', [ProfileController::class, 'addProduct'])->name('profile.add-product');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});


Route::get('/products/{product}', [HomeController::class, 'show'])->name('products.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::middleware('auth')->group(function () {
    // Корзина
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    
    // Избранное
    Route::post('/favourites/toggle/{product}', [FavouriteController::class, 'toggle'])->name('favourites.toggle');
    Route::get('/favourites', [FavouriteController::class, 'index'])->name('favourites.index');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/orders', [OrderController::class, 'placeOrder'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

    

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/check-promocode', [PromocodeController::class, 'check'])->name('promocode.check');
    Route::post('/promocode/check', [OrderController::class, 'checkPromocode'])->name('promocode.check');
    Route::post('/check-promocode', [PromocodeController::class, 'checkPromocode']);
    Route::post('/promocodes', [PromocodeController::class, 'store'])->name('promocodes.store');
    Route::delete('/promocodes/{promocode}', [PromocodeController::class, 'destroy'])->name('promocodes.destroy');
});



    
