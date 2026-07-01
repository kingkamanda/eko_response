<?php
session_start();
require_once "guard.php";
require_once "classes/Staff.php";

$staffObj = new Staff();
$me = $staffObj->current($_SESSION['staffonline']);
if (!$me) { header("location: logout.php"); exit(); }

// Responders don't manage the whole queue — send them to their assignments.
if ($me['role'] === 'responder') { header("location: dashboard.php"); exit(); }

$agencyId = $me['agency_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alert_id = filter_input(INPUT_POST, 'alert_id', FILTER_VALIDATE_INT);
    $action   = $_POST['action'] ?? '';
    if ($alert_id && $action === 'assign') {
        $staffObj->assign_emergency($alert_id, filter_input(INPUT_POST, 'staff_id', FILTER_VALIDATE_INT) ?: null);
        $_SESSION['ag_feedback'] = "Assignment updated for emergency #$alert_id.";
    } elseif ($alert_id && $action === 'status') {
        $status = $_POST['status'] ?? '';
        if (in_array($status, ['pending', 'enroute', 'resolved'], true)) {
            $staffObj->add_response($alert_id, $_SESSION['staffonline'], $status, 'Status set to ' . $status);
            $_SESSION['ag_feedback'] = "Emergency #$alert_id marked $status.";
        }
    }
    header("location: emergencies.php");
    exit();
}

$staffRole  = $me['role'];
$agencyName = $me['agency_name'] ?? 'Agency';
$rows       = $staffObj->fetch_agency_emergencies($agencyId);
$responders = $staffObj->fetch_responders($agencyId);
$feedback   = $_SESSION['ag_feedback'] ?? null;
unset($_SESSION['ag_feedback']);

$badge = function ($s) {
    switch (strtolower((string) $s)) {
        case 'resolved': return 'bg-success';
        case 'enroute':  return 'bg-warning text-dark';
        case 'severe':   return 'bg-danger';
        default:         return 'bg-secondary';
    }
};
$pageTitle = 'Emergencies - Eko Response';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require "partials/head.php"; ?></head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'emergencies'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 px-4 py-4">
            <h3 class="mb-3">Emergencies &mdash; <?php echo htmlspecialchars($agencyName); ?></h3>
            <?php if ($feedback): ?><div class="alert alert-success"><?php echo htmlspecialchars($feedback); ?></div><?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr><th>#</th><th>Type</th><th>Location</th><th>Status</th><th>Assign responder</th><th>Set status</th><th></th></tr>
                        </thead>
                        <tbody>
                        <?php if (empty($rows)): ?>
                            <tr><td colspan="7" class="text-center text-muted py-4">No emergencies for your agency yet.</td></tr>
                        <?php else: foreach ($rows as $e): ?>
                            <tr>
                                <th scope="row"><?php echo (int)$e['alert_id']; ?></th>
                                <td><?php echo htmlspecialchars($e['category_name']); ?></td>
                                <td><?php echo htmlspecialchars(trim(($e['user_location'] ?? '') . ' ' . ($e['lga_name'] ? '(' . $e['lga_name'] . ')' : ''))); ?></td>
                                <td><span class="badge <?php echo $badge($e['alert_status']); ?>"><?php echo htmlspecialchars($e['alert_status'] ?? 'pending'); ?></span></td>
                                <td>
                                    <form method="post" class="d-flex gap-1">
                                        <input type="hidden" name="action" value="assign">
                                        <input type="hidden" name="alert_id" value="<?php echo (int)$e['alert_id']; ?>">
                                        <select name="staff_id" class="form-select form-select-sm" style="min-width:130px;">
                                            <option value="">— unassigned —</option>
                                            <?php foreach ($responders as $r): ?>
                                                <option value="<?php echo $r['staff_id']; ?>" <?php echo ((int)$e['assigned_staff_id'] === (int)$r['staff_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($r['fullname']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button class="btn btn-sm btn-outline-primary">Set</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="post" class="d-flex gap-1">
                                        <input type="hidden" name="action" value="status">
                                        <input type="hidden" name="alert_id" value="<?php echo (int)$e['alert_id']; ?>">
                                        <select name="status" class="form-select form-select-sm" style="min-width:110px;">
                                            <?php foreach (['pending','enroute','resolved'] as $opt): ?>
                                                <option value="<?php echo $opt; ?>" <?php echo strtolower((string)$e['alert_status']) === $opt ? 'selected' : ''; ?>><?php echo ucfirst($opt); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button class="btn btn-sm btn-primary">Save</button>
                                    </form>
                                </td>
                                <td><a class="btn btn-sm btn-outline-secondary" href="emergency_view.php?id=<?php echo (int)$e['alert_id']; ?>">Open</a></td>
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
