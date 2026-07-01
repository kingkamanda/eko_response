<?php
session_start();
require_once "admin_guard.php";
require_once "./classes/Admin.php";

$admin = new Admin();

$byType   = $admin->report_by_type();
$byStatus = $admin->report_by_status();
$byAgency = $admin->report_by_agency();
$byLga    = $admin->report_by_lga(15);
$byGender = $admin->report_by_reporter_gender();
$byHour   = $admin->report_by_hour();
$byMonth  = $admin->report_by_month();

// Detailed CSV export. Must run before any HTML output.
if (($_GET['export'] ?? '') === 'csv') {
    $rows = $admin->report_detailed();
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="eko_response_incidents.csv"');
    $out = fopen('php://output', 'w');
    $headers = [
        'Incident ID', 'Crime/Type', 'Severity', 'Status', 'Reporter gender',
        'Gender(s) affected', 'Offender gender', 'People involved', 'Location',
        'Landmark', 'Route', 'LGA', 'State', 'Time of incident', 'Hour',
        'Day of week', 'Month', 'Reported at', 'First response (mins)',
        'Resolution time (mins)', 'Flagged'
    ];
    fputcsv($out, $headers);
    foreach ($rows as $r) {
        fputcsv($out, [
            $r['alert_id'], $r['crime_type'], $r['severity'], $r['status'],
            $r['reporter_gender'], $r['affected_gender'], $r['offender_gender'],
            $r['people_involved'], $r['location'], $r['landmark'], $r['route'],
            $r['lga_name'], $r['state_name'], $r['time_of_incident'], $r['hour'],
            $r['day_of_week'], $r['month'], $r['reported_at'],
            $r['first_response_minutes'], $r['resolution_minutes'], $r['flagged'],
        ]);
    }
    fclose($out);
    exit();
}

$pendingCount = $admin->count_pending_categories();
$pageTitle = 'Reports - Eko Response';

// Encode data for the charts.
$typeLabels   = array_column($byType, 'category_name');
$typeData     = array_map('intval', array_column($byType, 'total'));
$agencyLabels = array_column($byAgency, 'agency_name');
$agencyData   = array_map('intval', array_column($byAgency, 'total'));
$genderLabels = array_column($byGender, 'gender');
$genderData   = array_map('intval', array_column($byGender, 'total'));
$monthLabels  = array_column($byMonth, 'month');
$monthData    = array_map('intval', array_column($byMonth, 'total'));
// Hours 0-23 filled so the line chart is continuous.
$hourMap = [];
foreach ($byHour as $h) { $hourMap[(int)$h['hour']] = (int)$h['total']; }
$hourLabels = range(0, 23);
$hourData   = array_map(function ($h) use ($hourMap) { return $hourMap[$h] ?? 0; }, $hourLabels);
?>
<!DOCTYPE html>
<html lang="en">
<head><?php require "partials/head.php"; ?></head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'reports'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 er-shell px-3 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Reports &amp; Analytics</h3>
                <a href="reports.php?export=csv" class="btn btn-success">⬇ Export detailed CSV</a>
            </div>
            <p class="text-muted">The CSV export includes per-incident detail — genders (reporter, affected,
                offender), people involved, time/hour/day/month, location, landmark, route, and first-response
                &amp; resolution times.</p>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card er-card">
                        <div class="card-header"><h5 class="mb-0">Emergencies by type</h5></div>
                        <div class="card-body"><canvas id="typeChart"></canvas></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card er-card">
                        <div class="card-header"><h5 class="mb-0">Emergencies by responsible agency</h5></div>
                        <div class="card-body"><canvas id="agencyChart"></canvas></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card er-card">
                        <div class="card-header"><h5 class="mb-0">By reporter gender</h5></div>
                        <div class="card-body"><canvas id="genderChart"></canvas></div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card er-card">
                        <div class="card-header"><h5 class="mb-0">By hour of day</h5></div>
                        <div class="card-body"><canvas id="hourChart"></canvas></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card er-card">
                        <div class="card-header"><h5 class="mb-0">By month</h5></div>
                        <div class="card-body"><canvas id="monthChart"></canvas></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card er-card">
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
                    <div class="card er-card">
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

    new Chart(document.getElementById('genderChart'), {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($genderLabels); ?>,
            datasets: [{ data: <?php echo json_encode($genderData); ?>,
                backgroundColor: ['#0d6efd', '#d63384', '#6c757d', '#20c997'] }]
        }
    });

    new Chart(document.getElementById('hourChart'), {
        type: 'line',
        data: {
            labels: <?php echo json_encode($hourLabels); ?>,
            datasets: [{ label: 'Reports', data: <?php echo json_encode($hourData); ?>,
                borderColor: '#dc3545', backgroundColor: 'rgba(220,53,69,.15)', fill: true, tension: .3 }]
        },
        options: { scales: { y: { beginAtZero: true } } }
    });

    new Chart(document.getElementById('monthChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($monthLabels); ?>,
            datasets: [{ label: 'Reports', data: <?php echo json_encode($monthData); ?>, backgroundColor: '#0d6efd' }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
</script>
</body>
</html>
