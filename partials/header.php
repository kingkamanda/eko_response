<?php require_once __DIR__ . '/auth.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!--============== CSS================ -->
    <link rel="stylesheet" href="assets/static/css/nav.css">
    <link rel="stylesheet" href="assets/static/css/styles.css">
    <link rel="stylesheet" href="assets/static/css/app.css">

    <title>Eko Response - Emergency Response for Lagos</title>
</head>

<body>
    <?php $cur = basename($_SERVER['PHP_SELF'] ?? ''); ?>
    <!-- =========TOP BAR ========= -->
    <div class="er-topbar">
        <div class="container d-flex flex-wrap justify-content-between align-items-center py-2">
            <span><i class="fa-solid fa-location-dot me-1"></i> Lagos &amp; nationwide emergency response</span>
            <span>Emergency? Call <a href="tel:112">112</a> &middot; <a href="emergency.php">Report online</a></span>
        </div>
    </div>

    <!-- =========NAVBAR ========= -->
    <header class="er-nav sticky-top">
        <nav class="navbar navbar-expand-lg container py-2">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <i class="fa-solid fa-truck-medical"></i> Eko Response
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#erNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="erNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?php echo $cur === 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $cur === 'about.php' ? 'active' : ''; ?>" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $cur === 'hotzones.php' ? 'active' : ''; ?>" href="hotzones.php">Hot Zones</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo $cur === 'contact.php' ? 'active' : ''; ?>" href="contact.php">Contact</a></li>
                    <?php if ($loggedIn): ?>
                        <li class="nav-item"><a class="nav-link <?php echo $cur === 'user_dashboard.php' ? 'active' : ''; ?>" href="user_dashboard.php">Dashboard</a></li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <a href="emergency.php" class="btn btn-brand fw-semibold"><i class="fa-solid fa-triangle-exclamation me-1"></i> Report Emergency</a>
                    <?php if ($loggedIn): ?>
                        <a href="logout.php" class="btn btn-outline-secondary">Logout</a>
                    <?php else: ?>
                        <a href="login_signup.php" class="btn btn-outline-secondary">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>