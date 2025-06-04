<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$message_sent = false;
$error = false;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $subject = clean_input($_POST['subject'] ?? '');
    $message = clean_input($_POST['message'] ?? '');
    
    // Validate form data
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Veuillez fournir une adresse email valide.";
    } else {
        // In a real application, you would send an email here
        // For now, we'll just simulate success
        $message_sent = true;
    }
}

// Include header
include 'includes/header.php';
?>

<div class="container mt-4">
    <div class="hero-section mb-4">
        <div class="card bg-dark text-white">
            <img src="assets/images/nador-contact.jpg" class="card-img hero-img" alt="Contact Nador">
            <div class="card-img-overlay hero-overlay">
                <div class="hero-content">
                    <h1 class="card-title">Contactez-nous</h1>
                    <p class="card-text">Nous sommes à votre écoute pour toute question ou suggestion concernant Nador.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h2>Formulaire de contact</h2>
                    
                    <?php if ($message_sent): ?>
                        <div class="alert alert-success">
                            <p>Votre message a été envoyé avec succès. Nous vous répondrons dans les meilleurs délais.</p>
                        </div>
                    <?php elseif ($error): ?>
                        <div class="alert alert-danger">
                            <p><?php echo $error; ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="contact.php">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom complet *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet *</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Envoyer le message</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Informations de contact</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="bi bi-geo-alt-fill me-2"></i>Adresse</h6>
                        <p>123 Avenue Mohammed V<br>62000 Nador, Maroc</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="bi bi-telephone-fill me-2"></i>Téléphone</h6>
                        <p>+212 5XX-XXXXX</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="bi bi-envelope-fill me-2"></i>Email</h6>
                        <p>contact@blog-nador.com</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6><i class="bi bi-clock-fill me-2"></i>Horaires</h6>
                        <p>Lundi - Vendredi: 9h00 - 17h00<br>
                        Samedi: 9h00 - 12h00<br>
                        Dimanche: Fermé</p>
                    </div>
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
    
    <div class="card mb-4">
        <div class="card-body">
            <h2>Localisation</h2>
            <div class="ratio ratio-16x9">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d51893.35034090696!2d-2.9576440087073195!3d35.174114584298946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd77a9888f32e83f%3A0xd1846b310b30059!2sNador%2C%20Maroc!5e0!3m2!1sfr!2s!4v1649925945175!5m2!1sfr!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?> 