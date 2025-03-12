<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('products.index');
    Route::get('/products/create', 'create')->name('products.create');
    Route::post('/products', 'store')->name('products.store');
    Route::get('/products/{product}', 'show')->name('products.show');
    Route::get('/products/{product}/edit', 'edit')->name('products.edit');
    Route::put('/products/{product}', 'update')->name('products.update');
    Route::delete('/products/{product}', 'destroy')->name('products.destroy');
});

Route::controller(SaleController::class)->group(function () {
    Route::get('/sales', 'index')->name('sales.index');
    Route::get('/sales/create', 'create')->name('sales.create');
    Route::post('/sales', 'store')->name('sales.store');
    Route::get('/sales/{sale}/edit', 'edit')->name('sales.edit');
    Route::put('/sales/{sale}', 'update')->name('sales.update');
    Route::delete('/sales/{sale}', 'destroy')->name('sales.destroy');
});