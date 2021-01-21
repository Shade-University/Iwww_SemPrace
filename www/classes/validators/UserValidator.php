<?php
require_once './classes/dao/UserDao.php';
require_once './classes/validators/Validator.php';

class UserValidator implements Validator
{
    protected $_userDao;

    public function __construct(UserDao $userDao)
    {
        $this->_userDao = $userDao;
    }

    public function validate($data, &$msg): bool
    {
        $validRoles = array("student", "admin", "teacher");
        if (empty($data['firstname'])
            ||
            empty($data['lastname'])
            ||
            empty($data['email'])
            ||
            empty($data['password'])
            ||
            empty($data['role'])) {
            $msg = "Values cannot be empty";
            return false;
        }

        if (strlen($data['firstname']) > 250
            ||
            strlen($data['lastname']) > 250
            ||
            strlen($data['email']) > 250
            ||
            strlen($data['password']) > 50
            ||
            strlen($data['role']) > 50) {
            $msg = "Max size exceeded";
            return false;
        }

        if (!in_array($data['role'], $validRoles)) {
            $msg = "Invalid role";
            return false;
        }

        if (strpos($data['email'], "@") == false) { //Regex would be better
            $msg = "Email is not valid";
            return false;
        }

        if($data['action'] == "addUser" && $this->_userDao->getUserByEmail($data['email']) != null) {
            $msg = "User with same email already exists";
            return false;
        }

        return true;
    }

}