<?php
define('DB_HOST', 'db:3306');
define('DB_USER', 'root');
define('DB_PASSWORD', 'toor');
define('DB_NAME', 'Db');
//Should be somewhere in separate file

class Connection
{
    static private $instance = NULL;

    static function getPdoInstance(): PDO
    {
        if (self::$instance == NULL) {
            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . "", DB_USER, DB_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance = $conn;
        }
        return self::$instance;
    } //Singleton
}