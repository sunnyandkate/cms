<?php

require_once __DIR__ . '/credentials.php';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false, 
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    }catch(\PDOException $e){
        die("Database connection failed.");
}


if ($_SERVER['HTTP_HOST'] === 'localhost') {
   
    define('BASE_URL', 'http://localhost/CMS/'); 
} else {
   
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
}


?>
