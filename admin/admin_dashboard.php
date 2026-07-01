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
$supportUnread = $admin1->support_unread_total();

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
        <main class="col-md-10 er-shell px-3 px-md-4 py-4">
            <h3 class="er-page-title mb-4">Admin Dashboard</h3>

            <?php if ($feedback): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($feedback); ?></div>
            <?php endif; ?>

            <!-- Stats -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-lg-3">
                    <div class="card er-stat">
                        <div class="card-body d-flex align-items-center">
                            <span class="er-stat-icon text-primary me-3"><i class="fa-solid fa-users"></i></span>
                            <div><div class="er-stat-value"><?php echo $totalUsers; ?></div><div class="er-stat-label">Total Users</div></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card er-stat">
                        <div class="card-body d-flex align-items-center">
                            <span class="er-stat-icon text-danger me-3"><i class="fa-solid fa-triangle-exclamation"></i></span>
                            <div><div class="er-stat-value"><?php echo $totalEmergencies; ?></div><div class="er-stat-label">Emergencies</div></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card er-stat">
                        <div class="card-body d-flex align-items-center">
                            <span class="er-stat-icon text-warning me-3"><i class="fa-solid fa-hourglass-half"></i></span>
                            <div><div class="er-stat-value"><?php echo $pending; ?></div><div class="er-stat-label">Pending</div></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card er-stat">
                        <div class="card-body d-flex align-items-center">
                            <span class="er-stat-icon text-success me-3"><i class="fa-solid fa-circle-check"></i></span>
                            <div><div class="er-stat-value"><?php echo $resolved; ?></div><div class="er-stat-label">Resolved</div></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users table -->
            <div class="card er-card">
                <div class="card-header"><h5 class="mb-0">Manage Users</h5></div>
                <div class="card-body table-responsive">
                    <table class="table er-table table-hover align-middle">
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
