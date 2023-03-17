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
Broadcast::channel('private-chat.{userId1}.{userId2}', function ($user, $userId1, $userId2) {
    return ($user->id == $userId1 || $user->id == $userId2);
});