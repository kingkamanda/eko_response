<?php
session_start();
require_once "admin_guard.php";
require_once "./classes/Admin.php";

$admin = new Admin();

// Handle actions.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $name   = trim($_POST['category_name'] ?? '');
    $agency = filter_input(INPUT_POST, 'agency_id', FILTER_VALIDATE_INT) ?: null;
    $id     = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);

    if ($action === 'add' && $name !== '') {
        $admin->add_category($name, $agency);
        $_SESSION['cat_feedback'] = "Emergency type \"$name\" added.";
    } elseif ($action === 'edit' && $id && $name !== '') {
        $admin->update_category($id, $name, $agency);
        $_SESSION['cat_feedback'] = "Emergency type updated.";
    } elseif ($action === 'approve' && $id) {
        $admin->set_category_status($id, 'approved');
        $_SESSION['cat_feedback'] = "Request approved and now reportable.";
    } elseif ($action === 'reject' && $id) {
        $admin->set_category_status($id, 'rejected');
        $_SESSION['cat_feedback'] = "Request rejected.";
    } elseif ($action === 'delete' && $id) {
        $admin->delete_category($id);
        $_SESSION['cat_feedback'] = "Emergency type deleted.";
    }
    header("location: manage_categories.php");
    exit();
}

$categories   = $admin->fetch_categories();
$agencies     = $admin->fetch_agencies();
$pendingCount = $admin->count_pending_categories();
$feedback     = $_SESSION['cat_feedback'] ?? null;
unset($_SESSION['cat_feedback']);

$pageTitle = 'Emergency Types - Eko Response';
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require "partials/head.php"; ?></head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'categories'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 px-4 py-4">
            <h3 class="mb-4">Emergency Types &amp; Responsible Agencies</h3>

            <?php if ($feedback): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($feedback); ?></div>
            <?php endif; ?>

            <!-- Add new type -->
            <div class="card shadow-sm mb-4">
                <div class="card-header"><h5 class="mb-0">Add a new emergency type</h5></div>
                <div class="card-body">
                    <form method="post" class="row g-2 align-items-end">
                        <input type="hidden" name="action" value="add">
                        <div class="col-md-5">
                            <label class="form-label">Emergency type (e.g. Robbery)</label>
                            <input type="text" name="category_name" class="form-control" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Responsible agency</label>
                            <select name="agency_id" class="form-select">
                                <option value="">— none —</option>
                                <?php foreach ($agencies as $a): ?>
                                    <option value="<?php echo $a['agency_id']; ?>">
                                        <?php echo htmlspecialchars($a['agency_name'] . ' (' . $a['agency_type'] . ')'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100">Add</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Existing types -->
            <div class="card shadow-sm">
                <div class="card-header"><h5 class="mb-0">All emergency types</h5></div>
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Type</th><th>Responsible Agency</th><th>Status</th>
                                <th>Requested by</th><th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($categories as $c): ?>
                            <tr>
                                <td>
                                    <form method="post" class="d-flex gap-1 align-items-center">
                                        <input type="hidden" name="action" value="edit">
                                        <input type="hidden" name="category_id" value="<?php echo $c['category_id']; ?>">
                                        <input type="text" name="category_name" class="form-control form-control-sm"
                                               value="<?php echo htmlspecialchars($c['category_name']); ?>" style="min-width:140px;">
                                </td>
                                <td>
                                        <select name="agency_id" class="form-select form-select-sm" style="min-width:160px;">
                                            <option value="">— none —</option>
                                            <?php foreach ($agencies as $a): ?>
                                                <option value="<?php echo $a['agency_id']; ?>" <?php echo ((int)$c['agency_id'] === (int)$a['agency_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($a['agency_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                </td>
                                <td>
                                    <?php
                                        $st = $c['approval_status'] ?? 'approved';
                                        $cls = $st === 'approved' ? 'bg-success' : ($st === 'pending' ? 'bg-warning text-dark' : 'bg-secondary');
                                    ?>
                                    <span class="badge <?php echo $cls; ?>"><?php echo htmlspecialchars($st); ?></span>
                                </td>
                                <td><?php echo htmlspecialchars($c['requester'] ?? '—'); ?></td>
                                <td class="text-nowrap">
                                        <button class="btn btn-outline-primary btn-sm">Save</button>
                                    </form>
                                    <?php if (($c['approval_status'] ?? '') === 'pending'): ?>
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="action" value="approve">
                                            <input type="hidden" name="category_id" value="<?php echo $c['category_id']; ?>">
                                            <button class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form method="post" class="d-inline">
                                            <input type="hidden" name="action" value="reject">
                                            <input type="hidden" name="category_id" value="<?php echo $c['category_id']; ?>">
                                            <button class="btn btn-warning btn-sm">Reject</button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="post" class="d-inline" onsubmit="return confirm('Delete this emergency type?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="category_id" value="<?php echo $c['category_id']; ?>">
                                        <button class="btn btn-outline-danger btn-sm">Delete</button>
                                    </form>
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
<script src="./assets/static/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
