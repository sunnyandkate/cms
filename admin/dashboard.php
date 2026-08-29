<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/db.php';
include '../includes/header.php';


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$allPosts = $stmt->fetchAll();
?>

<body>

    <?php include '../includes/navigation.php'; ?>

<div class="container">
        
    <h1 class="dashboard-title">Admin Dashboard</h1>
    <div class="dashboard-container">
        <a href="create_post.php" class="create-btn">+ Write a new post</a>
    
        <!-- User feedback system states -->
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
            <p class="delete-message">post successfully deleted from database</p>
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'created'): ?>
            <p class="create-message">new post successfully created</p>  
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
            <p class="update-message">post successfully updated</p> 
        <?php elseif (isset($_GET['msg']) && $_GET['msg'] === 'demo_mode'): ?> 
            <p class="demo-mode-message"><strong>Demo Mode:</strong> Your input was successful, but changes are restricted to keep this sandbox clean!</p>
        <?php endif; ?>

        <h3 class="dashboard-table-title">Manage Posts</h3>        
        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($allPosts)): ?>
                    <tr>
                        <td colspan="4">No posts found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($allPosts as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td>
                                <span class="status-<?php echo htmlspecialchars($row['status']); ?>">
                                    <?php echo ucfirst($row['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="update_post.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                                <a href="delete_post.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to permanently delete this post?');" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="dashboard-footer">
        <a href="../index.php" class="back-btn">Back</a>
    </div>
</div>



<?php include '../includes/footer.php'; ?>
