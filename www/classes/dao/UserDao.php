<?php


interface UserDao
{
    function getUserByCredentials($email, $password);
}