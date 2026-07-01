<?php
session_start();
require_once "admin_guard.php";
require_once "./classes/Admin.php";

$admin = new Admin();

$threshold = filter_input(INPUT_GET, 'threshold', FILTER_VALIDATE_INT) ?: 3;
$zones  = $admin->hot_zones($threshold);
$points = $admin->incident_points();
$pendingCount = $admin->count_pending_categories();
$pageTitle = 'Hot Zones - Eko Response';
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
            <h3 class="mb-1">Hot Zones</h3>
            <p class="text-muted">Areas are flagged <strong>hot</strong> automatically once they reach
                <strong><?php echo (int)$threshold; ?></strong> or more reported emergencies.
                <a href="hot_zones.php?threshold=<?php echo max(1, $threshold - 1); ?>">lower</a> /
                <a href="hot_zones.php?threshold=<?php echo $threshold + 1; ?>">raise</a> threshold.
            </p>

            <div class="card shadow-sm mb-4">
                <div class="card-body"><div id="map"></div></div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header"><h5 class="mb-0">Hot zones (by LGA)</h5></div>
                <div class="card-body table-responsive">
                    <table class="table table-striped align-middle">
                        <thead><tr><th>#</th><th>LGA</th><th>State</th><th>Reports</th><th>Map</th></tr></thead>
                        <tbody>
                        <?php if (empty($zones)): ?>
                            <tr><td colspan="5" class="text-muted text-center py-3">No hot zones at this threshold yet.</td></tr>
                        <?php else: $i = 1; foreach ($zones as $z): ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo htmlspecialchars($z['lga_name']); ?></td>
                                <td><?php echo htmlspecialchars($z['state_name'] ?? '—'); ?></td>
                                <td><span class="badge bg-danger"><?php echo (int)$z['total']; ?></span></td>
                                <td>
                                    <?php if (!empty($z['avg_lat']) && !empty($z['avg_lng'])): ?>
                                        <a target="_blank" rel="noopener"
                                           href="https://www.google.com/maps?q=<?php echo $z['avg_lat']; ?>,<?php echo $z['avg_lng']; ?>">📍 view</a>
                                    <?php else: ?>—<?php endif; ?>
                                </td>
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

    // Individual reported points.
    var points = <?php echo json_encode($points); ?>;
    points.forEach(function (p) {
        if (p.latitude && p.longitude) {
            L.circleMarker([p.latitude, p.longitude], {
                radius: 6, color: '#dc3545', fillColor: '#dc3545', fillOpacity: 0.6
            }).addTo(map).bindPopup((p.category_name || 'Emergency') + '<br>' + (p.alert_status || ''));
        }
    });

    // Hot-zone bubbles (bigger = more reports).
    var zones = <?php echo json_encode($zones); ?>;
    zones.forEach(function (z) {
        if (z.avg_lat && z.avg_lng) {
            L.circle([z.avg_lat, z.avg_lng], {
                radius: 400 + Number(z.total) * 250,
                color: '#b02a37', weight: 1, fillColor: '#dc3545', fillOpacity: 0.15
            }).addTo(map).bindPopup('<strong>' + z.lga_name + '</strong><br>' + z.total + ' reports');
        }
    });
</script>
</body>
</html>
