<?php
define('DB_SERVER', 'db:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'toor');
define('DB_DATABASE', 'Db');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>