<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Check if user is logged in and is admin
if (!is_logged_in() || !is_admin()) {
    redirect('../index.php');
}

// Connect to database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get counts for dashboard
$query = "SELECT COUNT(*) as post_count FROM posts";
$result = mysqli_query($conn, $query);
$post_count = mysqli_fetch_assoc($result)['post_count'];

$query = "SELECT COUNT(*) as user_count FROM users";
$result = mysqli_query($conn, $query);
$user_count = mysqli_fetch_assoc($result)['user_count'];

$query = "SELECT COUNT(*) as comment_count FROM comments";
$result = mysqli_query($conn, $query);
$comment_count = mysqli_fetch_assoc($result)['comment_count'];

$query = "SELECT COUNT(*) as category_count FROM categories";
$result = mysqli_query($conn, $query);
$category_count = mysqli_fetch_assoc($result)['category_count'];

// Get recent posts
$query = "SELECT posts.*, users.username 
          FROM posts 
          INNER JOIN users ON posts.user_id = users.id 
          ORDER BY posts.created_at DESC 
          LIMIT 5";
$result = mysqli_query($conn, $query);
$recent_posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Get recent comments
$query = "SELECT comments.*, users.username, posts.title as post_title 
          FROM comments 
          INNER JOIN users ON comments.user_id = users.id 
          INNER JOIN posts ON comments.post_id = posts.id 
          ORDER BY comments.created_at DESC 
          LIMIT 5";
$result = mysqli_query($conn, $query);
$recent_comments = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Include header
include '../includes/admin_header.php';
?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include '../includes/admin_sidebar.php'; ?>
        
        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tableau de bord</h1>
            </div>
            
            <!-- Stats -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Articles</h5>
                            <p class="card-text display-4"><?php echo $post_count; ?></p>
                            <a href="posts.php" class="text-white">Gérer les articles <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Utilisateurs</h5>
                            <p class="card-text display-4"><?php echo $user_count; ?></p>
                            <a href="users.php" class="text-white">Gérer les utilisateurs <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <h5 class="card-title">Commentaires</h5>
                            <p class="card-text display-4"><?php echo $comment_count; ?></p>
                            <a href="comments.php" class="text-white">Gérer les commentaires <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Catégories</h5>
                            <p class="card-text display-4"><?php echo $category_count; ?></p>
                            <a href="categories.php" class="text-white">Gérer les catégories <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Posts -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Articles récents</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_posts as $post): ?>
                                    <tr>
                                        <td><?php echo $post['title']; ?></td>
                                        <td><?php echo $post['username']; ?></td>
                                        <td><?php echo format_date($post['created_at'], 'd/m/Y'); ?></td>
                                        <td>
                                            <?php if ($post['status'] === 'published'): ?>
                                                <span class="badge bg-success">Publié</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Brouillon</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                            <a href="../post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-info" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="posts.php" class="btn btn-primary">Voir tous les articles</a>
                </div>
            </div>
            
            <!-- Recent Comments -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Commentaires récents</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Auteur</th>
                                    <th>Commentaire</th>
                                    <th>Article</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_comments as $comment): ?>
                                    <tr>
                                        <td><?php echo $comment['username']; ?></td>
                                        <td><?php echo substr($comment['content'], 0, 50) . (strlen($comment['content']) > 50 ? '...' : ''); ?></td>
                                        <td><?php echo $comment['post_title']; ?></td>
                                        <td><?php echo format_date($comment['created_at'], 'd/m/Y'); ?></td>
                                        <td>
                                            <a href="delete_comment.php?id=<?php echo $comment['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                            <a href="../post.php?id=<?php echo $comment['post_id']; ?>" class="btn btn-sm btn-info" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="comments.php" class="btn btn-primary">Voir tous les commentaires</a>
                </div>
            </div>
        </main>
    </div>
</div>

<?php 
// Close connection
mysqli_close($conn);

include '../includes/admin_footer.php'; 
?> 