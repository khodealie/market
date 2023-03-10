<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/', [ProductController::class, 'addProduct'])->
middleware('can:' . \App\Enums\PermissionName::ADD_PRODUCT->value);
Route::get('/', [ProductController::class, 'getAllProducts']);
Route::post('/{product}/add-to-cart', [InvoiceController::class, 'addProduct2Cart']);
