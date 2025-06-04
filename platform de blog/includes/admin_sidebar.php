<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Tableau de bord
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) === 'posts.php' || basename($_SERVER['PHP_SELF']) === 'add_post.php' || basename($_SERVER['PHP_SELF']) === 'edit_post.php' ? 'active' : ''; ?>" href="posts.php">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Articles
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) === 'categories.php' || basename($_SERVER['PHP_SELF']) === 'add_category.php' || basename($_SERVER['PHP_SELF']) === 'edit_category.php' ? 'active' : ''; ?>" href="categories.php">
                    <i class="bi bi-tag me-2"></i>
                    Catégories
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) === 'comments.php' ? 'active' : ''; ?>" href="comments.php">
                    <i class="bi bi-chat-left-text me-2"></i>
                    Commentaires
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) === 'users.php' || basename($_SERVER['PHP_SELF']) === 'add_user.php' || basename($_SERVER['PHP_SELF']) === 'edit_user.php' ? 'active' : ''; ?>" href="users.php">
                    <i class="bi bi-people me-2"></i>
                    Utilisateurs
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'active' : ''; ?>" href="profile.php">
                    <i class="bi bi-person me-2"></i>
                    Profil
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="../logout.php">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Déconnexion
                </a>
            </li>
        </ul>
    </div>
</nav> 