<?php
function authUser(){
    $userData = request()->get('authenticatedUser');
    return (object) $userData;
}
