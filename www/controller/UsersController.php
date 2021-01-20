<?php
require_once './classes/dao/UserDaoImpl.php';
require_once './classes/Helpers.php';

class UsersController
{
    protected $_userDao;

    public function __construct()
    {
        $this->_userDao = new UserDaoImpl();
    }

    public function createUserTable()
    {
        $headers = array('ID', 'Role', 'Full name', 'Email', 'Actions');
        $users = $this->_userDao->getAllUsers();

        echo '<table id="usersTable">';
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '</tr>';

        foreach ($users as $user) {
            echo '<tr>';
            echo '<td>' . $user['id'] . '</td>';
            echo '<td>' . $user['role'] . '</td>';

            echo '<td>' . $user['firstname'] . " " . $user['lastname'] . '</td>';
            echo '<td>' . $user['email'] . '</td>';

            echo '<td><a href="index.php?page=AdministrationPage&deleteUser=' . $user['id'] . '" class="action-btn ab-delete" data-tooltip="Delete"
                        data-modal-anchor="delete-user"><img src="./img/delete.svg" alt="Delete"></a>
                  <a href="index.php?page=AdministrationPage&editUser=' . $user['id'] . '" class="action-btn ab-edit" data-tooltip="Edit" data-modal-anchor="edit-user">
                        <img src="./img/edit.svg" alt="Edit"></a></td>';

            echo '</tr>';
        }

        echo '</table';
    }

    public function createUser($data)
    {
        $errorMsg = "";
        if ($this->validateUser($data, $errorMsg)) {
            $this->_userDao->insertUser($data['firstname'],
                $data['lastname'], $data['email'], $data['password'], $data['role']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    public function deleteUser($userId)
    {
        $this->_userDao->deleteUserById($userId);
    }

    public function getUser($userId)
    {
        return $this->_userDao->geUserById($userId);
    }

    public function updateUser($data)
    {
        $errorMsg = "";
        if ($this->validateUser($data, $errorMsg)) {
            $this->_userDao->updateUser($data['id'], $data['firstname'],
                $data['lastname'], $data['email'], $data['password'], $data['role']);
        } else {
            Helpers::alert($errorMsg);
        }
    }

    private function validateUser($data, &$msg)
    {
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

        if ($data['role'] != "admin" && $data['role'] != "teacher" && $data['role'] != "student") {
            $msg = "Invalid role";
            return false;
        }

        if (strpos($data['email'], "@") == false) { //Regex would be better
            $msg = "Email is not valid";
            return false;
        }

        return true;
    }

}

