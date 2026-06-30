<?php
session_start();
require_once "admin_guard.php";
require_once "./classes/Admin.php";

$admin = new Admin();

// Handle a status update.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alert_id'], $_POST['status'])) {
    $alert_id = filter_input(INPUT_POST, 'alert_id', FILTER_VALIDATE_INT);
    $status   = $_POST['status'];
    $allowed  = ['pending', 'enroute', 'resolved'];
    if ($alert_id && in_array($status, $allowed, true)) {
        $admin->update_emergency_status($alert_id, $status);
        $_SESSION['emg_feedback'] = "Emergency #$alert_id marked as $status.";
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/static/bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Manage Emergencies - Eko Response</title>
    <style>
        body { background:#f4f6f9; }
        .sidebar { min-height: 100vh; background:#1f2937; }
        .sidebar a { color:#cbd5e1; display:block; padding:.75rem 1.25rem; text-decoration:none; }
        .sidebar a:hover, .sidebar a.active { background:#111827; color:#fff; }
        .sidebar .brand { color:#fff; font-weight:700; padding:1.25rem; font-size:1.2rem; }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 p-0 sidebar">
            <div class="brand"><i class="ri-fire-line"></i> Eko Response</div>
            <a href="admin_dashboard.php"><span class="material-icons align-middle">dashboard</span> Dashboard</a>
            <a href="manage_emergencies.php" class="active"><span class="material-icons align-middle">warning</span> Manage Emergencies</a>
            <a href="admin_logout.php"><span class="material-icons align-middle">logout</span> Logout</a>
        </nav>

        <main class="col-md-10 px-4 py-4">
            <h3 class="mb-4">Manage Emergencies</h3>

            <?php if ($feedback): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($feedback); ?></div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover align-middle">
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
                                <th scope="row"><?php echo (int) $e['alert_id']; ?></th>
                                <td><?php echo htmlspecialchars($e['reporter'] ?? $e['user_fullname'] ?? 'Unknown'); ?></td>
                                <td><?php echo htmlspecialchars($e['category_name'] ?? '—'); ?></td>
                                <td><?php echo htmlspecialchars($e['user_phone'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars(trim(($e['user_location'] ?? '') . ' ' . ($e['lga_name'] ? '(' . $e['lga_name'] . ')' : ''))); ?></td>
                                <td><?php echo htmlspecialchars($e['alert_time'] ?? ''); ?></td>
                                <td><span class="badge <?php echo $badgeClass($e['alert_status']); ?>"><?php echo htmlspecialchars($e['alert_status'] ?? 'pending'); ?></span></td>
                                <td>
                                    <form action="manage_emergencies.php" method="post" class="d-flex gap-1">
                                        <input type="hidden" name="alert_id" value="<?php echo (int) $e['alert_id']; ?>">
                                        <select name="status" class="form-select form-select-sm" style="width:auto;">
                                            <?php foreach (['pending', 'enroute', 'resolved'] as $opt): ?>
                                                <option value="<?php echo $opt; ?>" <?php echo (strtolower((string) $e['alert_status']) === $opt) ? 'selected' : ''; ?>>
                                                    <?php echo ucfirst($opt); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                    </form>
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
