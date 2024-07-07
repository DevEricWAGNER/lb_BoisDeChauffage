<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectInfoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard',[ProjectInfoController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/projectInfos', [ProjectInfoController::class, 'getInfos'])->name('projectInfos.index');

require __DIR__.'/auth.php';
