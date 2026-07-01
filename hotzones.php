<?php
require_once "classes/Emergency.php";

$incident = new Incident();
$zones  = $incident->hot_zones(3);
$points = $incident->incident_points();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Hot Zones - Eko Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style> body { background:#f8f9fa; } #map { height: 460px; border-radius:.5rem; } </style>
</head>
<body>
    <?php require_once 'partials/logo.php'; ?>
    <div class="container my-5">
        <h1 class="mb-1">Emergency Hot Zones</h1>
        <p class="text-muted">Areas with the most reported emergencies. Stay alert around these locations.</p>

        <div class="card shadow-sm mb-4"><div class="card-body"><div id="map"></div></div></div>

        <div class="card shadow-sm">
            <div class="card-header"><h5 class="mb-0">Most-affected areas</h5></div>
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead><tr><th>#</th><th>Area (LGA)</th><th>State</th><th>Reports</th></tr></thead>
                    <tbody>
                    <?php if (empty($zones)): ?>
                        <tr><td colspan="4" class="text-muted text-center py-3">No hot zones yet.</td></tr>
                    <?php else: $i = 1; foreach ($zones as $z): ?>
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
        <a href="index.php" class="btn btn-outline-secondary mt-3">Back to Home</a>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([6.5244, 3.3792], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19, attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        (<?php echo json_encode($points); ?>).forEach(function (p) {
            if (p.latitude && p.longitude) {
                L.circleMarker([p.latitude, p.longitude], {
                    radius: 6, color: '#dc3545', fillColor: '#dc3545', fillOpacity: 0.6
                }).addTo(map).bindPopup((p.category_name || 'Emergency'));
            }
        });
        (<?php echo json_encode($zones); ?>).forEach(function (z) {
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
