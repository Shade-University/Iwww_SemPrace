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

    public function getUserByCredentials($email, $password)
    {
        $stmt = $this->_db->prepare("SELECT * FROM User WHERE email = :email AND password = :password");
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function updateRememberMe($hash, $id)
    {
        $stmt = $this->_db->prepare("UPDATE User SET rememberme_hash = :hash WHERE id = :id");
        $stmt->bindParam(":hash", $hash);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function getByRememberCookie($cookie)
    {
        $stmt = $this->_db->prepare("SELECT * FROM User WHERE rememberme_hash = :hash");
        $stmt->bindParam(":hash", $cookie);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllUsers(): array
    {
        $stmt = $this->_db->prepare("SELECT * FROM User");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function insertUser($firstname, $lastname, $email, $password, $role)
    {
        $stmt = $this->_db->prepare("INSERT INTO User(firstname, lastname, email, password, role)
         VALUES(:firstname, :lastname, :email, :password, :role)");
        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":lastname", $lastname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":role", $role);
        $stmt->execute();
    }

    public function deleteUserById($userId)
    {
        $stmt = $this->_db->prepare("DELETE FROM User WHERE id = :id");
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
    }

    public function updateUser($id, $firstname, $lastname, $email, $password, $role)
    {
        $stmt = $this->_db->prepare("UPDATE User SET
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                password = :password,
                role = :role WHERE id = :id");

        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":lastname", $lastname);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function getUserById($userId)
    {
        $stmt = $this->_db->prepare("SELECT * FROM User WHERE id = :id");
        $stmt->bindParam(":id", $userId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getUserByEmail($email)
    {
        $stmt = $this->_db->prepare("SELECT * FROM User WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch();
    }
}