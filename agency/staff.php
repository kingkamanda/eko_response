<?php
session_start();
require_once "guard.php";
require_once "classes/Staff.php";

$staffObj = new Staff();
$me = $staffObj->current($_SESSION['staffonline']);
if (!$me) { header("location: logout.php"); exit(); }

// Only agency admins manage staff.
if ($me['role'] !== 'agency_admin') { header("location: dashboard.php"); exit(); }

$agencyId = $me['agency_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $fullname = trim($_POST['fullname'] ?? '');
        $email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? 'employee';
        $phone    = trim($_POST['phone'] ?? '');
        if ($fullname === '' || !$email || strlen($password) < 6) {
            $_SESSION['staff_feedback'] = "Provide a name, valid email, and a password of at least 6 characters.";
        } else {
            [$ok, $msg] = $staffObj->add_staff($fullname, $email, $password, $role, $agencyId, $phone);
            $_SESSION['staff_feedback'] = $msg;
        }
    } elseif ($action === 'toggle') {
        $sid = filter_input(INPUT_POST, 'staff_id', FILTER_VALIDATE_INT);
        $new = $_POST['status'] === 'inactive' ? 'inactive' : 'active';
        if ($sid && $sid !== (int)$me['staff_id']) {
            $staffObj->set_staff_status($sid, $agencyId, $new);
            $_SESSION['staff_feedback'] = "Staff status updated.";
        }
    }
    header("location: staff.php");
    exit();
}

$staffRole  = $me['role'];
$agencyName = $me['agency_name'] ?? 'Agency';
$team       = $staffObj->fetch_staff($agencyId);
$feedback   = $_SESSION['staff_feedback'] ?? null;
unset($_SESSION['staff_feedback']);
$pageTitle = 'Staff - Eko Response';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require "partials/head.php"; ?></head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'staff'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 er-shell px-3 px-md-4 py-4">
            <h3 class="mb-3">Staff &mdash; <?php echo htmlspecialchars($agencyName); ?></h3>
            <?php if ($feedback): ?><div class="alert alert-info"><?php echo htmlspecialchars($feedback); ?></div><?php endif; ?>

            <div class="card er-card mb-4">
                <div class="card-header"><h5 class="mb-0">Add a team member</h5></div>
                <div class="card-body">
                    <form method="post" class="row g-2 align-items-end">
                        <input type="hidden" name="action" value="add">
                        <div class="col-md-3"><label class="form-label">Full name</label>
                            <input type="text" name="fullname" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required></div>
                        <div class="col-md-2"><label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control"></div>
                        <div class="col-md-2"><label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="responder">Responder</option>
                                <option value="employee">Employee</option>
                                <option value="agency_admin">Agency Admin</option>
                            </select></div>
                        <div class="col-md-2"><label class="form-label">Temp password</label>
                            <input type="text" name="password" class="form-control" required></div>
                        <div class="col-12"><button class="btn btn-primary">Add member</button></div>
                    </form>
                </div>
            </div>

            <div class="card er-card">
                <div class="card-header"><h5 class="mb-0">Team</h5></div>
                <div class="card-body table-responsive">
                    <table class="table er-table table-hover align-middle">
                        <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th></th></tr></thead>
                        <tbody>
                        <?php foreach ($team as $s): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($s['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($s['email']); ?></td>
                                <td><?php echo htmlspecialchars($s['phone'] ?? '—'); ?></td>
                                <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars(ucwords(str_replace('_',' ',$s['role']))); ?></span></td>
                                <td>
                                    <?php if ($s['status'] === 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ((int)$s['staff_id'] !== (int)$me['staff_id']): ?>
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="action" value="toggle">
                                            <input type="hidden" name="staff_id" value="<?php echo $s['staff_id']; ?>">
                                            <?php if ($s['status'] === 'active'): ?>
                                                <input type="hidden" name="status" value="inactive">
                                                <button class="btn btn-sm btn-outline-danger">Deactivate</button>
                                            <?php else: ?>
                                                <input type="hidden" name="status" value="active">
                                                <button class="btn btn-sm btn-outline-success">Activate</button>
                                            <?php endif; ?>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted small">You</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
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
