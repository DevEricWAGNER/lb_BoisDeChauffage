<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => 'Accueil']);
})->name('home');

Route::get('/shop', [ProductsController::class, 'getProducts'])->name('shop.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Cart
    Route::get('cart', [CartController::class, 'cart'])->name('cart');
    Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add_to_cart');
    Route::patch('update-cart', [CartController::class, 'update'])->name('update_cart');
    Route::delete('remove-from-cart', [CartController::class, 'remove'])->name('remove_from_cart');
    // Commands
    Route::get('/commandes', [ProfileController::class, 'commandes'])->name('commandes');
    Route::get('/adresses', [ProfileController::class, 'adresses'])->name('adresses');
    Route::post('/createAdress', [AdressController::class, 'store'])->name('createAdress');
    Route::get('/showDetails/{id}', [ProfileController::class, 'showDetailsCommande'])->name('showDetails');
});

Route::prefix('/admin')->group(function() {
    Route::get('/commandes', [AdminController::class, 'commandes'])->name('admin.commandes');
    Route::post('/changeStatus', [AdminController::class, 'changeStatus'])->name('admin.changeStatus');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::post('/products', [StripeController::class, 'createProducts'])->name('createProducts');
    Route::post('/products/{id}/edit', [AdminController::class, 'updateProductByProductId'])->name('admin.products.edit');
    Route::delete('/products/{id}/delete', [AdminController::class, 'deleteProductBYproductId'])->name('admin.products.delete');
});

// routes/web.php
Route::post('/session', [StripeController::class, 'session'])->name('session');
Route::get('/success', [StripeController::class, 'success'])->name('success');
Route::get('/cancel', [StripeController::class, 'cancel'])->name('cancel');

Route::get('/terms', function () {
    return view('terms');
})->name('terms', ['title' => 'Termes et conditions']);
Route::get('/politique', function () {
    return view('politique', ['title' => 'Politique de confidentialité']);
})->name('politique');


require __DIR__.'/auth.php';
