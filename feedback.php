<?php
session_start();
require_once "user_guard.php";
require_once "classes/Emergency.php";

$incident = new Incident();
$user_id  = $_SESSION['useronline'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alert_id = filter_input(INPUT_POST, 'alert_id', FILTER_VALIDATE_INT);
    $rating   = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $comment  = trim($_POST['comment'] ?? '');
    if ($alert_id && $rating) {
        $incident->add_feedback($user_id, $alert_id, $rating, $comment);
        $_SESSION['fb_feedback'] = "Thank you for your feedback!";
    }
    header("location: feedback.php");
    exit();
}

$pending  = $incident->pending_feedback($user_id);
$msg      = $_SESSION['errormsg'] ?? null;   unset($_SESSION['errormsg']);
$ok       = $_SESSION['fb_feedback'] ?? null; unset($_SESSION['fb_feedback']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Eko Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> body { background:#f8f9fa; } </style>
</head>
<body>
    <?php require_once 'partials/logo.php'; ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="mb-3">Your feedback</h1>

                <?php if ($msg): ?><div class="alert alert-warning"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
                <?php if ($ok): ?><div class="alert alert-success"><?php echo htmlspecialchars($ok); ?></div><?php endif; ?>

                <?php if (empty($pending)): ?>
                    <div class="alert alert-info">You're all caught up — no feedback pending.</div>
                    <a href="emergency_form.php" class="btn btn-danger">Report an emergency</a>
                    <a href="user_dashboard.php" class="btn btn-outline-secondary">Back to dashboard</a>
                <?php else: ?>
                    <p class="text-muted">Please rate how these resolved emergencies were handled. Feedback is
                        required before you can report a new emergency.</p>
                    <?php foreach ($pending as $p): ?>
                        <div class="card shadow-sm mb-3">
                            <div class="card-body">
                                <h5 class="card-title">
                                    #<?php echo (int)$p['alert_id']; ?> &mdash; <?php echo htmlspecialchars($p['category_name'] ?? 'Emergency'); ?>
                                </h5>
                                <p class="text-muted mb-2"><?php echo htmlspecialchars(trim(($p['user_location'] ?? '') . ' ' . ($p['lga_name'] ? '(' . $p['lga_name'] . ')' : ''))); ?></p>
                                <form method="post" class="row g-2 align-items-end">
                                    <input type="hidden" name="alert_id" value="<?php echo (int)$p['alert_id']; ?>">
                                    <div class="col-md-3">
                                        <label class="form-label">Rating</label>
                                        <select name="rating" class="form-select" required>
                                            <option value="">Rate…</option>
                                            <option value="5">★★★★★ Excellent</option>
                                            <option value="4">★★★★ Good</option>
                                            <option value="3">★★★ Okay</option>
                                            <option value="2">★★ Poor</option>
                                            <option value="1">★ Very poor</option>
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        <label class="form-label">Comment (optional)</label>
                                        <input type="text" name="comment" class="form-control" placeholder="How did it go?">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary w-100">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
