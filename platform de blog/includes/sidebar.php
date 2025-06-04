<?php
// Get categories
$query = "SELECT * FROM categories ORDER BY name";
$result = mysqli_query($conn, $query);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Get recent posts
$query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 3";
$result = mysqli_query($conn, $query);
$recent_posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="card mb-4">
    <div class="card-header">
        <h5><i class="bi bi-search me-2"></i>Recherche</h5>
    </div>
    <div class="card-body">
        <form action="search.php" method="GET">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Rechercher...">
                <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5><i class="bi bi-tags me-2"></i>Catégories</h5>
    </div>
    <div class="card-body">
        <?php
        $cat_query = "SELECT id, name, slug FROM categories ORDER BY name";
        $cat_result = mysqli_query($conn, $cat_query);
        $categories = mysqli_fetch_all($cat_result, MYSQLI_ASSOC);
        ?>
        <ul class="list-group list-group-flush">
            <?php foreach ($categories as $category): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="categories.php?slug=<?php echo $category['slug']; ?>" class="text-decoration-none">
                        <?php echo $category['name']; ?>
                    </a>
                    <?php
                    $count_query = "SELECT COUNT(*) as count FROM posts WHERE category_id = " . $category['id'];
                    $count_result = mysqli_query($conn, $count_query);
                    $count = mysqli_fetch_assoc($count_result)['count'];
                    ?>
                    <span class="badge bg-primary rounded-pill"><?php echo $count; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5><i class="bi bi-star me-2"></i>Articles populaires</h5>
    </div>
    <div class="card-body">
        <?php
        $popular_query = "SELECT id, title, views FROM posts ORDER BY views DESC LIMIT 5";
        $popular_result = mysqli_query($conn, $popular_query);
        $popular_posts = mysqli_fetch_all($popular_result, MYSQLI_ASSOC);
        ?>
        <ul class="list-group list-group-flush">
            <?php foreach ($popular_posts as $post): ?>
                <li class="list-group-item">
                    <a href="post.php?id=<?php echo $post['id']; ?>" class="text-decoration-none">
                        <?php echo $post['title']; ?>
                    </a>
                    <div class="small text-muted">
                        <i class="bi bi-eye me-1"></i><?php echo $post['views']; ?> vues
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5><i class="bi bi-info-circle me-2"></i>À propos de Nador</h5>
    </div>
    <div class="card-body">
        <p>Nador est une ville côtière située au nord-est du Maroc, sur la côte méditerranéenne. Elle est connue pour ses belles plages, sa lagune unique et sa culture berbère rifaine.</p>
        <a href="about.php" class="btn btn-sm btn-outline-primary">En savoir plus</a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5><i class="bi bi-clock-history me-2"></i>Météo à Nador</h5>
    </div>
    <div class="card-body text-center">
        <div class="weather-widget">
            <i class="bi bi-sun fs-1 text-warning mb-2"></i>
            <h4>25°C</h4>
            <p class="mb-0">Ensoleillé</p>
            <small class="text-muted">Dernière mise à jour: aujourd'hui</small>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5><i class="bi bi-calendar-event me-2"></i>Événements à venir</h5>
    </div>
    <div class="card-body">
        <div class="event-item mb-3">
            <div class="event-date bg-primary text-white p-2 text-center rounded mb-2">
                <div class="event-month small">JUL</div>
                <div class="event-day fw-bold">15</div>
            </div>
            <h6>Festival de la Lagune de Marchica</h6>
            <p class="small text-muted mb-0">Célébration de la culture locale avec musique et arts</p>
        </div>
        <div class="event-item mb-3">
            <div class="event-date bg-primary text-white p-2 text-center rounded mb-2">
                <div class="event-month small">AOU</div>
                <div class="event-day fw-bold">05</div>
            </div>
            <h6>Fête des Plages de Nador</h6>
            <p class="small text-muted mb-0">Activités sportives et ludiques sur les plages de la région</p>
        </div>
        <div class="event-item">
            <div class="event-date bg-primary text-white p-2 text-center rounded mb-2">
                <div class="event-month small">SEP</div>
                <div class="event-day fw-bold">20</div>
            </div>
            <h6>Salon de l'Artisanat Rifain</h6>
            <p class="small text-muted mb-0">Exposition et vente d'artisanat local traditionnel</p>
        </div>
    </div>
</div> 