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
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

#sticky-btn {
    position: fixed;
  bottom: 20px;
  right: 20px;
  z-index: 9999;
  cursor: pointer;
  background-color: #25D366;
  /*color: #fff;
  padding: 10px 15px;
  border-radius: 5px;
  text-decoration: none; */
}

#sticky-btn i {
  font-size: 20px;
   color: #fff;
}
</style>

<body>
    <!-- =========HEADER =================-->
    <header class="header sticky-top">
        <nav class="nav container">
            <div class="nav__data">
                <a href="index.php" class="nav__logo">
                    <i class="ri-fire-line"></i>Eko Response
                </a>     
                    <div class="nav__toggle" id="nav-toggle">
                        <i class="ri-menu-line nav__burger"></i>
                        <i class="ri-close-line nav__close"></i>
                    </div>
            </div>
            <!-- =========NAV MENU ============-->
           <!---- show-menu-->
            <div class="nav__menu " id="nav-menu">
                 <ul class="nav__list">
                    <li><a href="index.php" class="nav__link">HOME</a></li>
                    <li><a href="about.php" class="nav__link">ABOUT US</a></li>
                    <li><a href="emergency.php" class="nav__link">REPORT EMERGENCY</a></li>
                    <li><a href="hotzones.php" class="nav__link">HOT ZONES</a></li>
                    <li><a href="contact.php" class="nav__link">CONTACT US</a></li>
                    <?php if ($loggedIn): ?>
                        <li><a href="user_dashboard.php" class="nav__link">DASHBOARD</a></li>
                    <?php endif; ?>
                </ul>
            </div>

           <div class="d-flex align-items-center justify-content-end modal-btn gap-2">
                <?php if ($loggedIn): ?>
                    <a href="user_dashboard.php" class="btn btn-brand">Return to Dashboard</a>
                    <a href="logout.php" class="btn btn-outline-secondary">Logout</a>
                <?php else: ?>
                    <a href="login_signup.php" class="btn btn-outline-secondary">Login</a>
                    <a href="login_signup.php?form=signup" class="btn btn-brand">Register</a>
                <?php endif; ?>
           </div>
        </nav>
    </header>