<?php
/**
 * Role-aware agency sidebar. Expects $active, $staffRole, $agencyName.
 */
$active     = $active ?? '';
$staffRole  = $staffRole ?? ($_SESSION['staffrole'] ?? '');
$agencyName = $agencyName ?? 'Agency';
$roleLabel  = ucwords(str_replace('_', ' ', $staffRole));
$isPlatform = in_array($staffRole, ['platform_manager', 'platform_employee'], true);
?>
<nav class="col-md-2 p-0 er-side">
    <div class="er-brand">
        <i class="fa-solid fa-truck-medical text-danger"></i> Eko Response
        <small><?php echo htmlspecialchars($agencyName); ?> &middot; <?php echo htmlspecialchars($roleLabel); ?></small>
    </div>

    <?php if ($isPlatform): ?>
        <a href="platform.php" class="<?php echo $active === 'platform' ? 'active' : ''; ?>">
            <span class="material-icons align-middle">public</span> All Emergencies</a>
        <a href="hotzones.php" class="<?php echo $active === 'hotzones' ? 'active' : ''; ?>">
            <span class="material-icons align-middle">local_fire_department</span> Hot Zones</a>
        <a href="logout.php"><span class="material-icons align-middle">logout</span> Logout</a>
    </nav>
    <?php return; endif; ?>

    <a href="dashboard.php" class="<?php echo $active === 'dashboard' ? 'active' : ''; ?>">
        <span class="material-icons align-middle">dashboard</span> Dashboard</a>

    <?php if ($staffRole === 'responder'): ?>
        <a href="dashboard.php" class="<?php echo $active === 'assigned' ? 'active' : ''; ?>">
            <span class="material-icons align-middle">assignment_ind</span> My Assignments</a>
    <?php else: ?>
        <a href="emergencies.php" class="<?php echo $active === 'emergencies' ? 'active' : ''; ?>">
            <span class="material-icons align-middle">warning</span> Emergencies</a>
    <?php endif; ?>

    <?php if ($staffRole === 'agency_admin'): ?>
        <a href="staff.php" class="<?php echo $active === 'staff' ? 'active' : ''; ?>">
            <span class="material-icons align-middle">groups</span> Staff</a>
    <?php endif; ?>

    <a href="hotzones.php" class="<?php echo $active === 'hotzones' ? 'active' : ''; ?>">
        <span class="material-icons align-middle">local_fire_department</span> Hot Zones</a>
    <a href="logout.php">
        <span class="material-icons align-middle">logout</span> Logout</a>
</nav>
