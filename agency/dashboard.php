<?php
session_start();
require_once "guard.php";
require_once "classes/Staff.php";

$staffObj = new Staff();
$me = $staffObj->current($_SESSION['staffonline']);
if (!$me) { header("location: logout.php"); exit(); }

// Platform managers/employees have their own cross-agency view.
if (Staff::isPlatform($me['role'])) { header("location: platform.php"); exit(); }

$staffRole  = $me['role'];
$agencyId   = $me['agency_id'];
$agencyName = $me['agency_name'] ?? 'Agency';
$stats      = $staffObj->agency_stats($agencyId);

$isResponder = $staffRole === 'responder';
$rows = $isResponder
    ? $staffObj->fetch_assigned($_SESSION['staffonline'])
    : $staffObj->fetch_agency_emergencies($agencyId);

$badge = function ($s) {
    switch (strtolower((string) $s)) {
        case 'resolved': return 'bg-success';
        case 'enroute':  return 'bg-warning text-dark';
        case 'severe':   return 'bg-danger';
        default:         return 'bg-secondary';
    }
};
$pageTitle = 'Agency Dashboard - Eko Response';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require "partials/head.php"; ?></head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = $isResponder ? 'assigned' : 'dashboard'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 px-4 py-4">
            <h3 class="mb-1">Welcome, <?php echo htmlspecialchars($me['fullname']); ?></h3>
            <p class="text-muted"><?php echo htmlspecialchars($agencyName); ?> &middot;
                <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $staffRole))); ?></p>

            <!-- Stat cards -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="card stat-card shadow-sm text-white bg-primary h-100">
                        <div class="card-body"><h6 class="mb-1">Total Emergencies</h6><h2><?php echo $stats['total']; ?></h2></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card stat-card shadow-sm text-white bg-warning h-100">
                        <div class="card-body"><h6 class="mb-1">Pending</h6><h2><?php echo $stats['pending']; ?></h2></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card stat-card shadow-sm text-white bg-success h-100">
                        <div class="card-body"><h6 class="mb-1">Resolved</h6><h2><?php echo $stats['resolved']; ?></h2></div>
                    </div>
                </div>
                <?php if (!$isResponder): // responders don't see team size ?>
                <div class="col-6 col-md-3">
                    <div class="card stat-card shadow-sm text-white bg-dark h-100">
                        <div class="card-body"><h6 class="mb-1">Staff</h6><h2><?php echo $stats['staff']; ?></h2></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo $isResponder ? 'My assigned emergencies' : 'Emergencies for your agency'; ?></h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th><th>Type</th><th>Reporter</th><th>Location</th>
                                <th>Status</th><?php echo $isResponder ? '' : '<th>Assigned to</th>'; ?><th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($rows)): ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">
                                <?php echo $isResponder ? 'Nothing assigned to you yet.' : 'No emergencies for your agency yet.'; ?>
                            </td></tr>
                        <?php else: foreach ($rows as $e): ?>
                            <tr>
                                <th scope="row"><?php echo (int)$e['alert_id']; ?></th>
                                <td><?php echo htmlspecialchars($e['category_name']); ?></td>
                                <td><?php echo htmlspecialchars($e['reporter'] ?? $e['user_fullname'] ?? '—'); ?></td>
                                <td><?php echo htmlspecialchars(trim(($e['user_location'] ?? '') . ' ' . ($e['lga_name'] ? '(' . $e['lga_name'] . ')' : ''))); ?></td>
                                <td><span class="badge <?php echo $badge($e['alert_status']); ?>"><?php echo htmlspecialchars($e['alert_status'] ?? 'pending'); ?></span></td>
                                <?php if (!$isResponder): ?>
                                    <td><?php echo htmlspecialchars($e['assigned_name'] ?? '—'); ?></td>
                                <?php endif; ?>
                                <td><a class="btn btn-sm btn-outline-primary" href="emergency_view.php?id=<?php echo (int)$e['alert_id']; ?>">Open</a></td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
