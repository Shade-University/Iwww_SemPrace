<?php


interface UserDao
{
    public function getUserByCredentials($email, $password);

    public function updateRememberMe($hash, $id);

    public function getByRememberCookie($cookie);

    public function getAllUsers(): array;

    public function insertUser($firstname, $lastname, $email, $password, $role);

    public function updateUser($id, $firstname, $lastname, $email, $password, $role);

    public function getUserById($userId);

    public function deleteUserById($userId);

    public function getUserByEmail($email);
}