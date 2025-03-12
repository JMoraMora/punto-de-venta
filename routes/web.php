<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Middleware\EnsureUserHasRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    Route::middleware(EnsureUserHasRole::class . ':administrator')->group(function () {
        Route::controller(ProductController::class)->group(function () {
            Route::get('/products', 'index')->name('products.index');
            Route::get('/products/create', 'create')->name('products.create');
            Route::post('/products', 'store')->name('products.store');
            Route::get('/products/{product}', 'show')->name('products.show');
            Route::get('/products/{product}/edit', 'edit')->name('products.edit');
            Route::put('/products/{product}', 'update')->name('products.update');
            Route::delete('/products/{product}', 'destroy')->name('products.destroy');
        });
    });

    Route::middleware(EnsureUserHasRole::class.':seller,administrator')->group(function () {
        Route::controller(SaleController::class)->group(function () {
            Route::get('/sales', 'index')->name('sales.index');
            Route::get('/sales/create', 'create')->name('sales.create');
            Route::post('/sales', 'store')->name('sales.store');
            Route::get('/sales/{sale}/edit', 'edit')->name('sales.edit');
            Route::put('/sales/{sale}', 'update')->name('sales.update');
            Route::delete('/sales/{sale}', 'destroy')->name('sales.destroy');
        });
    });

});

require __DIR__.'/auth.php';