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

    public function login($user, $password)
    {
        $user = $this->_userDao->getUserByCredentials($user, $password);
        if ($user) {
            $this->_user = $user;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return $user;
        }
        return false;
    }
}