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

        $this->mapping = array("admin" => "AdministrationPage",
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

        if ($_POST['remember'] == "on") {
            $this->setRememberMe($dbUser);
        }

        header('Location: index.php?page=' . $this->mapping[$dbUser['role']]);
    }

    public function renderError()
    {
        echo $this->_msg;
    }

    private function setRememberMe($dbUser)
    {
        $cookiehash = md5(sha1($dbUser['email'] . $_SERVER['REMOTE_ADDR']));
        $params = session_get_cookie_params();
        setcookie("remember",
            $cookiehash,
            time() + 60*60*24*30,
            $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        //Too hard to do. Probably the best way is generate "random" hash which should be saved to database
    }
}