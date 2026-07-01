<?php
session_start();
require_once "admin_guard.php";
require_once "./classes/Admin.php";

$admin = new Admin();

// Handle status updates and flagging.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alert_id = filter_input(INPUT_POST, 'alert_id', FILTER_VALIDATE_INT);
    $action   = $_POST['action'] ?? 'status';
    if ($alert_id && $action === 'status' && isset($_POST['status'])) {
        if (in_array($_POST['status'], ['pending', 'enroute', 'resolved'], true)) {
            $admin->update_emergency_status($alert_id, $_POST['status']);
            $_SESSION['emg_feedback'] = "Emergency #$alert_id marked as {$_POST['status']}.";
        }
    } elseif ($alert_id && $action === 'flag') {
        $admin->flag_incident($alert_id, trim($_POST['flag_reason'] ?? 'Flagged for review'));
        $_SESSION['emg_feedback'] = "Emergency #$alert_id flagged.";
    } elseif ($alert_id && $action === 'unflag') {
        $admin->unflag_incident($alert_id);
        $_SESSION['emg_feedback'] = "Emergency #$alert_id unflagged.";
    }
    header("location: manage_emergencies.php");
    exit();
}

$emergencies = $admin->fetch_emergencies();
$feedback = $_SESSION['emg_feedback'] ?? null;
unset($_SESSION['emg_feedback']);

$badgeClass = function ($status) {
    switch (strtolower((string) $status)) {
        case 'resolved': return 'bg-success';
        case 'enroute':  return 'bg-warning text-dark';
        default:         return 'bg-secondary';
    }
};
$pendingCount = $admin->count_pending_categories();
$pageTitle = 'Manage Emergencies - Eko Response';
?>
<!DOCTYPE html>
<html lang="en">

<head><?php require "partials/head.php"; ?></head>

<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'emergencies'; require "partials/sidebar.php"; ?>

        <main class="col-md-10 er-shell px-3 px-md-4 py-4">
            <h3 class="mb-4">Manage Emergencies</h3>

            <?php if ($feedback): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($feedback); ?></div>
            <?php endif; ?>

            <div class="card er-card">
                <div class="card-body table-responsive">
                    <table class="table er-table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Reporter</th>
                                <th>Type</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Reported</th>
                                <th>Status</th>
                                <th>Update</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($emergencies)): ?>
                            <tr><td colspan="8" class="text-center text-muted py-4">No emergencies reported yet.</td></tr>
                        <?php else: foreach ($emergencies as $e): ?>
                            <tr>
                                <th scope="row">
                                    <?php echo (int) $e['alert_id']; ?>
                                    <?php if (!empty($e['flagged'])): ?><span class="d-block badge bg-danger" title="<?php echo htmlspecialchars($e['flag_reason'] ?? ''); ?>">⚑ flagged</span><?php endif; ?>
                                </th>
                                <td><?php echo htmlspecialchars($e['reporter'] ?? $e['user_fullname'] ?? 'Unknown'); ?></td>
                                <td><?php echo htmlspecialchars($e['category_name'] ?? '—'); ?></td>
                                <td><?php echo htmlspecialchars($e['user_phone'] ?? ''); ?></td>
                                <td>
                                    <?php echo htmlspecialchars(trim(($e['user_location'] ?? '') . ' ' . ($e['lga_name'] ? '(' . $e['lga_name'] . ')' : ''))); ?>
                                    <span class="d-block small">
                                        <?php if (!empty($e['latitude']) && !empty($e['longitude'])): ?>
                                            <a target="_blank" rel="noopener" href="https://www.google.com/maps?q=<?php echo $e['latitude']; ?>,<?php echo $e['longitude']; ?>">📍 Map</a>
                                        <?php endif; ?>
                                        <?php if (!empty($e['emergency_alert_image'])): ?>
                                            <a target="_blank" rel="noopener" href="../incident_media/<?php echo htmlspecialchars($e['emergency_alert_image']); ?>">🖼 Image</a>
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($e['alert_time'] ?? ''); ?>
                                    <?php if (!empty($e['severity'])): ?><span class="d-block small text-muted"><?php echo htmlspecialchars($e['severity']); ?></span><?php endif; ?>
                                </td>
                                <td><span class="badge <?php echo $badgeClass($e['alert_status']); ?>"><?php echo htmlspecialchars($e['alert_status'] ?? 'pending'); ?></span></td>
                                <td>
                                    <form action="manage_emergencies.php" method="post" class="d-flex gap-1 mb-1">
                                        <input type="hidden" name="alert_id" value="<?php echo (int) $e['alert_id']; ?>">
                                        <input type="hidden" name="action" value="status">
                                        <select name="status" class="form-select form-select-sm" style="width:auto;">
                                            <?php foreach (['pending', 'enroute', 'resolved'] as $opt): ?>
                                                <option value="<?php echo $opt; ?>" <?php echo (strtolower((string) $e['alert_status']) === $opt) ? 'selected' : ''; ?>>
                                                    <?php echo ucfirst($opt); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                    </form>
                                    <?php if (empty($e['flagged'])): ?>
                                        <form action="manage_emergencies.php" method="post" class="d-flex gap-1">
                                            <input type="hidden" name="alert_id" value="<?php echo (int) $e['alert_id']; ?>">
                                            <input type="hidden" name="action" value="flag">
                                            <input type="text" name="flag_reason" class="form-control form-control-sm" placeholder="reason" style="width:110px;">
                                            <button class="btn btn-outline-danger btn-sm">⚑ Flag</button>
                                        </form>
                                    <?php else: ?>
                                        <form action="manage_emergencies.php" method="post">
                                            <input type="hidden" name="alert_id" value="<?php echo (int) $e['alert_id']; ?>">
                                            <input type="hidden" name="action" value="unflag">
                                            <button class="btn btn-outline-secondary btn-sm">Unflag</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <footer class="text-center text-muted mt-4">
                &copy; <?php echo date('Y'); ?> Eko Response. All Rights Reserved.
            </footer>
        </main>
    </div>
</div>

<script src="./assets/static/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
