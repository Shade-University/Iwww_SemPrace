<?php
require_once './classes/dao/UserDaoImpl.php';

class AdministrationPageController
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

        echo '<table id="userTable">';
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
                        data-modal-anchor="delete-user"><img src="./img/delete.svg"alt="Delete"></a>
                  <a href="index.php?page=AdministrationPage&editUser=' . $user['id'] . '" class="action-btn ab-edit" data-tooltip="Edit" data-modal-anchor="edit-user">
                        <img src="./img/edit.svg" alt="Edit"></a></td>';

            echo '</tr>';
        }

        echo '</table';
    }

    public function createUser($data)
    {
        if($this->validate($data)) {
            $this->_userDao->insertUser($data['firstname'],
                $data['lastname'], $data['email'], $data['password'], $data['role']);
        } else {
            $this->alert("Validation error");
        }
    }

    public function deleteUser($userId)
    {
        $this->_userDao->deleteUser($userId);
    }

    public function getUser($userId)
    {
        return $this->_userDao->geUserById($userId);
    }

    public function updateUser($data)
    {
        if($this->validate($data))
        {
            $this->_userDao->updateUser($data['id'], $data['firstname'],
                $data['lastname'], $data['email'], $data['password'], $data['role']);
        } else {
            $this->alert("Validation error");
        }
    }

    private function validate($data)
    {
        if(empty($data['firstname']) ||
            empty($data['lastname']) ||
            empty($data['email']) ||
            empty($data['password']) ||
            empty($data['role'])) {
            return false;
        }

        //TODO regex email
        return true;
    }

    private function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }



}