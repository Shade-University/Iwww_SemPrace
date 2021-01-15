<?php


interface UserDao
{
    function getUserByCredentials($email, $password);
    function updateRememberMe($hash, $id);
    function getByRememberCookie($cookie);

    function getAllUsers();
    function insertUser($firstname, $lastname, $email, $password, $role);
    function updateUser($id, $firstname, $lastname, $email, $password, $role);
    public function geUserById($userId);
    public function deleteUser($userId);
}