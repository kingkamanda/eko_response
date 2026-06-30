<?php
ini_set("display_errors", "1");
session_start();
require_once "user_guard.php";
// require_once "partials/dashboardhead.php";
require_once "classes/User.php";
$data = $_SESSION["useronline"];

// echo "<pre>";
// print_r($data);
//  echo "</pre>";


$user1 = new User();
$userdata = $user1->get_current_user($data);
$firstname = $userdata["user_fullname"];
$firstname = ucfirst($firstname);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./assets/static/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="animate.min.css">
  <link rel="stylesheet" type="text/css" href="./assets/dashboard.css">
  <link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css">
  <!-- ======REMIX ICON======== -->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <!--=========GOOGLE FONTS===========-->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!--=========GOOGLE ICONS===========-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
  <link rel="stylesheet" type="text/css" href="assets/static/fontawesome/css/all.min.css">
  <title>Eko Response - User Dashboard</title>
  <style>
    .sidebar-footer {
      position: absolute;
      bottom: 20px;
      left: 20px;
      right: 20px;
      text-align: center;
    }

    .sidebar-footer a {
      color: #fff;
    }


    aside .list-holder a:last-child {
      position: absolute;
      bottom: 1rem;
      width: 90%;
    }

    aside {
      height: 95vh;
    }

    aside .top {
      /* display: flex; */
      align-items: center;
      /* justify-content: space-between; */
      /* margin-top: 1.4rem; */
    }

    aside .logo {
      /* display: flex; */
      /* gap: 1rem; */
    }

    aside .top div.close span {
      display: none;
    }

    aside
  </style>
</head>


<body>

  <!-- DASHBOARD AREA -->

  <div class="container-fluid dash-board-main main px-3">
    <div class="row dash-inner-1 gx-1 ">
      <!--===============DASHBOARD SIDE BAR BEGINNING=================-->

      <div class="container-fluid">
        <!-- <div class="row dash-profile p-2"> -->
        <div class="row">
          <!-- <div class="col-md-6" style="width: 100%;"> -->

          <aside class="col-md-2 bg-light p-3">


            <div class="top">
              <div class="logo">
                <a href="index.php" class="navbar-brand nav__logo">
                  <i class="ri-fire-line"></i>Eko Response
                </a>
              </div>
              <div class="close" id="close_btn">
                <span class="material-symbols-sharp">
                  close
                </span>
              </div>
            </div>
            <!-- <div class="biola"> -->
            <div class="text-center mb-4 ">

              <!-- <img src="uploads/<?php //echo $userdata['user_image'] 
                                      ?>" class="img-fluid" alt="admin image"> -->
              <img src="uploads/<?php echo $userdata['user_image'] ?>" class="img-fluid rounded-circle mt-3" alt="User image" style="width:100px; border-radius:50%;">

              <!-- </div> -->
              <h6><?php echo $firstname ?></h6>
              <b><span>User</span></b>
            </div>
            <!-- </div> -->
            <div>
              <!-- <div class="admin-nav" style="min-height: 50px;">
                    <div class="mt-1"> -->


              <!-- </div> -->
              <div class="list-group list-holder menu-bar">
                <!-- <div class="row mt-1">
                        <div class="col-12"> -->
                <!-- <div class="list-group" id="list-tab" role="tablist">
              <div class="sidebar col-sm-2 dashboard-cards shadow-lg p-3 mt-1">  -->
                <a class="list-group-item list-group-item-action " id="list-home-list" data-bs-toggle="list" href="user_dashboard.php" role="tab" aria-controls="list-home"><i class="fas fa-th-large"></i><span class="px-2">Dashboard</span></a>
                <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile"><i class="fa-solid fa-users"></i><span class="px-2">Users</span></a>
                <a class="list-group-item list-group-item-action" id="list-messages-list" data-bs-toggle="list" href="#list-messages" role="tab" aria-controls="list-messages"><i class="fa-solid fa-truck-medical"></i><span class="px-2">Ambulance</span></a>
                <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings"><i class="fa-solid fa-handcuffs"></i><span class="px-2">Police</span></a>
                <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings"><i class="fa-solid fa-star-of-life"></i><span class="px-2">Hospitals</span></a>
                <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings"><i class="fa-solid fa-fire-extinguisher"></i><span class="px-2">Fire Stations</span></a>
                <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="update_profile.php?id=<?php echo $userdata['user_id']; ?>" role="tab" aria-controls="list-settings"><i class="fa-solid fa-user"></i><span class="px-2">Update Profile</span></a>
                <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings"><i class="fa-solid fa-gear"></i><span class="px-2">Settings</span></a>


                <a class="list-group-item " id="list-settings-list" data-bs-toggle="list" href="logout.php" role="tab" aria-controls="list-settings"><i class="fa-solid fa-arrow-right-from-bracket"></i><span class="px-2">Logout</span></a>
              </div>
            </div>
          </aside>
          <!--===============DASHBOARD SIDE BAR END=================-->
          <div class="col-sm-10 ">
            <!-- <div> -->
            <h3><span>DASHBOARD</span></h3>
            <h3>Welcome, <?php echo $firstname ?>!</h3>
            <p>What you have been up to?</p>

            <!-- </div> -->
            <!-- <div class="container px-1 "> -->

            <!--===============DASHBOARD CARD BEGINNING=================-->
            <!-- <div class="row gx-1 gy-1 "> -->
            <div class="row g-3">
              <div class="col-md-3 ">
                <!-- <div class="p-3 dashboard-cards shadow-lg p-3"> -->
                <div class="card">
                  <div class="card-header">
                    <h5>Total Escalation</h5>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">4</h5>
                    <p class="card-text">0 <span>Today</span></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 ">
                <!-- <div class="p-3 dashboard-cards shadow-lg p-3"> -->
                <div class="card">
                  <div class="card-header">
                    <h5>Resolved Escalation</h5>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">4</h5>
                    <p class="card-text">0 <span>Today</span></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 ">
                <!-- <div class="p-3  dashboard-cards shadow-lg p-3"> -->
                <div class="card">
                  <div class="card-header">
                    <h5>Agencies</h5>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">6000</h5>
                    <p class="card-text">101 <span>Joined Today</span></p>
                  </div>
                </div>
              </div>
              <div class="col-md-3 ">
                <!-- <div class="p-3  dashboard-cards shadow-lg p-3"> -->
                <div class="card">
                  <div class="card-header">
                    <h5>Users</h5>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">6456</h5>
                    <p class="card-text">200 <span>Joined Today</span></p>
                  </div>

                </div>
              </div>

            </div>
            <!--===============DASHBOARD CARD END=================-->


            <!-- <div class="col mt-1">-->
            <div class="row g-3 mt-3">
              <!-- <div class="row gx-1" style="min-height: 570px;"> -->
              <div class="col-md-9 ">
                <!-- <div class="p-3 dashboard-cards shadow-lg p-3" style="min-height: 560px;"> -->
                <div class="card">
                  <div class="card-header">
                    <h5>Active Emergency</h5>
                  </div>
                  <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                      <span>Show</span>
                      <!-- <div class="btn dropdown dropup"> -->
                      <div class="dropdown ms-2">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                          <span class="page-size">
                            10
                          </span>
                          <!-- <span class="caret"></span> -->
                        </button>
                        <ul class="dropdown-menu">
                          <li><a class="dropdown-item " href="#">10</a></li>
                          <li><a class="dropdown-item " href="#">25</a></li>
                          <li><a class="dropdown-item " href="#">50</a></li>
                          <li><a class="dropdown-item " href="#">100</a></li>
                          <li><a class="dropdown-item " href="#">All</a></li>
                        </ul>
                      </div>
                      <span class="ms-2">Entries</span>
                    </div>
                    <!-- <div class="customer-table mt-2"> -->
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered table align-middle">
                        <thead>
                          <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Location</th>
                            <th>Issue</th>
                            <!-- <th>Status</th> -->

                          </tr>
                        </thead>
                        <tbody>

                          <tr>
                            <th scope="row">4</th>
                            <td><?php echo $firstname ?></td>
                            <td>+2348023447457</td>
                            <td>Iyana Ipaja</td>
                            <td><span class="badge bg-danger">Fire Outbreak</span></td>
                            <!-- <td><span class="badge bg-success">Complete</span></td> -->
                          </tr>

                          <tr>
                            <th scope="row">5</th>
                            <td><?php echo $firstname ?></td>
                            <td>+2349033020039</td>
                            <td>Bariga</td>
                            <td><span class="badge bg-danger">Car Accident</span></td>
                            <!-- <td><span class="badge bg-warning">Enroute</span></td> -->
                          </tr>

                          <tr>
                            <th scope="row">6</th>
                            <td><?php echo $firstname ?></td>
                            <td>+2347066326629</td>
                            <td>Lekki</td>
                            <td><span class="badge bg-danger">Flood</span></td>
                            <!-- <td><span class="badge bg-warning">Enroute</span></td> -->
                          </tr>
                          <tr>
                            <th scope="row">7</th>
                            <td><?php echo $firstname ?></td>
                            <td>+2347066326629</td>
                            <td>Sango-tedo</td>
                            <td><span class="badge bg-danger">Inactive 2</span></td>
                            <!-- <td><span class="badge bg-success">Complete</span></td> -->
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                      <div>Showing 1 to 10 of 20 Entries</div>
                      <nav>
                        <ul class="pagination">
                          <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                          <li class="page-item"><a class="page-link" href="#">1</a></li>
                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                          <!-- <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
                        </ul>
                      </nav>
                    </div>
                  </div>
                </div>
              </div>


              <!----------------------------------- NOTIFICATION PANE START---------------------->
              <!-- <div class="col-sm-3 dashboard-cards shadow-lg "> -->
              <div class="col-md-3">
                <!-- <div class=" " style="min-height: 540px;">
        <div class="mt-4 mb-5 mx-3"> -->
                <div class="card">
                  <div class="card-header">
                    <h5>Notification <span class="badge bg-danger rounded-pill">14</span></h5>
                  </div>
                  <!-- <div class="car-header">
                    <h6>NOTIFICATION <span class="badge bg-danger rounded-pill">14</span></h6>
                  </div> -->
                  <div class="card-body">
                    <div class="col-md testimonial-card d-flex align-items-center mb-3">
                      <div class="col-3 testimonial-card-img-holder d-flex justify-content-center">
                        <img src="uploads/<?php echo $userdata['user_image'] ?>" class="testimonial-card-img img-fluid" alt="	" style="border-radius: 100%;">
                      </div>
                      <div class="col-6 testimonial-card-body d-flex flex-column align-items-start ">
                        <span class="testimonial-card-title"><?php echo $firstname ?></span>
                        <span>Fire Emergency</span>
                      </div>
                      <div class="col-3 d-flex align-items-center">
                        <span>13:53pm</span>
                      </div>
                    </div>


                    <div class="col-md testimonial-card d-flex align-items-center mb-3">
                      <div class="col-3 testimonial-card-img-holder d-flex justify-content-center">
                        <img src="uploads/<?php echo $userdata['user_image'] ?>" class="testimonial-card-img img-fluid" alt="	" style="border-radius: 100%;">
                      </div>
                      <div class="col-6 testimonial-card-body d-flex flex-column align-items-start">
                        <span class="testimonial-card-title"><?php echo $firstname ?></span>
                        <h6>Accident Emerg...</h6>
                      </div>
                      <div class="col-3 d-flex align-items-center">
                        <span>13:53pm</span>
                      </div>
                    </div>


                    <div class="col-md testimonial-card d-flex align-items-center mb-3">
                      <div class="col-3 testimonial-card-img-holder d-flex justify-content-center">
                        <img src="uploads/<?php echo $userdata['user_image'] ?>" class="testimonial-card-img img-fluid" alt="	" style="border-radius: 100%;">
                      </div>
                      <div class="col-6 testimonial-card-body d-flex flex-column align-items-start ">
                        <span class="testimonial-card-title"><?php echo $firstname ?></span>
                        <span>Fire Emergency</span>
                      </div>
                      <div class="col-3 d-flex align-items-center">
                        <span>13:53pm</span>
                      </div>
                    </div>

                    <div class="col-md testimonial-card d-flex align-items-center mb-3">
                      <div class="col-3 testimonial-card-img-holder d-flex justify-content-center">
                        <img src="uploads/<?php echo $userdata['user_image'] ?>" class="testimonial-card-img img-fluid" alt="	" style="border-radius: 100%;">
                      </div>
                      <div class="col-6 testimonial-card-body d-flex flex-column align-items-start ">
                        <span class="testimonial-card-title"><?php echo $firstname ?></span>
                        <span>Fire Emergency</span>
                      </div>
                      <div class="col-sm-3 d-flex align-items-center">
                        <span>13:53pm</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!----------------------------------- NOTIFICATION PANE END---------------------->
            <footer class="footer mt-3">
              <div class="text-center">
                &copy; 2023 Eko Response. All Rights Reserved.
              </div>
            </footer>
          </div>
        </div>
      </div>

    </div>

  </div>


  </div>





  <script src="jquery-3.7.1.js"></script>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="bootstrap/js/bootstrap.bundle.js"></script>
  <script src="./assets/static/javascript/main.js"></script>
  <script type="text/javascript"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>