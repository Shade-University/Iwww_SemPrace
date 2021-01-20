<?php

class UserService
{
    protected $_userDao;

    protected $_user;

    public function __construct(UserDao $userDao)
    {
        $this->_db = Connection::getPdoInstance();
        $this->_userDao = $userDao;
    }

    public function login($user, $password) : array
    {
        $user = $this->_userDao->getUserByCredentials($user, $password);
        if ($user != null) {
            $this->_user = $user;
            $this->setSession($user);
            return $user;
        }
        return null;
    }

    public function setSession($dbUser)
    {
        $_SESSION['email'] = $dbUser['email'];
        $_SESSION['fullname'] = $dbUser['firstname'] . " " . $dbUser['lastname'];
        $_SESSION['role'] = $dbUser['role'];
        $_SESSION['id'] = $dbUser['id'];
    }
}