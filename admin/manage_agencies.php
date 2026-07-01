<?php
session_start();
require_once "admin_guard.php";
require_once "./classes/Admin.php";

$admin = new Admin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $name   = trim($_POST['agency_name'] ?? '');
    $type   = $_POST['agency_type'] ?? 'other';
    $phone  = trim($_POST['agency_phone'] ?? '');
    $state  = filter_input(INPUT_POST, 'state_id', FILTER_VALIDATE_INT) ?: null;
    $id     = filter_input(INPUT_POST, 'agency_id', FILTER_VALIDATE_INT);

    if ($action === 'add' && $name !== '') {
        $admin->add_agency($name, $type, $phone, $state);
        $_SESSION['ag_feedback'] = "Agency \"$name\" onboarded.";
    } elseif ($action === 'edit' && $id && $name !== '') {
        $admin->update_agency($id, $name, $type, $phone, $state);
        $_SESSION['ag_feedback'] = "Agency updated.";
    } elseif ($action === 'delete' && $id) {
        $admin->delete_agency($id);
        $_SESSION['ag_feedback'] = "Agency removed.";
    }
    header("location: manage_agencies.php");
    exit();
}

$agencies = $admin->fetch_agencies_full();
$states   = $admin->fetch_states();
$pendingCount = $admin->count_pending_categories();
$feedback = $_SESSION['ag_feedback'] ?? null;
unset($_SESSION['ag_feedback']);
$pageTitle = 'Agencies - Eko Response';

$typeOptions = ['police' => 'Police', 'fire' => 'Fire', 'medical' => 'Medical', 'other' => 'Other'];
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require "partials/head.php"; ?></head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'agencies'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 er-shell px-3 px-md-4 py-4">
            <h3 class="mb-3">Agencies</h3>
            <?php if ($feedback): ?><div class="alert alert-success"><?php echo htmlspecialchars($feedback); ?></div><?php endif; ?>

            <div class="card er-card mb-4">
                <div class="card-header"><h5 class="mb-0">Onboard a new agency</h5></div>
                <div class="card-body">
                    <form method="post" class="row g-2 align-items-end">
                        <input type="hidden" name="action" value="add">
                        <div class="col-md-4"><label class="form-label">Agency name</label>
                            <input type="text" name="agency_name" class="form-control" required></div>
                        <div class="col-md-2"><label class="form-label">Type</label>
                            <select name="agency_type" class="form-select">
                                <?php foreach ($typeOptions as $v => $lbl): ?><option value="<?php echo $v; ?>"><?php echo $lbl; ?></option><?php endforeach; ?>
                            </select></div>
                        <div class="col-md-2"><label class="form-label">Phone</label>
                            <input type="text" name="agency_phone" class="form-control"></div>
                        <div class="col-md-3"><label class="form-label">State</label>
                            <select name="state_id" class="form-select">
                                <option value="">— select —</option>
                                <?php foreach ($states as $s): ?><option value="<?php echo $s['state_id']; ?>"><?php echo htmlspecialchars($s['state_name']); ?></option><?php endforeach; ?>
                            </select></div>
                        <div class="col-md-1"><button class="btn btn-primary w-100">Add</button></div>
                    </form>
                </div>
            </div>

            <div class="card er-card">
                <div class="card-header"><h5 class="mb-0">All agencies</h5></div>
                <div class="card-body table-responsive">
                    <table class="table er-table table-hover align-middle">
                        <thead><tr><th>Agency</th><th>Type</th><th>State</th><th>Phone</th><th>Staff</th><th>Actions</th></tr></thead>
                        <tbody>
                        <?php foreach ($agencies as $a): ?>
                            <tr>
                                <td>
                                    <form method="post" class="d-flex gap-1 align-items-center">
                                        <input type="hidden" name="action" value="edit">
                                        <input type="hidden" name="agency_id" value="<?php echo $a['agency_id']; ?>">
                                        <input type="text" name="agency_name" class="form-control form-control-sm" value="<?php echo htmlspecialchars($a['agency_name']); ?>" style="min-width:150px;">
                                </td>
                                <td>
                                        <select name="agency_type" class="form-select form-select-sm">
                                            <?php foreach ($typeOptions as $v => $lbl): ?>
                                                <option value="<?php echo $v; ?>" <?php echo ($a['agency_type'] === $v) ? 'selected' : ''; ?>><?php echo $lbl; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                </td>
                                <td>
                                        <select name="state_id" class="form-select form-select-sm" style="min-width:130px;">
                                            <option value="">—</option>
                                            <?php foreach ($states as $s): ?>
                                                <option value="<?php echo $s['state_id']; ?>" <?php echo ((int)$a['state_id'] === (int)$s['state_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($s['state_name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                </td>
                                <td><input type="text" name="agency_phone" class="form-control form-control-sm" value="<?php echo htmlspecialchars($a['agency_phone'] ?? ''); ?>" style="width:110px;"></td>
                                <td><span class="badge bg-secondary"><?php echo (int)$a['staff_count']; ?></span></td>
                                <td class="text-nowrap">
                                        <button class="btn btn-sm btn-outline-primary">Save</button>
                                    </form>
                                    <form method="post" class="d-inline" onsubmit="return confirm('Remove this agency?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="agency_id" value="<?php echo $a['agency_id']; ?>">
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
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
