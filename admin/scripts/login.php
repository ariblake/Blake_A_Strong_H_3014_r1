<?php

function login($username, $password){
    // debug
    // sprintf lets us use placeholders that fill in with the value at the end
    $message = sprintf('You are trying to log in with username %s and password %s', $username, $password);
    return $message;
}