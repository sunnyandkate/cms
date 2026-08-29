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

// ... keep your existing PDO connection code exactly the same ...

// 🚀 AUTODETECT THE ROOT PATH TRAILING STRING
if ($_SERVER['HTTP_HOST'] === 'localhost') {
    // Localhost: Adjust 'my-blog-project' to match your exact XAMPP/MAMP folder name!
    define('BASE_URL', 'http://localhost/CMS/'); 
} else {
    // Live Server: Automatically matches your Byethost domain url structure
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
}


?>