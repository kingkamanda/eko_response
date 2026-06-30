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

$sn = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/static/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/static/dashboard2.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title>Admin Dashboard - Eko Response</title>
    <style>
        body { background:#f4f6f9; }
        .sidebar { min-height: 100vh; background:#1f2937; }
        .sidebar a { color:#cbd5e1; display:block; padding:.75rem 1.25rem; text-decoration:none; }
        .sidebar a:hover, .sidebar a.active { background:#111827; color:#fff; }
        .sidebar .brand { color:#fff; font-weight:700; padding:1.25rem; font-size:1.2rem; }
        .stat-card { border:none; border-radius:.75rem; }
        .stat-card h2 { font-weight:700; }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 p-0 sidebar">
            <div class="brand"><i class="ri-fire-line"></i> Eko Response</div>
            <a href="admin_dashboard.php" class="active"><span class="material-icons align-middle">dashboard</span> Dashboard</a>
            <a href="manage_emergencies.php"><span class="material-icons align-middle">warning</span> Manage Emergencies</a>
            <a href="admin_logout.php"><span class="material-icons align-middle">logout</span> Logout</a>
        </nav>

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
