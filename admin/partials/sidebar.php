<?php
/**
 * Shared admin sidebar. Set $active (e.g. 'dashboard', 'emergencies',
 * 'categories', 'reports', 'hotzones') before including to highlight the item.
 * Expects $pendingCount (int) optionally, for the approvals badge.
 */
$active = $active ?? '';
$pendingBadge = isset($pendingCount) && $pendingCount > 0
    ? ' <span class="badge bg-danger rounded-pill">' . (int) $pendingCount . '</span>'
    : '';
?>
<nav class="col-md-2 p-0 sidebar">
    <div class="brand"><i class="ri-fire-line"></i> Eko Response</div>
    <a href="admin_dashboard.php" class="<?php echo $active === 'dashboard' ? 'active' : ''; ?>">
        <span class="material-icons align-middle">dashboard</span> Dashboard</a>
    <a href="manage_emergencies.php" class="<?php echo $active === 'emergencies' ? 'active' : ''; ?>">
        <span class="material-icons align-middle">warning</span> Manage Emergencies</a>
    <a href="manage_categories.php" class="<?php echo $active === 'categories' ? 'active' : ''; ?>">
        <span class="material-icons align-middle">category</span> Emergency Types<?php echo $pendingBadge; ?></a>
    <a href="manage_agencies.php" class="<?php echo $active === 'agencies' ? 'active' : ''; ?>">
        <span class="material-icons align-middle">apartment</span> Agencies</a>
    <a href="manage_platform_staff.php" class="<?php echo $active === 'platform' ? 'active' : ''; ?>">
        <span class="material-icons align-middle">badge</span> Platform Staff</a>
    <a href="reports.php" class="<?php echo $active === 'reports' ? 'active' : ''; ?>">
        <span class="material-icons align-middle">bar_chart</span> Reports</a>
    <a href="hot_zones.php" class="<?php echo $active === 'hotzones' ? 'active' : ''; ?>">
        <span class="material-icons align-middle">local_fire_department</span> Hot Zones</a>
    <a href="support_inbox.php" class="<?php echo $active === 'support' ? 'active' : ''; ?>">
        <span class="material-icons align-middle">forum</span> Support<?php
            echo (isset($supportUnread) && $supportUnread > 0)
                ? ' <span class="badge bg-danger rounded-pill">' . (int) $supportUnread . '</span>' : ''; ?></a>
    <a href="admin_logout.php">
        <span class="material-icons align-middle">logout</span> Logout</a>
</nav>
