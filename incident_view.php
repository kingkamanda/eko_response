<?php
session_start();
require_once "user_guard.php";
require_once "classes/Emergency.php";

$incident = new Incident();
$user_id  = $_SESSION['useronline'];
$alert_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT)
    ?: filter_input(INPUT_POST, 'alert_id', FILTER_VALIDATE_INT);

// Reporter posts an update to their own incident's timeline.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $alert_id) {
    $note = trim($_POST['note'] ?? '');
    if ($incident->get_user_incident($alert_id, $user_id) && $note !== '') {
        $incident->add_reporter_update($alert_id, $user_id, $note, $_FILES['image'] ?? null);
        $_SESSION['iv_feedback'] = "Your update was added to the timeline.";
    }
    header("location: incident_view.php?id=$alert_id");
    exit();
}

$e = $alert_id ? $incident->get_user_incident($alert_id, $user_id) : null;
$timeline = $e ? $incident->fetch_responses($alert_id) : [];
$ok = $_SESSION['iv_feedback'] ?? null; unset($_SESSION['iv_feedback']);

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
    <title>Incident Detail - Eko Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> body { background:#f8f9fa; } </style>
</head>
<body>
    <?php require_once 'partials/logo.php'; ?>
    <div class="container my-5">
        <?php if (!$e): ?>
            <div class="alert alert-warning">Incident not found.</div>
            <a href="user_dashboard.php" class="btn btn-outline-secondary">Back to dashboard</a>
        <?php else: ?>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3 mb-0">Incident #<?php echo (int)$e['alert_id']; ?> — <?php echo htmlspecialchars($e['category_name'] ?? 'Emergency'); ?></h1>
                <a href="user_dashboard.php" class="btn btn-outline-secondary btn-sm">← Dashboard</a>
            </div>
            <?php if ($ok): ?><div class="alert alert-success"><?php echo htmlspecialchars($ok); ?></div><?php endif; ?>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white"><h5 class="mb-0">Details</h5></div>
                        <div class="card-body">
                            <dl class="row mb-0">
                                <dt class="col-5">Status</dt><dd class="col-7"><span class="badge bg-secondary"><?php echo htmlspecialchars($e['alert_status'] ?? 'pending'); ?></span></dd>
                                <dt class="col-5">Severity</dt><dd class="col-7"><span class="badge <?php echo $sevBadge($e['severity']); ?>"><?php echo htmlspecialchars($e['severity'] ?? 'n/a'); ?></span></dd>
                                <dt class="col-5">Location</dt><dd class="col-7"><?php echo htmlspecialchars(trim(($e['user_location'] ?? '') . ' ' . ($e['lga_name'] ? '(' . $e['lga_name'] . ', ' . ($e['state_name'] ?? '') . ')' : ''))); ?></dd>
                                <dt class="col-5">Reported</dt><dd class="col-7"><?php echo htmlspecialchars($e['alert_time'] ?? '—'); ?></dd>
                                <dt class="col-5">Handling</dt><dd class="col-7"><?php echo htmlspecialchars($e['assigned_name'] ?? 'Awaiting assignment'); ?></dd>
                                <dt class="col-5">Description</dt><dd class="col-7"><?php echo htmlspecialchars($e['alert_desc'] ?? '—'); ?></dd>
                            </dl>
                            <div class="mt-3 d-flex gap-2 flex-wrap">
                                <?php if (!empty($e['emergency_alert_image'])): ?>
                                    <a class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener"
                                       href="incident_media/<?php echo htmlspecialchars($e['emergency_alert_image']); ?>">🖼 View image</a>
                                <?php endif; ?>
                                <?php if (!empty($e['emergency_alert_video'])): ?>
                                    <a class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener"
                                       href="incident_media/<?php echo htmlspecialchars($e['emergency_alert_video']); ?>">🎬 View video</a>
                                <?php endif; ?>
                                <?php if (!empty($e['latitude']) && !empty($e['longitude'])): ?>
                                    <a class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener"
                                       href="https://www.google.com/maps?q=<?php echo $e['latitude']; ?>,<?php echo $e['longitude']; ?>">📍 View on map</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-white"><h5 class="mb-0">Add more information</h5></div>
                        <div class="card-body">
                            <p class="text-muted small">Provide extra details or updates. Responders and the
                                agency will see these on the timeline.</p>
                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="alert_id" value="<?php echo (int)$e['alert_id']; ?>">
                                <div class="mb-3">
                                    <textarea name="note" class="form-control" rows="3" placeholder="e.g. The fire has now reached the second building." required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Attach a photo (optional)</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                                <button class="btn btn-primary">Add update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white"><h5 class="mb-0">Timeline</h5></div>
                <div class="card-body">
                    <?php if (empty($timeline)): ?>
                        <p class="text-muted mb-0">No updates yet.</p>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                        <?php foreach ($timeline as $t): ?>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>
                                        <?php echo $t['status'] ? htmlspecialchars(ucfirst($t['status'])) : 'Update'; ?>
                                        <span class="fw-normal text-muted">by
                                            <?php echo htmlspecialchars($t['staff_name'] ?? $t['reporter_name'] ?? 'you'); ?>
                                        </span>
                                    </strong>
                                    <small class="text-muted"><?php echo htmlspecialchars($t['created_at']); ?></small>
                                </div>
                                <?php if (!empty($t['note'])): ?><div><?php echo htmlspecialchars($t['note']); ?></div><?php endif; ?>
                                <?php if (!empty($t['image'])): ?>
                                    <a target="_blank" rel="noopener" href="incident_media/<?php echo htmlspecialchars($t['image']); ?>">🖼 view attached photo</a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
