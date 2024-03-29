<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PrivateChatController;
use App\Http\Controllers\PhoneVerificationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CustomBroadcastAuthController;
use App\Models\Restaurant;

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
Route::post('create-restaurant',[RestaurantController::class,'create']);
Route::post('verify-mobile-register', [PhoneVerificationController::class, 'register']);
Route::post('verify-mobile-reservation', [PhoneVerificationController::class, 'createReservation']);
Route::post('submit-reservation', [ReservationController::class, 'index']);
Route::get('submit-restaurant', [MenuController::class, 'getAllItemByRestaurant']);
Route::post('create/cartBeforeLogin',[CartController::class, 'createCartBeforeLogin']);
Route::get('getCartBeforeLogin',[CartController::class, 'getCartBeforeLogin']);
Route::group(['middleware' => 'auth.nodejs'],function (){
    Route::post('custom-broadcasting/auth', [CustomBroadcastAuthController::class,'authenticate']);
});
Route::group(['middleware' => 'auth.owner_nodejs'], function () {
   



    Route::group(
        ['prefix' => '/'],
        function () {
            Route::get('users', [UserController::class, 'getAllUsers']);
            Route::get('restaurant', [RestaurantController::class, 'index']);
            Route::post('restaurant', [RestaurantController::class, 'getRestaurantById']);
            Route::get('recipient',[UserController::class, 'getRecipient']);
            Route::get('order',[OrderController::class, 'getOrder']);
            Route::get('orderById',[OrderController::class, 'getOrderById']);
            Route::get('order-item',[OrderController::class,'getOrderItem']);
            Route::get('itemById',[ItemController::class,'getItemById']);
            Route::group(['prefix' => 'user'], function () {
                Route::get('/', [UserController::class, 'profile']);
                Route::get('/chat', [ChatController::class, 'getAllChat']);
            });
            Route::post('logout', [UserController::class, 'logout']);
            
            Route::get('private-chat', [PrivateChatController::class, 'getPrivateChat']);
            Route::post('findVoice', [PrivateChatController::class, 'findVoice']);
            Route::post('messages', [ChatController::class, 'sendMessage']);
            Route::post('private-messages', [PrivateChatController::class, 'index']);
            Route::post('combineCart',[CartController::class,'combineCart']);
        }
    );
    Route::get('cartByUserId', [CartController::class, 'find']);
    Route::post('removeCartById', [CartController::class, 'removeById']);
    Route::post('updateCartById',[CartController::class, 'UpdateById']);
    Route::group(['prefix' => 'create'], function () {
        Route::post('order', [OrderController::class, 'create']);
        Route::post('order-item', [OrderController::class, 'createOrderItem']);
        Route::post('cart', [CartController::class, 'create']);
        Route::post('claim', [ClaimController::class, 'create']);
    });
    Route::group(['prefix' => 'remove'], function () {
        Route::post('order', [OrderController::class, 'remove']);
        Route::post('cart', [CartController::class, 'remove']);
    });
    Route::group(['prefix' => 'update'], function () {
        Route::post('user', [UserController::class, 'update']);
        Route::post('cart', [CartController::class, 'remove']);
    });

    Route::post('stripe', [StripePaymentController::class, 'stripePost']);
    
});
Route::group(['prefix' => 'confirm'], function () {
    Route::group(['prefix' => 'create'], function () {
        Route::get('user', [UserController::class, 'confirm']);
    });
});

Route::post('menu', [MenuController::class, 'getAllItem']);

Route::get('restaurant/search', [RestaurantController::class, 'search']);
Route::get('orders',[OrderController::class, 'getAllOrders']);
Route::get('reservations',[ReservationController::class,'getAllReservations']);
//forgot password
Route::group(['prefix' => 'forgot-password'], function () {
    Route::post('email', [UserController::class, 'getEmail']);
    Route::post('reset-password', [UserController::class, 'resetPassword']);
});
Route::post('restaurant/find', [RestaurantController::class, 'getRestaurantByWebId']);
// admin
Route::group(['prefix' => 'admin'], function () {
    Route::post('login', [AdminController::class, 'login']);
    Route::group(['middleware' => 'auth.admin_nodejs'], function () {
        Route::post('logout', [AdminController::class, 'logout']);
        Route::get('users', [AdminController::class, 'users']);
        Route::get('chats_and_contacts', [AdminController::class, 'chats_and_contacts']);
        Route::get('chats', [AdminController::class, 'chats']);
        Route::post('create_chats',[AdminController::class,'createChats']);
        Route::get('restaurants', [AdminController::class, 'restaurants']);
        Route::get('claims',[AdminController::class,'claims']);
        Route::get('orders',[AdminController::class,'orders']);
        Route::post('sales',[AdminController::class,'sales']);
        Route::get('notifications',[AdminController::class,'notifications']);
        Route::post('updateIsReadForAll',[AdminController::class,'updateIsReadForAll']);
        Route::post('updateIsReadByNotificationId',[AdminController::class,'updateIsReadByNotificationId']);
        Route::post('deleteNotificationById',[AdminController::class,'deleteNotificationById']);
        Route::post('approveClaimById',[AdminController::class,'approveClaimById']);
        Route::get('viewClaimById', [AdminController::class, 'viewClaimById']);
        Route::get('viewUserById', [AdminController::class, 'viewUserById']);
        Route::post('updateRestaurantById', [AdminController::class, 'updateRestaurantById']);
        Route::get('viewRestaurantById', [AdminController::class, 'viewRestaurantById']);
        Route::get('viewRestaurantsByUserId', [AdminController::class, 'viewRestaurantsByUserId']);
        Route::get('viewItemsByOrderId', [AdminController::class, 'viewItemsByOrderId']);
        Route::post('closeRestaurantById', [AdminController::class, 'closeRestaurantById']);
        Route::post('updateUserById', [AdminController::class, 'updateUserById']);
        Route::post('deleteUserById', [AdminController::class, 'deleteUserById']);
        Route::get('viewOrderById', [AdminController::class, 'viewOrderById']);
        Route::get('viewOrdersByRestaurantId', [AdminController::class, 'viewOrdersByRestaurantId']);
        Route::post('updateOrderById', [AdminController::class, 'updateOrderById']);
        Route::post('deleteOrderById', [AdminController::class, 'deleteOrderById']);
        Route::post('viewReservationById', [AdminController::class, 'viewReservationById']);
        Route::post('updateReservationById', [AdminController::class, 'updateReservationById']);
        Route::post('deleteReservationById', [AdminController::class, 'deleteReservationById']);
    });
});
Route::group(['prefix' => 'owner'], function () {
    Route::post('login', [OwnerController::class, 'login']);
    Route::group(['middleware' => 'auth.owner_nodejs'], function () {
    
        Route::post('logout', [OwnerController::class, 'logout']);
        Route::get('users', [OwnerController::class, 'users']);
        Route::get('contacts', [OwnerController::class, 'contacts']);
        Route::get('chats_and_contacts', [OwnerController::class, 'chats_and_contacts']);
        Route::get('chats', [OwnerController::class, 'chats']);
        Route::post('create_chats',[OwnerController::class,'createChats']);
        Route::get('restaurants', [OwnerController::class, 'restaurants']);
        Route::get('items',[OwnerController::class,'items']);
        Route::get('orders',[OwnerController::class,'orders']);
        Route::post('sales',[OwnerController::class,'sales']);
        Route::get('notifications',[OwnerController::class,'notifications']);
        Route::post('updateIsReadForAll',[OwnerController::class,'updateIsReadForAll']);
        Route::post('updateIsReadByNotificationId',[OwnerController::class,'updateIsReadByNotificationId']);
        Route::post('deleteNotificationById',[OwnerController::class,'deleteNotificationById']);
        Route::post('approveClaimById',[OwnerController::class,'approveClaimById']);
        Route::get('viewClaimById', [OwnerController::class, 'viewClaimById']);
        Route::get('viewUserById', [OwnerController::class, 'viewUserById']);
        Route::get('viewItemById', [OwnerController::class, 'viewItemById']);
        Route::get('viewItemsByRestaurantId',[OwnerController::class,'viewItemsByRestaurantId']);
        Route::post('updateRestaurantById', [OwnerController::class, 'updateRestaurantById']);
        Route::get('viewRestaurantById', [OwnerController::class, 'viewRestaurantById']);
        Route::get('viewRestaurantsByUserId', [OwnerController::class, 'viewRestaurantsByUserId']);
        Route::get('viewItemsByOrderId', [OwnerController::class, 'viewItemsByOrderId']);
        Route::post('closeRestaurantById', [OwnerController::class, 'closeRestaurantById']);
        Route::post('updateUserById', [OwnerController::class, 'updateUserById']);
        Route::post('deleteUserById', [OwnerController::class, 'deleteUserById']);
        Route::get('viewOrderById', [OwnerController::class, 'viewOrderById']);
        Route::get('viewOrdersByRestaurantId', [OwnerController::class, 'viewOrdersByRestaurantId']);
        Route::post('updateOrderById', [OwnerController::class, 'updateOrderById']);
        Route::post('deleteOrderById', [OwnerController::class, 'deleteOrderById']);
        Route::post('viewReservationById', [OwnerController::class, 'viewReservationById']);
        Route::post('updateReservationById', [OwnerController::class, 'updateReservationById']);
        Route::post('deleteReservationById', [OwnerController::class, 'deleteReservationById']);
    });

});

