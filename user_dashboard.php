<?php
session_start();
require_once "user_guard.php";
require_once "classes/User.php";
require_once "classes/Emergency.php";

$data = $_SESSION["useronline"];

$user1    = new User();
$userdata = $user1->get_current_user($data);
$firstname = ucfirst($userdata["user_fullname"] ?? 'User');

// Real, per-user emergency data (replaces the old hard-coded figures).
$incidentObj    = new Incident();
$myIncidents    = $incidentObj->fetch_user_incidents($data);
$totalReports   = count($myIncidents);
$resolvedCount  = $incidentObj->count_by_status('resolved', $data);
$pendingCount   = $totalReports - $resolvedCount;

$badgeClass = function ($status) {
    switch (strtolower((string) $status)) {
        case 'resolved':  return 'bg-success';
        case 'enroute':   return 'bg-warning text-dark';
        case 'severe':    return 'bg-danger';
        default:          return 'bg-secondary';
    }
};
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
                <a class="list-group-item list-group-item-action active" href="user_dashboard.php"><i class="fas fa-th-large"></i><span class="px-2">Dashboard</span></a>
                <a class="list-group-item list-group-item-action" href="emergency_form.php"><i class="fa-solid fa-triangle-exclamation"></i><span class="px-2">Report Emergency</span></a>
                <a class="list-group-item list-group-item-action" href="update_profile.php?id=<?php echo $userdata['user_id']; ?>"><i class="fa-solid fa-user"></i><span class="px-2">Update Profile</span></a>
                <a class="list-group-item list-group-item-action" href="index.php"><i class="fa-solid fa-house"></i><span class="px-2">Home</span></a>
                <a class="list-group-item list-group-item-action" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i><span class="px-2">Logout</span></a>
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
              <div class="col-md-4 ">
                <div class="card">
                  <div class="card-header">
                    <h5>My Reports</h5>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $totalReports; ?></h5>
                    <p class="card-text">Total emergencies you have reported</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4 ">
                <div class="card">
                  <div class="card-header">
                    <h5>Resolved</h5>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $resolvedCount; ?></h5>
                    <p class="card-text">Reports marked resolved</p>
                  </div>
                </div>
              </div>
              <div class="col-md-4 ">
                <div class="card">
                  <div class="card-header">
                    <h5>Pending</h5>
                  </div>
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $pendingCount; ?></h5>
                    <p class="card-text">Reports awaiting response</p>
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
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Reported Emergencies</h5>
                    <a href="emergency_form.php" class="btn btn-sm btn-danger">+ Report Emergency</a>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered align-middle">
                        <thead>
                          <tr>
                            <th>#ID</th>
                            <th>Phone Number</th>
                            <th>Location</th>
                            <th>Issue</th>
                            <th>Reported</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (empty($myIncidents)): ?>
                          <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                              You haven't reported any emergencies yet.
                              <a href="emergency_form.php">Report one now.</a>
                            </td>
                          </tr>
                          <?php else: foreach ($myIncidents as $row): ?>
                          <tr>
                            <th scope="row"><?php echo (int) $row['alert_id']; ?></th>
                            <td><?php echo htmlspecialchars($row['user_phone']); ?></td>
                            <td><?php echo htmlspecialchars(trim(($row['user_location'] ?? '') . ' ' . ($row['lga_name'] ? '(' . $row['lga_name'] . ')' : ''))); ?></td>
                            <td><span class="badge bg-danger"><?php echo htmlspecialchars($row['category_name'] ?? 'Emergency'); ?></span></td>
                            <td><?php echo htmlspecialchars($row['alert_time'] ?? ''); ?></td>
                            <td><span class="badge <?php echo $badgeClass($row['alert_status']); ?>"><?php echo htmlspecialchars($row['alert_status'] ?? 'pending'); ?></span></td>
                          </tr>
                          <?php endforeach; endif; ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="mt-3 text-muted">Showing <?php echo $totalReports; ?> report<?php echo $totalReports === 1 ? '' : 's'; ?>.</div>
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
                    <h5>Recent Activity <span class="badge bg-danger rounded-pill"><?php echo $totalReports; ?></span></h5>
                  </div>
                  <div class="card-body">
                    <?php if (empty($myIncidents)): ?>
                      <p class="text-muted mb-0">No activity yet. Your reported emergencies will appear here.</p>
                    <?php else: foreach (array_slice($myIncidents, 0, 5) as $note): ?>
                    <div class="col-md testimonial-card d-flex align-items-center mb-3">
                      <div class="col-3 testimonial-card-img-holder d-flex justify-content-center">
                        <i class="fa-solid fa-triangle-exclamation fa-2x text-danger"></i>
                      </div>
                      <div class="col-6 testimonial-card-body d-flex flex-column align-items-start ">
                        <span class="testimonial-card-title"><?php echo htmlspecialchars($note['category_name'] ?? 'Emergency'); ?></span>
                        <span class="small text-muted"><?php echo htmlspecialchars($note['lga_name'] ?? ''); ?></span>
                      </div>
                      <div class="col-3 d-flex align-items-center">
                        <span class="small"><?php echo htmlspecialchars(substr($note['alert_time'] ?? '', 0, 10)); ?></span>
                      </div>
                    </div>
                    <?php endforeach; endif; ?>
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