<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

// Include header
include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="hero-section mb-4">
        <div class="card bg-dark text-white">
            <img src="assets/images/nador-panorama.jpg" class="card-img hero-img" alt="Panorama de Nador">
            <div class="card-img-overlay hero-overlay">
                <div class="hero-content">
                    <h1 class="card-title">À propos de nous</h1>
                    <p class="card-text">Découvrez notre passion pour Nador et notre mission de partager sa beauté avec le monde.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h2>Notre Blog</h2>
                    <p>Bienvenue sur le Blog de Nador, une plateforme dédiée à la promotion de la culture, du tourisme et des traditions de Nador et de sa région. Notre mission est de faire découvrir les richesses de cette belle ville du nord-est du Maroc, située sur la côte méditerranéenne.</p>
                    
                    <p>Créé en 2023 par une équipe de passionnés originaires de Nador, ce blog vise à :</p>
                    <ul>
                        <li>Promouvoir les attractions touristiques de Nador et ses environs</li>
                        <li>Préserver et partager le patrimoine culturel amazigh de la région</li>
                        <li>Mettre en valeur la gastronomie locale</li>
                        <li>Informer sur les événements et festivals locaux</li>
                        <li>Créer une communauté d'amoureux de Nador à travers le monde</li>
                    </ul>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h2>À propos de Nador</h2>
                    <p>Nador (en amazigh: ⵏⴰⴹⵓⵔ, en arabe: الناظور) est une ville portuaire située dans la région de l'Oriental au Maroc. Avec une population d'environ 500 000 habitants, c'est la deuxième plus grande ville de l'est marocain après Oujda.</p>
                    
                    <h3>Géographie</h3>
                    <p>Située sur la lagune de Marchica (Mar Chica), Nador jouit d'une position géographique privilégiée sur la côte méditerranéenne. La ville est entourée par le mont Gourougou et se trouve à proximité de la ville espagnole de Melilla.</p>
                    
                    <h3>Histoire</h3>
                    <p>L'histoire de Nador remonte à plusieurs siècles. La région a été habitée par les Amazighs (Berbères) du Rif et a connu l'influence de diverses civilisations, notamment phénicienne, carthaginoise, romaine et arabe. Pendant la période du Protectorat espagnol (1912-1956), Nador a connu un développement significatif qui a influencé son architecture et sa culture.</p>
                    
                    <h3>Économie</h3>
                    <p>L'économie de Nador repose principalement sur :</p>
                    <ul>
                        <li>Le commerce et le secteur portuaire (port de Beni Ansar)</li>
                        <li>La pêche et les industries liées aux produits de la mer</li>
                        <li>Le tourisme, en plein développement avec le projet Marchica Med</li>
                        <li>L'agriculture dans les plaines environnantes</li>
                        <li>Les transferts d'argent de la diaspora marocaine en Europe</li>
                    </ul>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h2>Notre équipe</h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                                        <span class="fs-4">HM</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mt-0">Hassan Meziani</h5>
                                    <p class="text-muted mb-0">Fondateur & Rédacteur</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-success text-white d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                                        <span class="fs-4">FE</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mt-0">Fatima El Ouariachi</h5>
                                    <p class="text-muted mb-0">Photographe & Designer</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-info text-white d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                                        <span class="fs-4">KA</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mt-0">Karim Amziane</h5>
                                    <p class="text-muted mb-0">Expert en Tourisme</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-warning text-white d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                                        <span class="fs-4">NB</span>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mt-0">Nora Bakkali</h5>
                                    <p class="text-muted mb-0">Spécialiste Culture & Histoire</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Contactez-nous</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Suivez-nous</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-facebook fs-2" style="color: #3b5998;"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-instagram fs-2" style="color: #e1306c;"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-twitter fs-2" style="color: #1da1f2;"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-youtube fs-2" style="color: #ff0000;"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <?php include 'includes/sidebar.php'; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 