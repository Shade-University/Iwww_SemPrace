<?php

session_start();
unset($_SESSION['email']);
unset($_SESSION['fullname']);
unset($_SESSION['role']);

$params = session_get_cookie_params();
unset($_COOKIE['remember']);
setcookie("remember", "", time()-3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

header('Location: ../index.php');