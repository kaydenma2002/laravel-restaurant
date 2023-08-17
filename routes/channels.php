<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('user.{id}', function ($user, $id) {
    return true;
});

Broadcast::channel('reservation',function(){
    return true;
});

Broadcast::channel('user', function () {
    return true;
});
Broadcast::channel('order-create', function () {
    return true;
});
Broadcast::channel('claim-create', function () {
    return true;
});
Broadcast::channel('notification-create', function () {
    return true;
});
Broadcast::channel('private-chat.{userId1}.{userId2}', function (User $user, $userId1, $userId2) {
    return (int) $user->id === (int) $userId1 || (int)$user->id === (int) $userId2;
});
Broadcast::channel('private-super-admin-owner-chat.{super_admin_id}.{owner_id}',function (User $user, $super_admin_id, $owner_id) {
    return (int) $user->id === (int) $super_admin_id || (int)$user->id === (int) $owner_id;
});