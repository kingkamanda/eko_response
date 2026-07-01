<?php
session_start();
require_once "user_guard.php";
require_once "classes/User.php";
require_once "classes/Emergency.php";

$data = $_SESSION["useronline"];

$user1    = new User();
$userdata = $user1->get_current_user($data);
$firstname = ucfirst($userdata["user_fullname"] ?? 'User');

$incidentObj     = new Incident();
$myIncidents     = $incidentObj->fetch_user_incidents($data);
$totalReports    = count($myIncidents);
$resolvedCount   = $incidentObj->count_by_status('resolved', $data);
$pendingCount    = $totalReports - $resolvedCount;
$pendingFeedback = $incidentObj->pending_feedback($data);

$badgeClass = function ($status) {
    switch (strtolower((string) $status)) {
        case 'resolved': return 'bg-success';
        case 'enroute':  return 'bg-warning text-dark';
        case 'severe':   return 'bg-danger';
        default:         return 'bg-secondary';
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

$loc = function ($row) {
    return trim(($row['user_location'] ?? '') . ' ' . ($row['lga_name'] ? '(' . $row['lga_name'] . ')' : ''));
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Eko Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/static/css/app.css">
    <style>
        .er-side { position: sticky; top: 0; }
        .er-side .avatar { width:76px;height:76px;object-fit:cover;border:3px solid rgba(255,255,255,.15); }
        .dash-main { background: var(--er-bg); }
        @media (max-width: 767px){ .er-side { min-height:auto; } }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- ===== Sidebar ===== -->
        <nav class="col-md-3 col-lg-2 p-0 er-side">
            <div class="er-brand"><i class="fa-solid fa-truck-medical text-danger"></i> Eko Response</div>
            <div class="text-center text-white pb-3 px-3">
                <img src="uploads/<?php echo htmlspecialchars($userdata['user_image'] ?? ''); ?>"
                     onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($firstname); ?>&background=d7263d&color=fff'"
                     class="rounded-circle avatar" alt="">
                <div class="mt-2 fw-semibold"><?php echo htmlspecialchars($firstname); ?></div>
                <div class="small text-secondary">Member</div>
            </div>
            <a href="user_dashboard.php" class="active"><i class="fa-solid fa-table-cells-large me-2"></i> Dashboard</a>
            <a href="emergency_form.php"><i class="fa-solid fa-triangle-exclamation me-2"></i> Report Emergency</a>
            <a href="hotzones.php"><i class="fa-solid fa-fire me-2"></i> Hot Zones</a>
            <a href="request_emergency_type.php"><i class="fa-solid fa-lightbulb me-2"></i> Request Type</a>
            <a href="support.php"><i class="fa-solid fa-headset me-2"></i> Support Chat</a>
            <a href="update_profile.php"><i class="fa-solid fa-user me-2"></i> Update Profile</a>
            <a href="index.php"><i class="fa-solid fa-house me-2"></i> Home</a>
            <a href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
        </nav>

        <!-- ===== Main ===== -->
        <main class="col-md-9 col-lg-10 dash-main px-3 px-md-4 py-4">
            <!-- Header + quick actions -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                <div>
                    <h3 class="mb-0">Welcome, <?php echo htmlspecialchars($firstname); ?>!</h3>
                    <p class="text-muted mb-0">Here's an overview of your emergency reports.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="emergency_form.php" class="btn btn-brand"><i class="fa-solid fa-triangle-exclamation me-1"></i> Report Emergency</a>
                    <a href="hotzones.php" class="btn btn-outline-dark"><i class="fa-solid fa-fire me-1"></i> Hot Zones</a>
                </div>
            </div>

            <?php if (!empty($pendingFeedback)): ?>
                <div class="alert alert-warning d-flex flex-wrap justify-content-between align-items-center">
                    <span><i class="fa-solid fa-star me-1"></i> You have <?php echo count($pendingFeedback); ?> resolved emergenc<?php echo count($pendingFeedback) === 1 ? 'y' : 'ies'; ?> awaiting feedback. It's required before you can report again.</span>
                    <a href="feedback.php" class="btn btn-sm btn-warning">Give feedback</a>
                </div>
            <?php endif; ?>

            <!-- Stat cards -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-4">
                    <div class="card er-stat">
                        <div class="card-body d-flex align-items-center">
                            <span class="er-stat-icon text-primary me-3"><i class="fa-solid fa-clipboard-list"></i></span>
                            <div><div class="er-stat-value"><?php echo $totalReports; ?></div><div class="er-stat-label">My Reports</div></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-4">
                    <div class="card er-stat">
                        <div class="card-body d-flex align-items-center">
                            <span class="er-stat-icon text-success me-3"><i class="fa-solid fa-circle-check"></i></span>
                            <div><div class="er-stat-value"><?php echo $resolvedCount; ?></div><div class="er-stat-label">Resolved</div></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card er-stat">
                        <div class="card-body d-flex align-items-center">
                            <span class="er-stat-icon text-warning me-3"><i class="fa-solid fa-hourglass-half"></i></span>
                            <div><div class="er-stat-value"><?php echo $pendingCount; ?></div><div class="er-stat-label">Pending</div></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <!-- Reports table -->
                <div class="col-lg-8">
                    <div class="card er-card h-100">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <h5 class="mb-0">My Reported Emergencies</h5>
                            <div class="d-flex gap-2">
                                <input type="search" id="reportSearch" class="form-control form-control-sm" placeholder="Search…" style="width:140px;">
                                <select id="statusFilter" class="form-select form-select-sm" style="width:130px;">
                                    <option value="">All statuses</option>
                                    <option value="pending">Pending</option>
                                    <option value="enroute">Enroute</option>
                                    <option value="resolved">Resolved</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle" id="reportsTable">
                                    <thead>
                                        <tr>
                                            <th>#</th><th>Location</th><th>Issue</th><th>Severity</th>
                                            <th>Reported</th><th>Status</th><th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if (empty($myIncidents)): ?>
                                        <tr><td colspan="7" class="text-center text-muted py-5">
                                            <i class="fa-solid fa-inbox fa-2x d-block mb-2 opacity-50"></i>
                                            You haven't reported any emergencies yet.<br>
                                            <a href="emergency_form.php" class="btn btn-sm btn-brand mt-2">Report one now</a>
                                        </td></tr>
                                    <?php else: foreach ($myIncidents as $row): ?>
                                        <tr>
                                            <th scope="row"><?php echo (int)$row['alert_id']; ?></th>
                                            <td>
                                                <?php echo htmlspecialchars($loc($row)); ?>
                                                <?php if (!empty($row['latitude']) && !empty($row['longitude'])): ?>
                                                    <a class="d-block small" target="_blank" rel="noopener" href="https://www.google.com/maps?q=<?php echo $row['latitude']; ?>,<?php echo $row['longitude']; ?>">📍 Map</a>
                                                <?php endif; ?>
                                            </td>
                                            <td><span class="badge badge-soft-danger"><?php echo htmlspecialchars($row['category_name'] ?? 'Emergency'); ?></span></td>
                                            <td><span class="badge <?php echo $sevBadge($row['severity'] ?? ''); ?>"><?php echo htmlspecialchars($row['severity'] ?? 'n/a'); ?></span></td>
                                            <td class="small"><?php echo htmlspecialchars($row['alert_time'] ?? ''); ?></td>
                                            <td><span class="badge <?php echo $badgeClass($row['alert_status']); ?>"><?php echo htmlspecialchars($row['alert_status'] ?? 'pending'); ?></span></td>
                                            <td><a class="btn btn-sm btn-outline-primary" href="incident_view.php?id=<?php echo (int)$row['alert_id']; ?>">Open</a></td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-muted small mt-2">Showing <?php echo $totalReports; ?> report<?php echo $totalReports === 1 ? '' : 's'; ?>.</div>
                        </div>
                    </div>
                </div>

                <!-- Recent activity -->
                <div class="col-lg-4">
                    <div class="card er-card h-100">
                        <div class="card-header"><h5 class="mb-0">Recent Activity</h5></div>
                        <div class="card-body">
                            <?php if (empty($myIncidents)): ?>
                                <p class="text-muted mb-0">Your reported emergencies will appear here.</p>
                            <?php else: foreach (array_slice($myIncidents, 0, 6) as $note): ?>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <span class="er-icon-badge" style="width:40px;height:40px;font-size:1rem;margin:0;"><i class="fa-solid fa-triangle-exclamation"></i></span>
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small"><?php echo htmlspecialchars($note['category_name'] ?? 'Emergency'); ?></div>
                                        <div class="text-muted small"><?php echo htmlspecialchars($note['lga_name'] ?? ''); ?></div>
                                    </div>
                                    <span class="text-muted small"><?php echo htmlspecialchars(substr($note['alert_time'] ?? '', 0, 10)); ?></span>
                                </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="text-center text-muted small mt-4">&copy; <?php echo date('Y'); ?> Eko Response. All rights reserved.</footer>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
                if (r.children.length < 6) return;
                var text = r.innerText.toLowerCase();
                var status = (r.children[5].innerText || '').toLowerCase();
                r.style.display = (text.indexOf(q) !== -1 && (s === '' || status.indexOf(s) !== -1)) ? '' : 'none';
            });
        }
        if (search) search.addEventListener('input', apply);
        if (filter) filter.addEventListener('change', apply);
    })();
</script>
</body>
</html>
