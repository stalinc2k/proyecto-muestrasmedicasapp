<?php

use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ZoneController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('zone', ZoneController::class);
Route::resource('user', UserController::class);
