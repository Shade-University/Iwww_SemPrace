<?php
require_once './classes/dao/UserDaoImpl.php';
require_once './classes/UserService.php';


class LoginPageController
{
    protected $_userDao;

    protected $_userService;

    public function __construct()
    {
        $this->_userDao = new UserDaoImpl();
        $this->_userService = new UserService($this->_userDao);
    }

    public function login($user, $password, $remember)
    {
        $dbUser = $this->_userService->login($user, $password);
        if ($dbUser && $_POST['remember'] == "on") {
            $hour = time() + 3600 * 24 * 30;
            setcookie("userid", $dbUser['id'], $hour);
            setcookie('email', $user, $hour);
            setcookie("active", 1, $hour);
        } //Remember me not working, too hard to secure it
        return $dbUser;
    }
}