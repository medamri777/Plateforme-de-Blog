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

// Get gastronomie category ID
$query = "SELECT id FROM categories WHERE slug = 'gastronomie'";
$result = mysqli_query($conn, $query);
$category = mysqli_fetch_assoc($result);
$category_id = $category['id'];

// Get gastronomie posts
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
            <img src="assets/images/nador-gastronomy.jpg" class="card-img hero-img" alt="Gastronomie de Nador">
            <div class="card-img-overlay hero-overlay">
                <div class="hero-content">
                    <h1 class="card-title">La Gastronomie de Nador</h1>
                    <p class="card-text">Découvrez les saveurs uniques et les plats traditionnels de la cuisine rifaine et marocaine.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="mb-5">
                <h2>Les spécialités culinaires de Nador</h2>
                <p class="lead">La cuisine de Nador est un délicieux mélange d'influences amazighes, arabes et méditerranéennes. Voici quelques plats emblématiques de la région:</p>
                
                <div class="card mb-4">
                    <div class="row g-0">
                        <div class="col-md-4 bg-light d-flex align-items-center justify-content-center">
                            <div class="p-3 text-center">
                                <i class="bi bi-cup-hot fs-1 text-primary"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title">Tajine de poisson</h3>
                                <p class="card-text">Le tajine de poisson est une spécialité de Nador qui reflète parfaitement sa position côtière. Préparé avec du poisson frais local, des légumes, des épices, des olives et des citrons confits, ce plat est cuit lentement dans un tajine traditionnel en terre cuite.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="row g-0">
                        <div class="col-md-4 bg-light d-flex align-items-center justify-content-center">
                            <div class="p-3 text-center">
                                <i class="bi bi-egg-fried fs-1 text-primary"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title">Pastilla aux fruits de mer</h3>
                                <p class="card-text">La pastilla, habituellement connue avec du pigeon ou du poulet, se décline à Nador en version fruits de mer. Cette tourte feuilletée est garnie de fruits de mer, de vermicelles, d'amandes et parfumée à la cannelle et au sucre glace, créant un mélange sucré-salé exquis.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="row g-0">
                        <div class="col-md-4 bg-light d-flex align-items-center justify-content-center">
                            <div class="p-3 text-center">
                                <i class="bi bi-fire fs-1 text-primary"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title">Rfissa rifaine</h3>
                                <p class="card-text">La Rfissa rifaine est une variante locale d'un plat marocain classique. Elle se compose de msemen (crêpes feuilletées) déchirées, nappées d'un bouillon parfumé aux lentilles, au poulet et à un mélange d'épices comprenant fenugrec, ras el hanout et safran.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="row g-0">
                        <div class="col-md-4 bg-light d-flex align-items-center justify-content-center">
                            <div class="p-3 text-center">
                                <i class="bi bi-cup fs-1 text-primary"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h3 class="card-title">Thé à la menthe rifain</h3>
                                <p class="card-text">Le thé à la menthe est une institution au Maroc, et la version rifaine a ses particularités. Préparé avec du thé vert, de la menthe fraîche et parfois de l'absinthe, il est servi très sucré et accompagne tous les moments de convivialité.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <h2>Recettes et articles culinaires</h2>
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
                <div class="alert alert-info">Aucun article sur la gastronomie disponible pour le moment.</div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Les marchés alimentaires</h5>
                </div>
                <div class="card-body">
                    <p>Pour découvrir les saveurs locales, visitez ces marchés:</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Souk El Had</strong> - Le grand marché central de Nador
                        </li>
                        <li class="list-group-item">
                            <strong>Marché aux poissons</strong> - Pour des produits de la mer ultra-frais
                        </li>
                        <li class="list-group-item">
                            <strong>Souk Beni Ensar</strong> - Marché populaire près du port
                        </li>
                        <li class="list-group-item">
                            <strong>Marché Selouane</strong> - Connu pour ses fruits et légumes locaux
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Épices essentielles</h5>
                </div>
                <div class="card-body">
                    <p>Les épices qui caractérisent la cuisine de Nador:</p>
                    <div class="d-flex flex-wrap">
                        <span class="badge bg-primary m-1 p-2">Cumin</span>
                        <span class="badge bg-primary m-1 p-2">Safran</span>
                        <span class="badge bg-primary m-1 p-2">Paprika</span>
                        <span class="badge bg-primary m-1 p-2">Cannelle</span>
                        <span class="badge bg-primary m-1 p-2">Ras el hanout</span>
                        <span class="badge bg-primary m-1 p-2">Gingembre</span>
                        <span class="badge bg-primary m-1 p-2">Curcuma</span>
                        <span class="badge bg-primary m-1 p-2">Coriandre</span>
                        <span class="badge bg-primary m-1 p-2">Fenugrec</span>
                    </div>
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