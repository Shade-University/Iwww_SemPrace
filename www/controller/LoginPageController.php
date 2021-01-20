<?php
require_once './classes/dao/UserDaoImpl.php';
require_once './classes/UserService.php';


class LoginPageController
{
    protected $_userDao;
    protected $_userService;
    protected $_msg;
    protected $mapping;

    public function __construct()
    {
        $this->_userDao = new UserDaoImpl();
        $this->_userService = new UserService($this->_userDao);

        $this->mapping = array(
            "admin" => "AdministrationPage",
            "teacher" => "TeacherPage",
            "student" => "StudentPage");
    }

    public function login($user, $password, $remember)
    {
        $dbUser = $this->_userService->login($user, $password);
        if ($dbUser == null) {
            $this->_msg = "Wrong credentials.";
            return;
        }

        if ($remember == "on") {
            $this->_userService->setRememberMe();
        } else {
            $this->_userService->unsetRememberMe();
        }

        header('Location: index.php?page=' . $this->mapping[$dbUser['role']]);
    }

    public function logout()
    {
        $this->_userService->logout();
        header("Location: index.php");
    }

    public function renderError()
    {
        echo $this->_msg;
    }

    public function checkByRememberCookie()
    {
        if (isset($_COOKIE['remember'])) {
            $dbUser = $this->_userService->loginByRememberMe($_COOKIE['remember']);

            if ($dbUser) {
                header('Location: index.php?page=' . $this->mapping[$dbUser['role']]);
            }
        }
    }

}