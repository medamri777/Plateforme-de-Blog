<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Check if category ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    redirect('index.php');
}

$category_id = $_GET['id'];

// Connect to database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get category details
$query = "SELECT * FROM categories WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $category_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if category exists
if (mysqli_num_rows($result) === 0) {
    redirect('index.php');
}

$category = mysqli_fetch_assoc($result);

// Pagination
$posts_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $posts_per_page;

// Get posts by category
$query = "SELECT posts.*, users.username 
          FROM posts 
          INNER JOIN users ON posts.user_id = users.id 
          WHERE posts.category_id = ? 
          ORDER BY posts.created_at DESC 
          LIMIT ?, ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "iii", $category_id, $offset, $posts_per_page);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Get total number of posts in this category
$query = "SELECT COUNT(*) as count FROM posts WHERE category_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $category_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$total_posts = $row['count'];

// Calculate total pages
$total_pages = ceil($total_posts / $posts_per_page);

// Include header
include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h1>Catégorie: <?php echo $category['name']; ?></h1>
            <p class="lead"><?php echo $category['description']; ?></p>
            
            <?php if (count($posts) > 0): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title">
                                <a href="post.php?id=<?php echo $post['id']; ?>" class="text-decoration-none">
                                    <?php echo $post['title']; ?>
                                </a>
                            </h3>
                            <p class="card-text">
                                <?php echo substr($post['content'], 0, 200) . '...'; ?>
                            </p>
                            <div class="text-muted mb-2">
                                Publié par <?php echo $post['username']; ?> le 
                                <?php echo format_date($post['created_at'], 'd/m/Y'); ?>
                            </div>
                            <a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Lire plus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="category.php?id=<?php echo $category_id; ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="category.php?id=<?php echo $category_id; ?>&page=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="category.php?id=<?php echo $category_id; ?>&page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    Aucun article dans cette catégorie pour le moment.
                </div>
            <?php endif; ?>
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