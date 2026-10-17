<?php

require_once __DIR__ . '/local-credentials.php';

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

if ($_SERVER['HTTPS_HOST'] === 'localhost') { 
    define('BASE_URL', 'https://localhost/CMS/'); 
} else {   
    define('BASE_URL', 'https://' . $_SERVER['HTTPS_HOST'] . '/');
}

?>