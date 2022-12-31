<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/', [UserController::class, 'registerOrLogin']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/{user}/promote', [UserController::class, 'promoteCustomer2Seller'])->
    middleware('can:' . config('setup.PERMISSIONS.USER_PROMOTE'));
    Route::post('/{user}/addresses', [UserController::class, 'addAddress']);
});
