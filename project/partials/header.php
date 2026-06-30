<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ======REMIX ICON======== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="assets/static/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="animate.min.css">
    <!--============== CSS================ -->
    <link rel="stylesheet" href="assets/static/css/nav.css">
     <link rel="stylesheet" href="assets/static/css/styles.css">
    <link rel="stylesheet" type="text/css" href="assets/static/fontawesome/css/all.min.css">
    
    <title>Welcome to Eko Response - Sign up</title>
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
           <div class="d-flex align-items-center justify-content-end modal-btn">
            <form action="login_signup.php" method="post">
                    <button type="submit" class="btn btn-primary">Login</button>
            </form>
           </div>
        </nav>
    </header>