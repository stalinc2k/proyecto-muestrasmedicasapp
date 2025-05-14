<?php

use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\VisitorController;
use App\Http\Controllers\Dashboard\ZoneController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
});

Route::middleware(['auth', 'admin'])->prefix('dashboard')->group(function () {
    Route::resource('visitor', VisitorController::class);
    Route::resource('zone', ZoneController::class);
    Route::resource('product', ProductController::class);
});

require __DIR__.'/auth.php';
