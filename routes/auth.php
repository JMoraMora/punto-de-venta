<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', function () {
        return view('security.login');
    })->name('login');

    Route::post('login', [LoginController::class, 'authenticate']);
});

Route::get('logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');
