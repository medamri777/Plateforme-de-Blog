<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Connect to database
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get latest posts
$query = "SELECT posts.*, users.username FROM posts 
          INNER JOIN users ON posts.user_id = users.id 
          ORDER BY created_at DESC 
          LIMIT 5";
$result = mysqli_query($conn, $query);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Include header
include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="hero-section mb-4">
        <div class="card bg-dark text-white">
            <img src="assets/images/nador-view.jpg" class="card-img hero-img" alt="Vue de Nador">
            <div class="card-img-overlay hero-overlay">
                <div class="hero-content">
                    <h1 class="card-title">Bienvenue sur notre Blog de Nador</h1>
                    <p class="card-text">Découvrez les merveilles de Nador et du Maroc à travers nos articles et expériences.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <h2>Articles Récents</h2>
            
            <?php if (count($posts) > 0): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title"><?php echo $post['title']; ?></h3>
                            <p class="card-text">
                                <?php echo substr($post['content'], 0, 200) . '...'; ?>
                            </p>
                            <div class="text-muted mb-2">
                                Publié par <?php echo $post['username']; ?> le 
                                <?php echo date('d/m/Y', strtotime($post['created_at'])); ?>
                            </div>
                            <a href="post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Lire plus</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun article disponible pour le moment.</p>
            <?php endif; ?>
        </div>
        
        <div class="col-md-4">
            <?php include 'includes/sidebar.php'; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 