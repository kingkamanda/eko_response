<?php
session_start();
require_once "admin_guard.php";
require_once "./classes/Admin.php";

$admin = new Admin();

$byType   = $admin->report_by_type();
$byStatus = $admin->report_by_status();
$byAgency = $admin->report_by_agency();
$byLga    = $admin->report_by_lga(15);

// CSV export (emergencies grouped by type). Must run before any HTML output.
if (($_GET['export'] ?? '') === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="eko_response_report_by_type.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Emergency Type', 'Total Reports']);
    foreach ($byType as $row) {
        fputcsv($out, [$row['category_name'], $row['total']]);
    }
    fclose($out);
    exit();
}

$pendingCount = $admin->count_pending_categories();
$pageTitle = 'Reports - Eko Response';

// Encode data for the charts.
$typeLabels = array_column($byType, 'category_name');
$typeData   = array_map('intval', array_column($byType, 'total'));
$agencyLabels = array_column($byAgency, 'agency_name');
$agencyData   = array_map('intval', array_column($byAgency, 'total'));
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require "partials/head.php"; ?></head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'reports'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Reports &amp; Analytics</h3>
                <a href="reports.php?export=csv" class="btn btn-success">⬇ Export CSV</a>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header"><h5 class="mb-0">Emergencies by type</h5></div>
                        <div class="card-body"><canvas id="typeChart"></canvas></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header"><h5 class="mb-0">Emergencies by responsible agency</h5></div>
                        <div class="card-body"><canvas id="agencyChart"></canvas></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header"><h5 class="mb-0">By status</h5></div>
                        <div class="card-body table-responsive">
                            <table class="table table-sm">
                                <thead><tr><th>Status</th><th>Total</th></tr></thead>
                                <tbody>
                                <?php foreach ($byStatus as $r): ?>
                                    <tr><td><?php echo htmlspecialchars($r['status']); ?></td><td><?php echo (int)$r['total']; ?></td></tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-header"><h5 class="mb-0">Top locations (LGA)</h5></div>
                        <div class="card-body table-responsive">
                            <table class="table table-sm">
                                <thead><tr><th>LGA</th><th>Total</th></tr></thead>
                                <tbody>
                                <?php if (empty($byLga)): ?>
                                    <tr><td colspan="2" class="text-muted">No location data yet.</td></tr>
                                <?php else: foreach ($byLga as $r): ?>
                                    <tr><td><?php echo htmlspecialchars($r['lga_name']); ?></td><td><?php echo (int)$r['total']; ?></td></tr>
                                <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    const typeCtx = document.getElementById('typeChart');
    new Chart(typeCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($typeLabels); ?>,
            datasets: [{ label: 'Reports', data: <?php echo json_encode($typeData); ?>, backgroundColor: '#dc3545' }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    const agencyCtx = document.getElementById('agencyChart');
    new Chart(agencyCtx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($agencyLabels); ?>,
            datasets: [{ data: <?php echo json_encode($agencyData); ?>,
                backgroundColor: ['#0d6efd', '#dc3545', '#198754', '#ffc107', '#6c757d'] }]
        }
    });
</script>
</body>
</html>
