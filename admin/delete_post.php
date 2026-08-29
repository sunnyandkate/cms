<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {

    // Prevent the guest admin from deleting posts
    if ($_SESSION['admin_user'] === 'code_reviewer') {
        header('Location: dashboard.php?msg=demo_mode');
        exit;
    }

    $deleteId = (int)$_GET['id'];
    
    $deleteStmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
    $deleteStmt->execute(['id' => $deleteId]);
    
    header('Location: dashboard.php?msg=deleted');
    exit;
}else{
    header('Location: dashboard.php');
    exit;
}

?>