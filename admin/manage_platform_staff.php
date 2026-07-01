<?php
session_start();
require_once "admin_guard.php";
require_once "./classes/Admin.php";

$admin = new Admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $fullname = trim($_POST['fullname'] ?? '');
        $email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? 'platform_employee';
        $phone    = trim($_POST['phone'] ?? '');
        if ($fullname === '' || !$email || strlen($password) < 6) {
            $_SESSION['ps_feedback'] = "Provide a name, valid email, and a 6+ character password.";
        } else {
            [$ok, $msg] = $admin->add_platform_staff($fullname, $email, $password, $role, $phone);
            $_SESSION['ps_feedback'] = $msg;
        }
    } elseif ($action === 'toggle') {
        $sid = filter_input(INPUT_POST, 'staff_id', FILTER_VALIDATE_INT);
        if ($sid) {
            $admin->set_staff_status($sid, $_POST['status'] === 'inactive' ? 'inactive' : 'active');
            $_SESSION['ps_feedback'] = "Status updated.";
        }
    }
    header("location: manage_platform_staff.php");
    exit();
}

$team = $admin->fetch_platform_staff();
$pendingCount = $admin->count_pending_categories();
$feedback = $_SESSION['ps_feedback'] ?? null;
unset($_SESSION['ps_feedback']);
$pageTitle = 'Platform Staff - Eko Response';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require "partials/head.php"; ?></head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'platform'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 px-4 py-4">
            <h3 class="mb-1">Platform Staff</h3>
            <p class="text-muted">Managers and employees who work across the platform. They can review and
                flag incidents from the <a href="../agency/login.php">staff portal</a>.</p>
            <?php if ($feedback): ?><div class="alert alert-info"><?php echo htmlspecialchars($feedback); ?></div><?php endif; ?>

            <div class="card shadow-sm mb-4">
                <div class="card-header"><h5 class="mb-0">Onboard a manager or employee</h5></div>
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
                                <option value="platform_manager">Manager</option>
                                <option value="platform_employee">Employee</option>
                            </select></div>
                        <div class="col-md-2"><label class="form-label">Temp password</label>
                            <input type="text" name="password" class="form-control" required></div>
                        <div class="col-12"><button class="btn btn-primary">Add</button></div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header"><h5 class="mb-0">Platform team</h5></div>
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th></th></tr></thead>
                        <tbody>
                        <?php if (empty($team)): ?>
                            <tr><td colspan="6" class="text-muted text-center py-3">No platform staff yet.</td></tr>
                        <?php else: foreach ($team as $s): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($s['fullname']); ?></td>
                                <td><?php echo htmlspecialchars($s['email']); ?></td>
                                <td><?php echo htmlspecialchars($s['phone'] ?? '—'); ?></td>
                                <td><span class="badge bg-info text-dark"><?php echo htmlspecialchars(ucwords(str_replace('_',' ',$s['role']))); ?></span></td>
                                <td><?php echo $s['status'] === 'active' ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'; ?></td>
                                <td>
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
<script src="./assets/static/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
