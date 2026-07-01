<?php
session_start();
require_once "guard.php";
require_once "classes/Staff.php";

$staffObj = new Staff();
$me = $staffObj->current($_SESSION['staffonline']);
if (!$me) { header("location: logout.php"); exit(); }

$agencyId = $me['agency_id'];
$alert_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)
    ?: filter_input(INPUT_POST, 'alert_id', FILTER_VALIDATE_INT);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $alert_id) {
    $status = $_POST['status'] ?? '';
    $note   = trim($_POST['note'] ?? '');
    $status = in_array($status, ['pending', 'enroute', 'resolved'], true) ? $status : null;
    // Only act if it belongs to this agency.
    if ($staffObj->get_emergency($alert_id, $agencyId)) {
        $staffObj->add_response($alert_id, $_SESSION['staffonline'], $status, $note !== '' ? $note : null, $_FILES['image'] ?? null);
        $_SESSION['ev_feedback'] = "Update recorded.";
    }
    header("location: emergency_view.php?id=$alert_id");
    exit();
}

$e = $alert_id ? $staffObj->get_emergency($alert_id, $agencyId) : null;
if (!$e) {
    $notFound = true;
} else {
    $timeline = $staffObj->fetch_responses($alert_id);
}
$staffRole  = $me['role'];
$agencyName = $me['agency_name'] ?? 'Agency';
$feedback   = $_SESSION['ev_feedback'] ?? null;
unset($_SESSION['ev_feedback']);
$pageTitle = 'Emergency Detail - Eko Response';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require "partials/head.php"; ?></head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = $staffRole === 'responder' ? 'assigned' : 'emergencies'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 er-shell px-3 px-md-4 py-4">
            <?php if (!empty($notFound)): ?>
                <div class="alert alert-warning">Emergency not found, or it isn't handled by your agency.</div>
                <a href="dashboard.php" class="btn btn-outline-secondary">Back</a>
            <?php else: ?>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0">Emergency #<?php echo (int)$e['alert_id']; ?> &mdash; <?php echo htmlspecialchars($e['category_name']); ?></h3>
                    <a href="<?php echo $staffRole === 'responder' ? 'dashboard.php' : 'emergencies.php'; ?>" class="btn btn-outline-secondary btn-sm">← Back</a>
                </div>
                <?php if ($feedback): ?><div class="alert alert-success"><?php echo htmlspecialchars($feedback); ?></div><?php endif; ?>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card er-card h-100">
                            <div class="card-header"><h5 class="mb-0">Details</h5></div>
                            <div class="card-body">
                                <dl class="row mb-0">
                                    <dt class="col-5">Reporter</dt><dd class="col-7"><?php echo htmlspecialchars($e['reporter'] ?? $e['user_fullname'] ?? '—'); ?></dd>
                                    <dt class="col-5">Phone</dt><dd class="col-7"><?php echo htmlspecialchars($e['user_phone'] ?? '—'); ?></dd>
                                    <dt class="col-5">Location</dt><dd class="col-7"><?php echo htmlspecialchars(trim(($e['user_location'] ?? '') . ' ' . ($e['lga_name'] ? '(' . $e['lga_name'] . ', ' . ($e['state_name'] ?? '') . ')' : ''))); ?></dd>
                                    <dt class="col-5">Reported</dt><dd class="col-7"><?php echo htmlspecialchars($e['alert_time'] ?? '—'); ?></dd>
                                    <dt class="col-5">Current status</dt><dd class="col-7"><span class="badge bg-secondary"><?php echo htmlspecialchars($e['alert_status'] ?? 'pending'); ?></span></dd>
                                    <dt class="col-5">Severity</dt><dd class="col-7"><span class="badge bg-danger"><?php echo htmlspecialchars($e['severity'] ?? 'n/a'); ?></span></dd>
                                    <dt class="col-5">Assigned to</dt><dd class="col-7"><?php echo htmlspecialchars($e['assigned_name'] ?? 'Unassigned'); ?></dd>
                                    <dt class="col-5">Description</dt><dd class="col-7"><?php echo htmlspecialchars($e['alert_desc'] ?? '—'); ?></dd>
                                </dl>
                                <div class="mt-3 d-flex gap-2 flex-wrap">
                                    <?php if (!empty($e['emergency_alert_image'])): ?>
                                        <a class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener" href="../incident_media/<?php echo htmlspecialchars($e['emergency_alert_image']); ?>">🖼 View image</a>
                                    <?php endif; ?>
                                    <?php if (!empty($e['emergency_alert_video'])): ?>
                                        <a class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener" href="../incident_media/<?php echo htmlspecialchars($e['emergency_alert_video']); ?>">🎬 View video</a>
                                    <?php endif; ?>
                                    <?php if (!empty($e['latitude']) && !empty($e['longitude'])): ?>
                                        <a class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener" href="https://www.google.com/maps?q=<?php echo $e['latitude']; ?>,<?php echo $e['longitude']; ?>">📍 View on map</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card er-card h-100">
                            <div class="card-header"><h5 class="mb-0">Add response / update status</h5></div>
                            <div class="card-body">
                                <form method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="alert_id" value="<?php echo (int)$e['alert_id']; ?>">
                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="">(no change)</option>
                                            <?php foreach (['pending','enroute','resolved'] as $opt): ?>
                                                <option value="<?php echo $opt; ?>"><?php echo ucfirst($opt); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Note / report</label>
                                        <textarea name="note" class="form-control" rows="3" placeholder="e.g. Team dispatched, ETA 10 minutes"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Attach a photo (optional)</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                    </div>
                                    <button class="btn btn-primary">Record update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card er-card mt-4">
                    <div class="card-header"><h5 class="mb-0">Tracking timeline</h5></div>
                    <div class="card-body">
                        <?php if (empty($timeline)): ?>
                            <p class="text-muted mb-0">No updates recorded yet.</p>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                            <?php foreach ($timeline as $t): ?>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <strong>
                                            <?php echo $t['status'] ? htmlspecialchars(ucfirst($t['status'])) : 'Update'; ?>
                                            <span class="text-muted fw-normal">by
                                                <?php echo htmlspecialchars($t['staff_name'] ?? (($t['reporter_name'] ?? '') !== '' ? $t['reporter_name'] . ' (reporter)' : 'staff')); ?></span>
                                        </strong>
                                        <small class="text-muted"><?php echo htmlspecialchars($t['created_at']); ?></small>
                                    </div>
                                    <?php if (!empty($t['note'])): ?><div><?php echo htmlspecialchars($t['note']); ?></div><?php endif; ?>
                                    <?php if (!empty($t['image'])): ?>
                                        <a target="_blank" rel="noopener" href="../incident_media/<?php echo htmlspecialchars($t['image']); ?>">🖼 view attached photo</a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
