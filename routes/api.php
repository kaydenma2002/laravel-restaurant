<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\ReservationController;


use App\Models\User;
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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [UserController::class, 'logout']);

    Route::get('user', [UserController::class, 'profile']);
    Route::get('menu', [MenuController::class, 'getAllItem']);
    Route::get('cartByUserId',[CartController::class,'find']);
    Route::group(['prefix' => 'create'], function () {
        Route::post('order', [OrderController::class, 'create']);
        Route::post('cart',[CartController::class,'create']);
    });
    Route::group(['prefix' => 'remove'], function () {
        Route::post('order', [OrderController::class, 'remove']);
        Route::post('cart',[CartController::class,'remove']);
    });
    Route::post('stripe', [StripePaymentController::class, 'stripePost']);

});
Route::post('createReservation', [ReservationController::class, 'create']);
Route::get('users', [UserController::class, 'getAllUsers']);

