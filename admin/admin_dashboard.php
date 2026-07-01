<?php
session_start();
require_once "admin_guard.php";
require_once "./classes/Admin.php";

$admin1 = new Admin();
$users  = $admin1->fetch_users();

$totalUsers       = $admin1->count_users();
$totalEmergencies = $admin1->count_emergencies();
$resolved         = $admin1->count_emergencies_by_status('resolved');
$pending          = $totalEmergencies - $resolved;

$feedback = $_SESSION['admin_feedback'] ?? null;
unset($_SESSION['admin_feedback']);
$pendingCount = $admin1->count_pending_categories();

$sn = 1;
$pageTitle = 'Admin Dashboard - Eko Response';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "partials/head.php"; ?>
    <link rel="stylesheet" type="text/css" href="./assets/static/dashboard2.css">
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'dashboard'; require "partials/sidebar.php"; ?>

        <!-- Content -->
        <main class="col-md-10 px-4 py-4">
            <h3 class="mb-4">Admin Dashboard</h3>

            <?php if ($feedback): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($feedback); ?></div>
            <?php endif; ?>

            <!-- Stats -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card stat-card shadow-sm text-white bg-primary">
                        <div class="card-body"><h6>Total Users</h6><h2><?php echo $totalUsers; ?></h2></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card shadow-sm text-white bg-danger">
                        <div class="card-body"><h6>Total Emergencies</h6><h2><?php echo $totalEmergencies; ?></h2></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card shadow-sm text-white bg-warning">
                        <div class="card-body"><h6>Pending</h6><h2><?php echo $pending; ?></h2></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card shadow-sm text-white bg-success">
                        <div class="card-body"><h6>Resolved</h6><h2><?php echo $resolved; ?></h2></div>
                    </div>
                </div>
            </div>

            <!-- Users table -->
            <div class="card shadow-sm">
                <div class="card-header"><h5 class="mb-0">Manage Users</h5></div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Gender</th>
                                <th>Registered</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($users)): ?>
                            <tr><td colspan="8" class="text-center text-muted py-4">No users registered yet.</td></tr>
                        <?php else: foreach ($users as $u): ?>
                            <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo htmlspecialchars($u['user_fullname']); ?></td>
                                <td><?php echo htmlspecialchars($u['user_email']); ?></td>
                                <td><?php echo htmlspecialchars($u['user_phone']); ?></td>
                                <td><?php echo htmlspecialchars($u['user_gender']); ?></td>
                                <td><?php echo htmlspecialchars($u['user_date_registered']); ?></td>
                                <td>
                                    <?php if (($u['deactivate_status'] ?? '') === 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="delete.php" method="post" class="d-inline">
                                        <input type="hidden" name="user_id" value="<?php echo $u['user_id']; ?>">
                                        <?php if (($u['deactivate_status'] ?? '') === 'active'): ?>
                                            <button type="submit" name="action" value="deactivate" class="btn btn-danger btn-sm">Deactivate</button>
                                        <?php else: ?>
                                            <button type="submit" name="action" value="activate" class="btn btn-success btn-sm">Activate</button>
                                        <?php endif; ?>
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
