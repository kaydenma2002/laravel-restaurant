<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\RestaurantController;

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
    

    
    Route::group(
        ['prefix' => '/'],
        function () {
            Route::get('restaurant', [RestaurantController::class, 'index']);
            Route::get('user', [UserController::class, 'profile']);
            Route::post('logout', [UserController::class, 'logout']);
            Route::get('menu', [MenuController::class, 'getAllItem']);
        }
    );
    Route::get('cartByUserId', [CartController::class, 'find']);
    Route::group(['prefix' => 'create'], function () {
        Route::post('order', [OrderController::class, 'create']);
        Route::post('cart', [CartController::class, 'create']);
        Route::post('demo', [DemoController::class, 'create']);
    });
    Route::group(['prefix' => 'remove'], function () {
        Route::post('order', [OrderController::class, 'remove']);
        Route::post('cart', [CartController::class, 'remove']);
    });

    Route::post('stripe', [StripePaymentController::class, 'stripePost']);
    Route::get('restaurant/search', [RestaurantController::class, 'search']);
});
Route::group(['prefix' => 'confirm'], function () {
    Route::group(['prefix' => 'create'], function () {
        Route::get('user', [UserController::class, 'confirm']);
    });
});
Route::get('users', [UserController::class, 'getAllUsers']);
