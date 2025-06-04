<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Get search query
$search_query = isset($_GET['q']) ? clean_input($_GET['q']) : '';

// Connect to database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$posts = [];
$total_posts = 0;
$total_pages = 0;

if (!empty($search_query)) {
    // Pagination
    $posts_per_page = 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $posts_per_page;
    
    // Search for posts
    $search_term = '%' . $search_query . '%';
    
    $query = "SELECT posts.*, users.username, categories.name as category_name 
              FROM posts 
              INNER JOIN users ON posts.user_id = users.id 
              INNER JOIN categories ON posts.category_id = categories.id 
              WHERE posts.title LIKE ? OR posts.content LIKE ? 
              ORDER BY posts.created_at DESC 
              LIMIT ?, ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssii", $search_term, $search_term, $offset, $posts_per_page);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    // Get total number of posts matching search
    $query = "SELECT COUNT(*) as count FROM posts WHERE title LIKE ? OR content LIKE ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $search_term, $search_term);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $total_posts = $row['count'];
    
    // Calculate total pages
    $total_pages = ceil($total_posts / $posts_per_page);
}

// Include header
include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h1>Résultats de recherche</h1>
            
            <form action="search.php" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Rechercher..." value="<?php echo $search_query; ?>" required>
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Rechercher
                    </button>
                </div>
            </form>
            
            <?php if (!empty($search_query)): ?>
                <p>
                    <?php echo $total_posts; ?> résultat<?php echo $total_posts != 1 ? 's' : ''; ?> pour "<?php echo $search_query; ?>"
                </p>
                
                <?php if (count($posts) > 0): ?>
                    <?php foreach ($posts as $post): ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3 class="card-title">
                                    <a href="post.php?id=<?php echo $post['id']; ?>" class="text-decoration-none">
                                        <?php echo $post['title']; ?>
                                    </a>
                                </h3>
                                <div class="text-muted mb-2">
                                    <span class="me-3">
                                        <i class="bi bi-person"></i> <?php echo $post['username']; ?>
                                    </span>
                                    <span class="me-3">
                                        <i class="bi bi-calendar"></i> <?php echo format_date($post['created_at'], 'd/m/Y'); ?>
                                    </span>
                                    <span>
                                        <i class="bi bi-tag"></i> 
                                        <a href="category.php?id=<?php echo $post['category_id']; ?>" class="text-decoration-none">
                                            <?php echo $post['category_name']; ?>
                                        </a>
                                    </span>
                                </div>
                                <p class="card-text">
                                    <?php echo substr($post['content'], 0, 200) . '...'; ?>
                                </p>
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
                                        <a class="page-link" href="search.php?q=<?php echo urlencode($search_query); ?>&page=<?php echo $page - 1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="search.php?q=<?php echo urlencode($search_query); ?>&page=<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="search.php?q=<?php echo urlencode($search_query); ?>&page=<?php echo $page + 1; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        Aucun résultat trouvé pour "<?php echo $search_query; ?>".
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    Veuillez entrer un terme de recherche.
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