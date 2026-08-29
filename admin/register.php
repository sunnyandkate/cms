<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once '../config/db.php';
include '../includes/header.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_user = trim($_POST['new_username'] ?? '');
    $new_pass = $_POST['new_password'] ?? '';

    if (empty($new_user) || empty($new_pass)) {
        $error = 'All fields are required.';
    } else {
        try {
            $check_stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
            $check_stmt->execute(['username' => $new_user]);
            
            if ($check_stmt->fetch()) {
                $error = 'That username is already taken.';
            } else {
                $native_hash = password_hash($new_pass, PASSWORD_BCRYPT);

                $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)");
                $stmt->execute([
                    'username'      => $new_user,
                    'password_hash' => $native_hash
                ]);

                $message = "User '<strong>" . htmlspecialchars($new_user) . "</strong>' successfully registered!";
            }
        } catch (\Exception $e) {
            $error = 'Registration failed: ' . $e->getMessage();
        }
    }
}
?>

<body>
<?php include '../includes/navigation.php'; ?>

<div class="signup-container">
    <h2>Sign Up</h2>
    
    <?php if (!empty($error)): ?>
        <div class="fields-empty"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($message)): ?>
        <div class="signup-msg"><?php echo $message; ?></div>
    <?php endif; ?>

    <form action="./register.php" method="POST">
        <div class="signup-username">
            <label for="new_username">Username</label>
            <input type="text" id="new_username" name="new_username" required>
        </div>
        <div class="signup-password">
            <label for="new_password">Password</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <button class="submit-btn" type="submit">Sign Up</button>
    </form>
    
    <p class="signup-back-btn"><a href="../index.php">Back</a></p>
</div>

<?php include '../includes/footer.php'; ?>
