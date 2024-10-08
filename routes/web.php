<?php
require __DIR__.'/auth.php';

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;




Route::get('/products/create', [ProductController::class, 'create'])->name('products.create')->middleware('auth');


Route::post('/products/store', [ProductController::class, 'store'])->name('products.store')->middleware('auth');


