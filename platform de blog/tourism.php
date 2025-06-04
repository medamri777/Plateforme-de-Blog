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

// Get tourism category ID
$query = "SELECT id FROM categories WHERE slug = 'tourisme'";
$result = mysqli_query($conn, $query);
$category = mysqli_fetch_assoc($result);
$category_id = $category['id'];

// Get tourism posts
$query = "SELECT posts.*, users.username 
          FROM posts 
          INNER JOIN users ON posts.user_id = users.id 
          WHERE posts.category_id = ? 
          ORDER BY posts.created_at DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $category_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Include header
include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="hero-section mb-4">
        <div class="card bg-dark text-white">
            <img src="assets/images/nador-tourism.jpg" class="card-img hero-img" alt="Tourisme à Nador">
            <div class="card-img-overlay hero-overlay">
                <div class="hero-content">
                    <h1 class="card-title">Tourisme à Nador</h1>
                    <p class="card-text">Découvrez les trésors cachés et les attractions touristiques de Nador et ses environs.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="mb-4">
                <h2>Destinations incontournables à Nador</h2>
                <p class="lead">La ville de Nador et sa région offrent de nombreux sites touristiques à explorer:</p>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">La Lagune de Marchica</h5>
                                <p class="card-text">Une immense lagune d'eau salée offrant des paysages à couper le souffle et des activités nautiques.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Les plages d'Arekmane</h5>
                                <p class="card-text">Des plages de sable fin avec des eaux cristallines, idéales pour la baignade et la détente.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Mont Gourougou</h5>
                                <p class="card-text">Une montagne offrant une vue panoramique sur Nador, Melilla et la mer Méditerranée.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Îles Chafarinas</h5>
                                <p class="card-text">Un archipel de trois petites îles avec une riche biodiversité marine et terrestre.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <h2>Articles sur le tourisme</h2>
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
                <div class="alert alert-info">Aucun article sur le tourisme disponible pour le moment.</div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Informations pratiques</h5>
                </div>
                <div class="card-body">
                    <h6>Meilleure période pour visiter</h6>
                    <p>Les mois de mai à octobre offrent un climat idéal pour visiter Nador.</p>
                    
                    <h6>Comment s'y rendre</h6>
                    <ul>
                        <li>En avion: Aéroport International d'Aroui (NDR)</li>
                        <li>En bus: Connexions depuis les principales villes du Maroc</li>
                        <li>En voiture: Via la route nationale N16</li>
                    </ul>
                    
                    <h6>Hébergement</h6>
                    <p>Nador dispose d'hôtels, de riads et d'appartements de location pour tous les budgets.</p>
                </div>
            </div>
            
            <?php include 'includes/sidebar.php'; ?>
        </div>
    </div>
</div>

<?php 
// Close connection
mysqli_close($conn);

include 'includes/footer.php'; 
?> 