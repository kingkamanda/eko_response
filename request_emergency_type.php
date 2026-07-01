<?php
session_start();
require_once "user_guard.php";
require_once "classes/Emergency.php";

$incident = new Incident();
$user_id  = $_SESSION['useronline'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name   = trim($_POST['category_name'] ?? '');
    $agency = filter_input(INPUT_POST, 'agency_id', FILTER_VALIDATE_INT) ?: null;
    if ($name !== '') {
        $incident->request_category($name, $agency, $user_id);
        $_SESSION['req_feedback'] = "Thanks! \"$name\" was submitted for admin approval.";
    } else {
        $_SESSION['req_feedback'] = "Please enter an emergency type.";
    }
    header("location: request_emergency_type.php");
    exit();
}

$agencies = $incident->fetch_agencies();
$requests = $incident->fetch_user_category_requests($user_id);
$feedback = $_SESSION['req_feedback'] ?? null;
unset($_SESSION['req_feedback']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request an Emergency Type - Eko Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> body { background:#f8f9fa; } </style>
</head>
<body>
    <?php require_once 'partials/logo.php'; ?>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <h1 class="mb-3">Request a new emergency type</h1>
                <p class="text-muted">Is a kind of emergency missing from the report form? Suggest it and
                    an administrator will review it. Once approved, everyone can report it.</p>

                <?php if ($feedback): ?>
                    <div class="alert alert-info"><?php echo htmlspecialchars($feedback); ?></div>
                <?php endif; ?>

                <form method="post" class="card card-body shadow-sm mb-4">
                    <div class="mb-3">
                        <label class="form-label">Emergency type</label>
                        <input type="text" name="category_name" class="form-control"
                               placeholder="e.g. Oil Spill" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Which agency should handle it? (optional)</label>
                        <select name="agency_id" class="form-select">
                            <option value="">Not sure</option>
                            <?php foreach ($agencies as $a): ?>
                                <option value="<?php echo $a['agency_id']; ?>">
                                    <?php echo htmlspecialchars($a['agency_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-danger">Submit for approval</button>
                </form>

                <h5>Your requests</h5>
                <table class="table table-striped">
                    <thead><tr><th>Type</th><th>Suggested agency</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php if (empty($requests)): ?>
                        <tr><td colspan="3" class="text-muted">You haven't requested any yet.</td></tr>
                    <?php else: foreach ($requests as $r):
                        $st = $r['approval_status'] ?? 'pending';
                        $cls = $st === 'approved' ? 'bg-success' : ($st === 'pending' ? 'bg-warning text-dark' : 'bg-secondary');
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($r['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($r['agency_name'] ?? '—'); ?></td>
                            <td><span class="badge <?php echo $cls; ?>"><?php echo htmlspecialchars($st); ?></span></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>

                <a href="user_dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
