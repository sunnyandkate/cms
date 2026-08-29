<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once 'config/db.php';
    include 'includes/header.php'; 

    //fetch all published blog posts
    $stmt = $pdo->query("SELECT * FROM posts WHERE status = 'published' ORDER BY created_at DESC");
    $posts = $stmt->fetchAll();
    
?>

<body>

<?php include 'includes/navigation.php'; ?>
    <div class="container">       
        <h1 class="heading">Welcome to my Blog</h1>
        <div class="posts-container">
            <?php if (empty($posts)): ?>
                <p>No blog posts found</p>
            <?php else : ?>
                <?php foreach ($posts as $post): ?>
                    <article class="post-card">
                        <h2 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                        <small class="post-date-meta"><?php echo date('M d, Y', strtotime($post['created_at'])); ?></small>
                        <p class="post-content"><?php echo substr(strip_tags($post['content']), 0, 150); ?>...</p>
                        <a href="post.php?slug=<?php echo $post['slug']; ?>" class="read-more">Read more ...</a>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>    
    </div>


<?php include 'includes/footer.php'; ?>
