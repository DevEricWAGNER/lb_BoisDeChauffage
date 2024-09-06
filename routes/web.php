<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdressController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectInfoController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/shop', [ProductsController::class, 'shop'])->name('shop.index');

Route::get('/dashboard',[ProjectInfoController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('cart', [ProductsController::class, 'cart'])->name('cart');
    Route::post('add-to-cart', [ProductsController::class, 'addToCart'])->name('add_to_cart');
    Route::patch('update-cart', [ProductsController::class, 'update'])->name('update_cart');
    Route::delete('remove-from-cart', [ProductsController::class, 'remove'])->name('remove_from_cart');
    Route::get('/commandes', [ProfileController::class, 'commandes'])->name('commandes');
    Route::get('/adresses', [ProfileController::class, 'adresses'])->name('adresses');
    Route::post('/createAdress', [AdressController::class, 'store'])->name('createAdress');

    Route::get('/showDetails/{id}', [ProfileController::class, 'showDetailsCommande'])->name('showDetails');
});

Route::prefix('/admin')->group(function() {
    Route::get('/commandes', [AdminController::class, 'commandes'])->name('admin.commandes');
    Route::post('/changeStatus', [AdminController::class, 'changeStatus'])->name('admin.changeStatus');
});

Route::post('/session', [StripeController::class, 'session'])->name('session');
Route::get('/success', [StripeController::class, 'success'])->name('success');
Route::get('/cancel', [StripeController::class, 'cancel'])->name('cancel');


Route::get('/projectInfos', [ProjectInfoController::class, 'getInfos'])->name('projectInfos.index');


require __DIR__.'/auth.php';
