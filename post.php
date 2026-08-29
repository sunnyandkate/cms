<?php

require_once 'config/db.php';
include 'includes/header.php';

$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    echo "<h1>Post not found</h1><p>No article was selected.</p>";
    include 'includes/footer.php';
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE slug = :slug AND status = 'published' LIMIT 1");
$stmt->execute(['slug' => $slug]);
$post = $stmt->fetch(); 
?>

<body>

<?php include 'includes/navigation.php'; ?>
<div class= "single-post">
    <?php if (!$post): ?>
        <h1>Post not found</h1>
        <a href= "index.php" class="back-btn">Back</a>
    <?php else: ?>
        <h1 class="single-post-title"><?php echo htmlspecialchars($post['title']); ?></h1>
        <div class="post-date-meta">
            <small><?php echo date('F d, Y', strtotime($post['created_at'])); ?></small>
        </div>
        <div class= "post-content">
            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
        </div>
        <a href= "index.php" class="back-btn">Back</a>
        <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>