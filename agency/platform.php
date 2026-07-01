<?php
session_start();
require_once "guard.php";
require_once "classes/Staff.php";

$staffObj = new Staff();
$me = $staffObj->current($_SESSION['staffonline']);
if (!$me) { header("location: logout.php"); exit(); }

// Platform-only page.
if (!Staff::isPlatform($me['role'])) { header("location: dashboard.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alert_id = filter_input(INPUT_POST, 'alert_id', FILTER_VALIDATE_INT);
    $action   = $_POST['action'] ?? '';
    if ($alert_id && $action === 'flag') {
        $staffObj->flag_incident($alert_id, trim($_POST['flag_reason'] ?? 'Flagged for review'));
        $_SESSION['pf_feedback'] = "Emergency #$alert_id flagged.";
    } elseif ($alert_id && $action === 'unflag') {
        $staffObj->unflag_incident($alert_id);
        $_SESSION['pf_feedback'] = "Emergency #$alert_id unflagged.";
    }
    header("location: platform.php");
    exit();
}

$staffRole  = $me['role'];
$agencyName = 'Platform';
$stats      = $staffObj->platform_stats();
$rows       = $staffObj->fetch_all_emergencies();
$feedback   = $_SESSION['pf_feedback'] ?? null;
unset($_SESSION['pf_feedback']);

$badge = function ($s) {
    switch (strtolower((string) $s)) {
        case 'resolved': return 'bg-success';
        case 'enroute':  return 'bg-warning text-dark';
        default:         return 'bg-secondary';
    }
};
$pageTitle = 'Platform - Eko Response';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require "partials/head.php"; ?></head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'platform'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 er-shell px-3 px-md-4 py-4">
            <h3 class="mb-1">Platform Overview</h3>
            <p class="text-muted">All emergencies across every agency. Flag anything unresponded or unresolved for review.</p>
            <?php if ($feedback): ?><div class="alert alert-success"><?php echo htmlspecialchars($feedback); ?></div><?php endif; ?>

            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3"><div class="card er-stat h-100"><div class="card-body d-flex align-items-center"><span class="er-stat-icon text-primary me-3"><i class="fa-solid fa-layer-group"></i></span><div><div class="er-stat-value"><?php echo $stats['total']; ?></div><div class="er-stat-label">Total</div></div></div></div></div>
                <div class="col-6 col-md-3"><div class="card er-stat h-100"><div class="card-body d-flex align-items-center"><span class="er-stat-icon text-warning me-3"><i class="fa-solid fa-hourglass-half"></i></span><div><div class="er-stat-value"><?php echo $stats['pending']; ?></div><div class="er-stat-label">Pending</div></div></div></div></div>
                <div class="col-6 col-md-3"><div class="card er-stat h-100"><div class="card-body d-flex align-items-center"><span class="er-stat-icon text-success me-3"><i class="fa-solid fa-circle-check"></i></span><div><div class="er-stat-value"><?php echo $stats['resolved']; ?></div><div class="er-stat-label">Resolved</div></div></div></div></div>
                <div class="col-6 col-md-3"><div class="card er-stat h-100"><div class="card-body d-flex align-items-center"><span class="er-stat-icon text-danger me-3"><i class="fa-solid fa-flag"></i></span><div><div class="er-stat-value"><?php echo $stats['flagged']; ?></div><div class="er-stat-label">Flagged</div></div></div></div></div>
            </div>

            <div class="card er-card">
                <div class="card-header"><h5 class="mb-0">All emergencies</h5></div>
                <div class="card-body table-responsive">
                    <table class="table er-table table-hover align-middle">
                        <thead><tr><th>#</th><th>Type</th><th>Agency</th><th>Location</th><th>Status</th><th>Assigned</th><th>Flag</th></tr></thead>
                        <tbody>
                        <?php if (empty($rows)): ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">No emergencies yet.</td></tr>
                        <?php else: foreach ($rows as $e): ?>
                            <tr class="<?php echo !empty($e['flagged']) ? 'table-danger' : ''; ?>">
                                <th scope="row"><?php echo (int)$e['alert_id']; ?></th>
                                <td><?php echo htmlspecialchars($e['category_name'] ?? '—'); ?></td>
                                <td><?php echo htmlspecialchars($e['agency_name'] ?? '—'); ?></td>
                                <td><?php echo htmlspecialchars(trim(($e['user_location'] ?? '') . ' ' . ($e['lga_name'] ? '(' . $e['lga_name'] . ')' : ''))); ?></td>
                                <td><span class="badge <?php echo $badge($e['alert_status']); ?>"><?php echo htmlspecialchars($e['alert_status'] ?? 'pending'); ?></span></td>
                                <td><?php echo htmlspecialchars($e['assigned_name'] ?? '—'); ?></td>
                                <td>
                                    <?php if (empty($e['flagged'])): ?>
                                        <form method="post" class="d-flex gap-1">
                                            <input type="hidden" name="alert_id" value="<?php echo (int)$e['alert_id']; ?>">
                                            <input type="hidden" name="action" value="flag">
                                            <input type="text" name="flag_reason" class="form-control form-control-sm" placeholder="reason" style="width:110px;">
                                            <button class="btn btn-outline-danger btn-sm">⚑</button>
                                        </form>
                                    <?php else: ?>
                                        <form method="post">
                                            <input type="hidden" name="alert_id" value="<?php echo (int)$e['alert_id']; ?>">
                                            <input type="hidden" name="action" value="unflag">
                                            <button class="btn btn-outline-secondary btn-sm" title="<?php echo htmlspecialchars($e['flag_reason'] ?? ''); ?>">Unflag</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
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
