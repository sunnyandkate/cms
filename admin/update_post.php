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
$success = '';

$postId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($postId <= 0) {
    header('Location: dashboard.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id LIMIT 1");
$stmt->execute(['id' => $postId]);
$post = $stmt->fetch();

if (!$post) {
    header('Location: dashboard.php');
    exit;
}

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
          
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM posts WHERE slug = :slug AND id != :id");
            $checkStmt->execute(['slug' => $slug, 'id' => $postId]);
            if ($checkStmt->fetchColumn() > 0) {
                $slug .= '-' . time();
            }

            $updateStmt = $pdo->prepare("UPDATE posts SET title = :title, slug = :slug, content = :content, status = :status WHERE id = :id");
            $updateStmt->execute([
                'title'   => $title,
                'slug'    => $slug,
                'content' => $content,
                'status'  => $status,
                'id'      => $postId
            ]);

            header('Location: dashboard.php?msg=updated');
            exit;

        } catch (PDOException $e) {
            $error = 'Database storage modification error: ' . $e->getMessage();
        }
    }
}
?>

<body>

<?php include '../includes/navigation.php'; ?>

<div class="container">
    <div class="update-post-container">

        <h2 class="update-post-title">Edit Post</h2>
             
        <?php if (!empty($error)): ?>
            <div class="error-msg">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="cms-form">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required class="form-input">
                <small class="info-text">Slug path: <span id="slug-preview" class="slug-meta"><?php echo htmlspecialchars($post['slug']); ?></span></small>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="published" <?php echo ($post['status'] === 'published') ? 'selected' : ''; ?>>Published </option>
                    <option value="draft" <?php echo ($post['status'] === 'draft') ? 'selected' : ''; ?>>Draft</option>
                </select>
            </div>

            <div class="form-group form-group-textarea">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="12" required class="form-textarea"><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>

            <button type="submit" class="update-btn">Save</button>
        </form>
    </div>
     <div class="dashboard-footer">
        <a href="dashboard.php" class="back-btn">Back</a>
    </div>
     
</div>



<?php include '../includes/footer.php'; ?>
