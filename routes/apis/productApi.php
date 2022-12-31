<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/', [ProductController::class, 'addProduct'])->
middleware('can:' . config('setup.PERMISSIONS.ADD_PRODUCT'));
Route::get('/', [ProductController::class, 'getAllProducts']);
