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

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $status  = $_POST['status'] ?? 'draft';

    if (empty($title) || empty($content)) {
        $error = 'Please fill out the fields.';
    } else {
        if ($_SESSION['admin_user'] === 'code_reviewer') {
            header('Location: dashboard.php?msg=demo_mode');
            exit;
        }
        
        $slug = strtolower($title);
        $slug = preg_replace('/[\s_]+/', '-', $slug);
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
        $slug = trim($slug, '-');

        try {
            
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE slug = :slug");
            $checkStmt->execute(['slug' => $slug]);
            if ($checkStmt->fetchColumn() > 0) {
                $slug .= '-' . time();
            }

            $stmt = $pdo->prepare("INSERT INTO posts (title, slug, content, status) VALUES (:title, :slug, :content, :status)");
            $stmt->execute([
                'title'   => $title,
                'slug'    => $slug,
                'content' => $content,
                'status'  => $status
            ]);

            header('Location: dashboard.php?msg=created');
            exit;

        } catch (PDOException $e) {
            $error = 'Database storage error: ' . $e->getMessage();
        }
    }
}
?>

<body>

<?php include '../includes/navigation.php';  ?>

<div class="container">
    <div class="create-post-container">

        <h2 class="create-post-title">Write a new post</h2>
            <?php if (!empty($error)): ?>
            <div class="error-msg">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="cms-form">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required class="form-input">
                <small class="form-help">Slug path: <span id="slug-preview">...</span></small>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="12" required class="form-textarea"></textarea>
            </div>

            <button type="submit" class="submit-btn">Save</button>
        </form>
    </div>
    <div class="dashboard-footer">
            <a href="dashboard.php" class="back-btn">Back</a>
        </div>
    </div>



<?php include '../includes/footer.php'; ?>
