<?php
require_once './classes/dao/UserDao.php';
require_once './classes/Connection.php';


class UserDaoImpl implements UserDao
{
    protected $_db;

    public function __construct()
    {
        $this->_db = Connection::getPdoInstance();
    }

    function getUserByCredentials($email, $password)
    {
        $stmt = $this->_db->prepare("SELECT * FROM User WHERE email = :email AND password = :password");
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        return $stmt->fetch();
    }
}