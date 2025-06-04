<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if post ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('index.php');
}

$post_id = $_GET['id'];

// Connect to database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get post details
$query = "SELECT posts.*, users.username, categories.name as category_name 
          FROM posts 
          INNER JOIN users ON posts.user_id = users.id 
          INNER JOIN categories ON posts.category_id = categories.id 
          WHERE posts.id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if post exists
if (mysqli_num_rows($result) === 0) {
    redirect('index.php');
}

$post = mysqli_fetch_assoc($result);

// Update view count
$query = "UPDATE posts SET views = views + 1 WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);

// Get comments
$query = "SELECT comments.*, users.username 
          FROM comments 
          INNER JOIN users ON comments.user_id = users.id 
          WHERE comments.post_id = ? 
          ORDER BY comments.created_at DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$comments = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle comment submission
$comment_error = '';
$comment_success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    // Check if user is logged in
    if (!is_logged_in()) {
        $comment_error = 'Vous devez être connecté pour commenter';
    } else {
        $comment = clean_input($_POST['comment']);
        
        // Validate comment
        if (empty($comment)) {
            $comment_error = 'Le commentaire ne peut pas être vide';
        } elseif (strlen($comment) > 500) {
            $comment_error = 'Le commentaire ne peut pas dépasser 500 caractères';
        } else {
            // Insert comment
            $query = "INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "iis", $post_id, $_SESSION['user_id'], $comment);
            
            if (mysqli_stmt_execute($stmt)) {
                $comment_success = 'Commentaire ajouté avec succès';
                
                // Get the new comment
                $comment_id = mysqli_insert_id($conn);
                $query = "SELECT comments.*, users.username 
                          FROM comments 
                          INNER JOIN users ON comments.user_id = users.id 
                          WHERE comments.id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $comment_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $new_comment = mysqli_fetch_assoc($result);
                
                // Add new comment to the beginning of the comments array
                array_unshift($comments, $new_comment);
            } else {
                $comment_error = 'Une erreur s\'est produite lors de l\'ajout du commentaire';
            }
        }
    }
}

// Include header
include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="card-title"><?php echo $post['title']; ?></h1>
                    
                    <div class="post-meta mb-3">
                        <span class="me-3">
                            <i class="bi bi-person"></i> <?php echo $post['username']; ?>
                        </span>
                        <span class="me-3">
                            <i class="bi bi-calendar"></i> <?php echo format_date($post['created_at'], 'd/m/Y'); ?>
                        </span>
                        <span class="me-3">
                            <i class="bi bi-tag"></i> 
                            <a href="category.php?id=<?php echo $post['category_id']; ?>" class="text-decoration-none">
                                <?php echo $post['category_name']; ?>
                            </a>
                        </span>
                        <span>
                            <i class="bi bi-eye"></i> <?php echo $post['views']; ?> vues
                        </span>
                    </div>
                    
                    <div class="post-content">
                        <?php echo nl2br($post['content']); ?>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Commentaires (<?php echo count($comments); ?>)</h4>
                </div>
                <div class="card-body">
                    <?php if ($comment_error): ?>
                        <div class="alert alert-danger"><?php echo $comment_error; ?></div>
                    <?php endif; ?>
                    
                    <?php if ($comment_success): ?>
                        <div class="alert alert-success"><?php echo $comment_success; ?></div>
                    <?php endif; ?>
                    
                    <?php if (is_logged_in()): ?>
                        <form action="post.php?id=<?php echo $post_id; ?>" method="POST" id="comment-form">
                            <div class="mb-3">
                                <label for="comment" class="form-label">Ajouter un commentaire</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Commenter</button>
                        </form>
                        <hr>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <a href="login.php">Connectez-vous</a> pour ajouter un commentaire.
                        </div>
                    <?php endif; ?>
                    
                    <div id="comments-container">
                        <?php if (count($comments) > 0): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment">
                                    <div class="comment-author"><?php echo $comment['username']; ?></div>
                                    <div class="comment-date"><?php echo format_date($comment['created_at'], 'd/m/Y H:i'); ?></div>
                                    <div class="comment-content"><?php echo nl2br($comment['content']); ?></div>
                                </div>
                                <hr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucun commentaire pour le moment. Soyez le premier à commenter!</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <?php include 'includes/sidebar.php'; ?>
        </div>
    </div>
</div>

<?php 
// Close connection
mysqli_close($conn);

include 'includes/footer.php'; 
?> 