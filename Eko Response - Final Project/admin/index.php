<?php
    //echo password_hash('12345', PASSWORD_DEFAULT);
    ini_set("display_errors", "1");
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <!-- ======REMIX ICON======== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="../assets/static/bootstrap/css/bootstrap.min.css">

    <!-- <link rel="stylesheet" href="animate.min.css"> -->
    <!--============== CSS================ -->
    <link rel="stylesheet" href="../assets/static/css/nav.css">
    <link rel="stylesheet" href="../assets/static/css/styles.css">
    <link rel="stylesheet" type="text/css" href="../assets/static/fontawesome/css/all.min.css">

    <title>Eko Response - Admin Sign up</title>
</head>
<style>
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
                    <!-- <li><a href="#" class="nav__link">COMPANY</a></li> -->
                    <!-- ========= DROPDOWN 1 ============-->
                    <li class="dropdown__item">
                        <div class="nav__link">
                           ANALYTICS<i class="ri-arrow-down-s-line dropdown__arrow"></i>
                          </div>
                          
                        <ul class="dropdown__menu">
                            <li>
                                <a href="#" class="dropdown__link">
                                    <i class="ri-hospital-line"></i>MEDICAL CASES
                                </a>
                            </li>
                            <li>
                                <a href="#" class="dropdown__link">
                                   <i class="ri-fire-fill"></i> FIRE CASES
                                </a>
                            </li>

                                <!-- ========= DROPDOWN SUBMENU ============-->                   
                            <li class="dropdown__subitem">
                                <div class="dropdown__link">
                                <i class="ri-alarm-warning-fill"></i> REPORTS <i class="ri-add-line dropdown__add"></i> 
                                </div>

                                <ul class="dropdown__submenu">
                                  <li>
                                     <a href="#" class="dropdown__sublink">
                                     <i class="ri-file-list-line"></i>SUCCESS RATE
                                     </a>
                                  </li>

                                  <li>
                                     <a href="#" class="dropdown__sublink">
                                     <i class="ri-cash-line"></i>SUCCESS STORIES
                                     </a>
                                  </li>
                                  

                                  <li>
                                     <a href="#" class="dropdown__sublink">
                                     <i class="ri-refund-line"></i>SOME OPTION
                                     </a>
                                  </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li><a href="about.php" class="nav__link">ABOUT US</a></li>

                     <!-- ========= DROPDOWN 2 ============-->
                    <li class="dropdown__item">
                        <div class="nav__link">
                         EMERGENCY UNIT<i class="ri-arrow-down-s-line dropdown__arrow"></i>
                        </div>
                    <!-- ========= SUB DROPDOWN 2 ============-->                        
                        <ul class="dropdown__menu">
                            <li>
                                <a href="" class="dropdown__link">
                                    <i class="ri-user-line"></i>FIRE
                                </a>
                            </li>

                            <li>
                                <a href="" class="dropdown__link">
                                    <i class="ri-lock-2-line"></i> POLICE
                                </a>
                            </li>

                            <li>
                                <a href="" class="dropdown__link">
                                    <i class="ri-message-3-line"></i>HOSPITAL
                                </a>
                            </li>
                        </ul> 
                    </li>

                    <li><a href="contact.php" class="nav__link">CONTACT US</a></li>
            
                </ul>
                
            </div>

           <div>
             
           </div>
           
        </nav>
    </header>

    <body>
        <section class="ftco-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center mb-5">
                        <!-- <h2 class="heading-section">Admin Sign In</h2> -->
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-7 col-lg-5">
                        <div class="login-wrap p-4 p-md-5">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <span class="fa fa-user-o"></span>
                            </div>
                            <h3 class="text-center mb-4">Admin Sign in</h3>

                            <?php
                                if(isset($_SESSION["admin_errormessage"])){
                                echo "<div class='alert alert-danger'> ".$_SESSION['admin_errormessage']."</div>";
                                }
                                unset($_SESSION['admin_errormessage']);
                                
                                if(isset($_SESSION["errormessage"])){
                                echo "<div class='alert alert-danger'> ".$_SESSION['errormessage']."</div>";
                                }
                                unset($_SESSION['errormessage']);
                        
                            ?>
                            <form action="process/process_adminlogin.php" class="login-form" method="post">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control rounded-left" placeholder="Email"
                                        >
                                </div>
                                <div class="form-group d-flex">
                                    <input type="password" name="password" class="form-control rounded-left" id="inputPassword" placeholder="Password"
                                        >
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                        class="form-control btn btn-primary rounded submit px-3" value="submit" name="adminlogin">Login</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-50">
                                        <label class="checkbox-wrap checkbox-primary">Remember Me
                                            <input type="checkbox" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="w-50 text-md-right">
                                        <a href="#">Forgot Password</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
    <!-- Footer -->
    <?php
        require_once"../partials/footer.php"
    ?>

    <script src="assets/jquery-3.7.1.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="js/main.js"></script>
    <!-- =======================JAVASCRIPT========================= -->
    <script src="javascript/main.js"></script>
</body>

</html>