<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/db.php';
include dirname(__DIR__) . '/includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please fill in all fields.';
    } else {
        
         if ($username === 'code_reviewer' && $password === 'sandbox_mode'){
            
             $_SESSION['admin_logged_in'] = true;
             $_SESSION['admin_user'] = 'code_reviewer';

            header('Location: dashboard.php');
            exit;
        }
        
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
             
        if ($user && password_verify($password, $user['password_hash'])) {

            if ((int)$user['is_approved'] !== 1) {
                $error = 'Your account is pending administrator approval.';
            } else {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user'] = $user['username'];
                header('Location: dashboard.php');
                exit;
            }
	 
        	}else {
            	$error = 'Invalid username or password.';            
        }
        
    }
}
?>

<body>

<?php include '../includes/navigation.php'; ?>

<div class="login-container">
    <h2 class="login-title">Admin Login</h2>
    
    <!-- RECRUITER NOTICE BOX -->
    <div class="recruiter-notice">
        <strong>Recruiter Review Mode:</strong>
        <p>
            The form fields below have been automatically pre-filled with guest admin credentials. 
            Just click <strong>"Log In"</strong> to access and test the live CRUD backend dashboard features.
        </p>
    </div>
    
    <?php if (!empty($error)): ?>
        <div class="error-msg">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form action="" method="POST" class="login-form">
        <div class="form-group">
            <label for="username">Username</label>
            <!--pre filled field:  'admin' -->
            <input type="text" id="username" name="username" value="code_reviewer" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <!-- pre filled field: guest password -->
            <input type="password" id="password" name="password" value="sandbox_mode" required>
        </div>

        <button type="submit" class="login-btn">Log In</button>
    </form>
</div>



<?php 
include '../includes/footer.php'; 
?>
