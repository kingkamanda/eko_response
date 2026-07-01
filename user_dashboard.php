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
$pendingFeedback = $incidentObj->pending_feedback($data);

$badgeClass = function ($status) {
    switch (strtolower((string) $status)) {
        case 'resolved':  return 'bg-success';
        case 'enroute':   return 'bg-warning text-dark';
        case 'severe':    return 'bg-danger';
        default:          return 'bg-secondary';
    }
};
$sevBadge = function ($s) {
    switch (strtolower((string) $s)) {
        case 'severe':   return 'bg-danger';
        case 'moderate': return 'bg-warning text-dark';
        case 'mild':     return 'bg-info text-dark';
        default:         return 'bg-secondary';
    }
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="./assets/dashboard.css">
  <link rel="stylesheet" href="assets/static/css/app.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
                <a class="list-group-item list-group-item-action" href="hotzones.php"><i class="fa-solid fa-fire"></i><span class="px-2">Hot Zones</span></a>
                <a class="list-group-item list-group-item-action" href="request_emergency_type.php"><i class="fa-solid fa-lightbulb"></i><span class="px-2">Request Type</span></a>
                <a class="list-group-item list-group-item-action" href="support.php"><i class="fa-solid fa-headset"></i><span class="px-2">Support Chat</span></a>
                <a class="list-group-item list-group-item-action" href="update_profile.php?id=<?php echo $userdata['user_id']; ?>"><i class="fa-solid fa-user"></i><span class="px-2">Update Profile</span></a>
                <a class="list-group-item list-group-item-action" href="index.php"><i class="fa-solid fa-house"></i><span class="px-2">Home</span></a>
                <a class="list-group-item list-group-item-action" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i><span class="px-2">Logout</span></a>
              </div>
            </div>
          </aside>
          <!--===============DASHBOARD SIDE BAR END=================-->
          <div class="col-sm-10 ">
            <!-- <div> -->
            <!-- Welcome + quick actions -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
              <div>
                <h3 class="mb-0">Welcome, <?php echo htmlspecialchars($firstname) ?>!</h3>
                <p class="text-muted mb-0">Here's an overview of your emergency reports.</p>
              </div>
              <div class="d-flex flex-wrap gap-2">
                <a href="emergency_form.php" class="btn btn-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i> Report Emergency</a>
                <a href="hotzones.php" class="btn btn-outline-dark"><i class="fa-solid fa-fire me-1"></i> Hot Zones</a>
                <a href="request_emergency_type.php" class="btn btn-outline-dark"><i class="fa-solid fa-lightbulb me-1"></i> Request Type</a>
              </div>
            </div>

            <?php if (!empty($pendingFeedback)): ?>
              <div class="alert alert-warning d-flex justify-content-between align-items-center">
                <span><i class="fa-solid fa-star me-1"></i> You have <?php echo count($pendingFeedback); ?> resolved emergenc<?php echo count($pendingFeedback) === 1 ? 'y' : 'ies'; ?> awaiting your feedback. Feedback is required before reporting again.</span>
                <a href="feedback.php" class="btn btn-sm btn-warning">Give feedback</a>
              </div>
            <?php endif; ?>

            <!--===============DASHBOARD CARD BEGINNING=================-->
            <div class="row g-3">
              <div class="col-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body d-flex align-items-center">
                    <span class="me-3 fs-2 text-primary"><i class="fa-solid fa-clipboard-list"></i></span>
                    <div>
                      <div class="h3 mb-0 fw-bold"><?php echo $totalReports; ?></div>
                      <div class="text-muted small">My Reports</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body d-flex align-items-center">
                    <span class="me-3 fs-2 text-success"><i class="fa-solid fa-circle-check"></i></span>
                    <div>
                      <div class="h3 mb-0 fw-bold"><?php echo $resolvedCount; ?></div>
                      <div class="text-muted small">Resolved</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body d-flex align-items-center">
                    <span class="me-3 fs-2 text-warning"><i class="fa-solid fa-hourglass-half"></i></span>
                    <div>
                      <div class="h3 mb-0 fw-bold"><?php echo $pendingCount; ?></div>
                      <div class="text-muted small">Pending</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--===============DASHBOARD CARD END=================-->


            <!-- <div class="col mt-1">-->
            <div class="row g-3 mt-1">
              <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0">My Reported Emergencies</h5>
                    <div class="d-flex gap-2">
                      <input type="search" id="reportSearch" class="form-control form-control-sm" placeholder="Search…" style="width:150px;">
                      <select id="statusFilter" class="form-select form-select-sm" style="width:130px;">
                        <option value="">All statuses</option>
                        <option value="pending">Pending</option>
                        <option value="enroute">Enroute</option>
                        <option value="resolved">Resolved</option>
                      </select>
                      <a href="emergency_form.php" class="btn btn-sm btn-brand text-nowrap">+ Report</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered align-middle" id="reportsTable">
                        <thead>
                          <tr>
                            <th>#ID</th>
                            <th>Location</th>
                            <th>Issue</th>
                            <th>Severity</th>
                            <th>Reported</th>
                            <th>Status</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (empty($myIncidents)): ?>
                          <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                              You haven't reported any emergencies yet.
                              <a href="emergency_form.php">Report one now.</a>
                            </td>
                          </tr>
                          <?php else: foreach ($myIncidents as $row): ?>
                          <tr>
                            <th scope="row"><?php echo (int) $row['alert_id']; ?></th>
                            <td>
                                <?php echo htmlspecialchars(trim(($row['user_location'] ?? '') . ' ' . ($row['lga_name'] ? '(' . $row['lga_name'] . ')' : ''))); ?>
                                <?php if (!empty($row['latitude']) && !empty($row['longitude'])): ?>
                                    <a class="d-block small" target="_blank" rel="noopener"
                                       href="https://www.google.com/maps?q=<?php echo $row['latitude']; ?>,<?php echo $row['longitude']; ?>">📍 Map</a>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-danger"><?php echo htmlspecialchars($row['category_name'] ?? 'Emergency'); ?></span></td>
                            <td><span class="badge <?php echo $sevBadge($row['severity'] ?? ''); ?>"><?php echo htmlspecialchars($row['severity'] ?? 'n/a'); ?></span></td>
                            <td><?php echo htmlspecialchars($row['alert_time'] ?? ''); ?></td>
                            <td><span class="badge <?php echo $badgeClass($row['alert_status']); ?>"><?php echo htmlspecialchars($row['alert_status'] ?? 'pending'); ?></span></td>
                            <td><a class="btn btn-sm btn-outline-primary" href="incident_view.php?id=<?php echo (int)$row['alert_id']; ?>">Open</a></td>
                          </tr>
                          <?php endforeach; endif; ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="mt-3 text-muted">Showing <?php echo $totalReports; ?> report<?php echo $totalReports === 1 ? '' : 's'; ?>.</div>
                  </div>
                </div>
              </div>


              <!----------------------------------- ACTIVITY PANE START---------------------->
              <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Activity <span class="badge bg-danger rounded-pill"><?php echo $totalReports; ?></span></h5>
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





  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Client-side search + status filter for the reports table.
    (function () {
      var search = document.getElementById('reportSearch');
      var filter = document.getElementById('statusFilter');
      var table  = document.getElementById('reportsTable');
      if (!table) return;
      var rows = Array.prototype.slice.call(table.tBodies[0].rows);
      function apply() {
        var q = (search.value || '').toLowerCase();
        var s = (filter.value || '').toLowerCase();
        rows.forEach(function (r) {
          if (r.children.length < 6) return; // skip the empty-state row
          var text = r.innerText.toLowerCase();
          var status = (r.children[5].innerText || '').toLowerCase();
          var show = text.indexOf(q) !== -1 && (s === '' || status.indexOf(s) !== -1);
          r.style.display = show ? '' : 'none';
        });
      }
      if (search) search.addEventListener('input', apply);
      if (filter) filter.addEventListener('change', apply);
    })();
  </script>
</body>

</html>