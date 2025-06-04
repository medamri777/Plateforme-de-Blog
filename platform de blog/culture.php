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

// Get culture category ID
$query = "SELECT id FROM categories WHERE slug = 'culture'";
$result = mysqli_query($conn, $query);
$category = mysqli_fetch_assoc($result);
$category_id = $category['id'];

// Get culture posts
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
            <img src="assets/images/nador-culture.jpg" class="card-img hero-img" alt="Culture à Nador">
            <div class="card-img-overlay hero-overlay">
                <div class="hero-content">
                    <h1 class="card-title">Culture et Traditions de Nador</h1>
                    <p class="card-text">Découvrez la riche culture amazighe et marocaine de la région de Nador.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="mb-5">
                <h2>Patrimoine culturel de Nador</h2>
                <p class="lead">Nador et sa région possèdent un riche héritage culturel influencé par les cultures amazighe, arabe, méditerranéenne et africaine.</p>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h3>La culture amazighe (berbère)</h3>
                        <p>Nador se situe dans la région du Rif, au cœur du territoire amazigh. La population locale parle principalement le rifain, un dialecte de la langue amazighe. Cette identité culturelle se manifeste à travers l'art, la musique, les vêtements traditionnels et les célébrations locales.</p>
                        <p>Les motifs géométriques distinctifs se retrouvent dans l'artisanat local, les tapis, les poteries et les bijoux en argent. La musique rifaine, avec ses rythmes uniques et ses instruments traditionnels comme le bendir (tambour) et la flûte, fait partie intégrante du patrimoine culturel.</p>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h3>Artisanat local</h3>
                        <p>L'artisanat de Nador inclut:</p>
                        <ul>
                            <li><strong>Poterie rifaine</strong> - Caractérisée par ses motifs géométriques et ses couleurs vives</li>
                            <li><strong>Tapis traditionnels</strong> - Tissés à la main avec des motifs symboliques</li>
                            <li><strong>Bijouterie en argent</strong> - Ornée de corail, d'ambre et de pierres semi-précieuses</li>
                            <li><strong>Vannerie</strong> - Création de paniers et objets décoratifs en fibres naturelles</li>
                        </ul>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-body">
                        <h3>Festivals et célébrations</h3>
                        <p>Tout au long de l'année, Nador accueille divers festivals et célébrations:</p>
                        <ul>
                            <li><strong>Festival International de Nador</strong> - Un événement culturel majeur mettant en valeur la musique, l'art et la danse</li>
                            <li><strong>Moussems</strong> - Festivals religieux en l'honneur de saints locaux</li>
                            <li><strong>Yennayer</strong> - Le Nouvel An amazigh, célébré en janvier</li>
                            <li><strong>Célébrations des mariages traditionnels</strong> - Avec leurs rituels, musiques et costumes uniques</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <h2>Articles sur la culture</h2>
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
                <div class="alert alert-info">Aucun article sur la culture disponible pour le moment.</div>
            <?php endif; ?>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Langue et traditions</h5>
                </div>
                <div class="card-body">
                    <h6>Langues parlées à Nador</h6>
                    <ul>
                        <li>Rifain (dialecte amazigh)</li>
                        <li>Arabe marocain (darija)</li>
                        <li>Arabe standard</li>
                        <li>Français (langue seconde)</li>
                        <li>Espagnol (influence de la proximité avec Melilla)</li>
                    </ul>
                    
                    <h6>Costume traditionnel</h6>
                    <p>Les femmes portent souvent le "mendil" (foulard) et la "dfina" (robe brodée) lors des occasions spéciales, tandis que les hommes peuvent porter la jellaba et le "tarbouche" (chapeau traditionnel).</p>
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