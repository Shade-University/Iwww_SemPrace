<?php


interface UserDao
{
    function getUserByCredentials($email, $password);
    function updateRememberMe($hash, $id);
    function getByRememberCookie($cookie);
}