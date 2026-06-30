<?php
ini_set("display_errors", "1");
session_start();
require_once "user_guard.php";
require_once "partials/dashboardhead.php";
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
<style>

</style>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary ">
    <div class="container-fluid">
       <!-- <div class="col-2">  -->
      <!-- nav__logo -->
      <a href="#" class="navbar-brand">
        <i class="ri-fire-line"></i>Eko Response
      </a>
      <!-- </div> -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    <!-- </div> -->

    <div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
      <div class="xp-profilebar text-right">
        <div class="navbar p-0 text-center d-flex  align-items-center">
          <div>
            <p id="register message"></p>
          </div>
          <ul class="nav navbarr-nav flex-row ml-auto">
            <li class="downdown nav-item active">
              <a href="#" class="nav-link" data-toggle="dropdown">
                <span class="material-icons">notifications</span><span class="notification">4</span>
              </a>
              <ul class="dropdown-menu">
                <li><a href="#">You Have 4 New Messages</a></li>
                <li><a href="#">You Have 4 New Messages</a></li>
                <li><a href="#">You Have 4 New Messages</a></li>
                <li><a href="#">You Have 4 New Messages</a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">
                <span class="material-icons">question_answer</span>
              </a>
            </li>

            <li class="downdown nav-item">
              <a class="nav-link" href="#" data-toggle="dropdown">
                <img src="uploads/<?php echo $userdata['user_image'] ?>" style="width:40px; border-radius:50%" ; class="" alt="admin image">
                <span class="xp-user-live"></span>
              </a>
              <ul class="dropdown-menu small-menu">
                <li><a href="update_profile.php?id=<?php echo $userdata['user_id']; ?>">Update Profile</a>
                  <span class="material-icons">person_outline</span>
                  </a>
                </li>
                <li><a href="#"><span class="material-icons">settings</span>Settings
                  </a></li>
                <li><a href="logout.php"><span class="material-icons">logout</span>Logout
                  </a></li>
              </ul>
            </li>
          </ul>
          <span>
            <h6><?php echo $firstname ?></h6>
          </span>
        </div>

      </div>
    </div>
    </div>
  </nav>
  <!-- DASHBOARD AREA -->

  <div class="container-fluid dash-board-main px-3">
    <div class="row dash-inner-1 gx-1 ">
      <!--===============DASHBOARD SIDE BAR BEGINNING=================-->

      <?php
      require_once "partials/sidebar.php";
      ?>
      <!--===============DASHBOARD SIDE BAR END=================-->
      <div class="col-sm-10 ">
        <div>
          <h3><span>DASHBOARD</span></h3>

          <h3>Welcome, <?php echo $firstname ?>!</h3>
          <p>See what you have been up to!</p>

        </div>
        <div class="container px-1 ">

          <!--===============DASHBOARD CARD BEGINNING=================-->
          <?php
          require_once "partials/dashboardcard.php";
          ?>
          <!--===============DASHBOARD CARD END=================-->


          <div class="col mt-1">
            <div class="row gx-1" style="min-height: 570px;">
              <div class="col-sm-9 ">
                <div class="p-3 dashboard-cards shadow-lg p-3" style="min-height: 560px;">
                  <h5>Active Emergency</h5>
                  <div>
                    <span>Show</span>
                    <div class="btn dropdown dropup">
                      <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="page-size">
                          10
                        </span>
                        <span class="caret"></span>
                      </button>
                      <div class="dropdown-menu">
                        <a class="dropdown-item active" href="#">10</a>
                        <a class="dropdown-item " href="#">25</a>
                        <a class="dropdown-item " href="#">50</a>
                        <a class="dropdown-item " href="#">100</a>
                        <a class="dropdown-item " href="#">All</a>
                      </div>
                    </div>
                    <span>Entries</span>
                  </div>
                  <div class="customer-table mt-2">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>#ID</th>
                          <th>Name</th>
                          <th>Phone Number</th>
                          <th>Location</th>
                          <th>Issue</th>
                          <th>Progress</th>
                          <th>Status</th>

                        </tr>
                      </thead>
                      <tbody>

                        <tr>
                          <th scope="row">4</th>
                          <td>Damini</td>
                          <td>+2348023447457</td>
                          <td>Iyana Ipaja</td>
                          <td><span class="badge bg-danger">Fire Outbreak</span></td>
                          <td><span>
                              <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-success" style="width: 100%">100%</div>
                              </div>
                            </span>
                          </td>
                          <td><span class="badge bg-success">Complete</span></td>
                        </tr>

                        <tr>
                          <th scope="row">5</th>
                          <td>Olamide</td>
                          <td>+2349033020039</td>
                          <td>Bariga</td>
                          <td><span class="badge bg-danger">Car Accident</span></td>
                          <td><span>
                              <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-warning" style="width: 65%">65%</div>
                              </div>
                            </span>
                          </td>
                          <td><span class="badge bg-warning">Enroute</span></td>
                        </tr>

                        <tr>
                          <th scope="row">6</th>
                          <td>Yemi</td>
                          <td>+2347066326629</td>
                          <td>Lekki</td>
                          <td><span class="badge bg-danger">Flood</span></td>
                          <td><span>
                              <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-warning" style="width: 80%">80%</div>
                              </div>
                            </span>
                          </td>
                          <td><span class="badge bg-warning">Enroute</span></td>
                        </tr>
                        <tr>
                          <th scope="row">7</th>
                          <td>Larry</td>
                          <td>the Bird</td>
                          <td>@twitter</td>
                          <td><span class="badge bg-danger">Inactive 2</span></td>
                          <td><span>
                              <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-success" style="width: 100%">100%</div>
                              </div>
                            </span>
                          </td>
                          <td><span class="badge bg-success">Complete</span></td>
                        </tr>
                        <tr>
                          <th scope="row">8</th>
                          <td>Larry</td>
                          <td>the Bird</td>
                          <td>@twitter</td>
                          <td><span class="badge bg-danger">Inactive 2</span></td>
                          <td><span>
                              <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-danger" style="width: 25%">25%</div>
                              </div>
                            </span>
                          </td>
                          <td><span class="badge bg-danger">Dispatching</span>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">9</th>
                          <td>Larry</td>
                          <td>the Bird</td>
                          <td>@twitter</td>
                          <td><span class="badge bg-danger">Inactive 2</span></td>
                          <td><span>
                              <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-danger" style="width: 25%">25%</div>
                              </div>
                            </span>
                          </td>
                          <td><span class="badge bg-danger">Dispatching</span>
                          </td>
                        </tr>
                        <tr>
                          <th scope="row">10</th>
                          <td>Larry</td>
                          <td>the Bird</td>
                          <td>@twitter</td>
                          <td><span class="badge bg-danger">Inactive 2</span></td>
                          <td><span>
                              <div class="progress" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar text-bg-warning" style="width: 80%">80%</div>
                              </div>
                            </span>
                          </td>
                          <td><span class="badge bg-warning">Enroute</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


              <!----------------------------------- NOTIFICATION PANE START---------------------->
              <?php
              require_once "partials/notification.php";
              ?>
              <!----------------------------------- NOTIFICATION PANE END---------------------->

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