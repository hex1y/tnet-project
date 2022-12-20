<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']) ;
});

Route::middleware('auth:sanctum')->prefix('me')->group(function () {
    Route::get('/', [AuthController::class, 'getAuthUser']);

    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'getUserCart']);
        Route::post('/add/{product}', [CartController::class, 'addProduct']);
        Route::post('/update/{product}/{quantity}', [CartController::class, 'setQuantity']);
        Route::post('/remove/{product}', [CartController::class, 'removeProduct']);
    });
});
