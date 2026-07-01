<?php /* Shared branded top bar for inner pages — matches the home navbar brand. */ ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="assets/static/css/app.css">
<header class="er-nav mb-4">
    <nav class="navbar container py-2">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <i class="fa-solid fa-truck-medical"></i> Eko Response
        </a>
        <div class="d-flex gap-2">
            <?php if (!empty($_SESSION['useronline'])): ?>
                <a href="user_dashboard.php" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-table-cells-large me-1"></i> Dashboard</a>
            <?php else: ?>
                <a href="login_signup.php" class="btn btn-outline-secondary btn-sm">Login</a>
            <?php endif; ?>
            <a href="tel:112" class="btn btn-brand btn-sm"><i class="fa-solid fa-phone me-1"></i> 112</a>
        </div>
    </nav>
</header>
