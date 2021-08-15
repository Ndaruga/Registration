<?php

define('DB_NAME', 'user_db');
define('DB_USER', 'root');
define('DB_PASSWD', '');
define('DB_HOST', 'localhost');

$string = "mysql:host =".DB_HOST.";dbname=".DB_NAME;
if(!$connection = new PDO($string, DB_USER, DB_PASSWD)){
    die("Failed to connect to database");
}

