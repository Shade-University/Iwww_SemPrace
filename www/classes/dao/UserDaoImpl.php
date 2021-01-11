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

    function updateRememberMe($hash, $id)
    {
        $stmt = $this->_db->prepare("UPDATE User SET rememberme_hash = :hash WHERE id = :id");
        $stmt->bindParam(":hash", $hash);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    function getByRememberCookie($cookie)
    {
        $stmt = $this->_db->prepare("SELECT * FROM User WHERE rememberme_hash = :hash");
        $stmt->bindParam(":hash", $cookie);
        $stmt->execute();
        return $stmt->fetch();
    }
}