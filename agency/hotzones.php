<?php
session_start();
require_once "guard.php";
require_once "classes/Staff.php";

$staffObj = new Staff();
$me = $staffObj->current($_SESSION['staffonline']);
if (!$me) { header("location: logout.php"); exit(); }

$agencyId   = $me['agency_id'];
$staffRole  = $me['role'];
$isPlatform = Staff::isPlatform($staffRole);
$agencyName = $isPlatform ? 'Platform' : ($me['agency_name'] ?? 'Agency');
$zones      = $isPlatform ? $staffObj->global_hot_zones(2) : $staffObj->hot_zones($agencyId, 2);
$pageTitle  = 'Hot Zones - Eko Response';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "partials/head.php"; ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php $active = 'hotzones'; require "partials/sidebar.php"; ?>
        <main class="col-md-10 px-4 py-4">
            <h3 class="mb-1">Hot Zones &mdash; <?php echo htmlspecialchars($agencyName); ?></h3>
            <p class="text-muted">Areas with the most emergencies handled by your agency.</p>

            <div class="card shadow-sm mb-4"><div class="card-body"><div id="map"></div></div></div>

            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead><tr><th>#</th><th>LGA</th><th>State</th><th>Reports</th></tr></thead>
                        <tbody>
                        <?php if (empty($zones)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-3">No hot zones yet.</td></tr>
                        <?php else: $i=1; foreach ($zones as $z): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo htmlspecialchars($z['lga_name']); ?></td>
                                <td><?php echo htmlspecialchars($z['state_name'] ?? '—'); ?></td>
                                <td><span class="badge bg-danger"><?php echo (int)$z['total']; ?></span></td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([6.5244, 3.3792], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19, attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
    (<?php echo json_encode($zones); ?>).forEach(function (z) {
        if (z.avg_lat && z.avg_lng) {
            L.circle([z.avg_lat, z.avg_lng], {
                radius: 400 + Number(z.total) * 300,
                color: '#b02a37', weight: 1, fillColor: '#dc3545', fillOpacity: 0.2
            }).addTo(map).bindPopup('<strong>' + z.lga_name + '</strong><br>' + z.total + ' reports');
        }
    });
</script>
</body>
</html>
