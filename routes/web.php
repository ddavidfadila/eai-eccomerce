<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'jwt.middleware'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('dashboard');
    Route::post('/cart', [UserController::class, 'addCart'])->name('addCart');
    Route::post('/delete-cart', [UserController::class, 'deleteCart'])->name('deleteCart');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
