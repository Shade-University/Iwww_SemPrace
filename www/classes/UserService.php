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
        if ($user != null) {
            $this->_user = $user;
            $this->setSession();
            return $user;
        }
        return null;
    }

    public function loginByRememberMe($rememberMe)
    {
        $user = $this->_userDao->getByRememberCookie($rememberMe);
        if ($user != null) {
            $this->_user = $user;
            $this->setSession();
            return $user;
        }
        return null;
    }

    public function logout()
    {
        $this->unsetRememberMe();
        $this->unsetSession();
    }

    public function setRememberMe()
    {
        $cookiehash = md5(sha1($this->_user['email'] . $_SERVER['REMOTE_ADDR'])); //something generated
        $params = session_get_cookie_params();
        setcookie("remember",
            $cookiehash,
            time() + 60 * 60 * 24 * 30,
            $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

        $this->_userDao->updateRememberMe($cookiehash, $this->_user['id']);
    }

    public function unsetRememberMe()
    {
        $this->_userDao->updateRememberMe($this->_user['id'], "");
        setcookie("remember", "", time() - 3600); //Remove rememberme cookie
    }

    private function setSession()
    {
        $_SESSION['email'] = $this->_user['email'];
        $_SESSION['fullname'] = $this->_user['firstname'] . " " . $this->_user['lastname'];
        $_SESSION['role'] = $this->_user['role'];
        $_SESSION['id'] = $this->_user['id'];
    }

    private function unsetSession()
    {
        session_unset();
    }

}