<?php
require_once "classes/Emergency.php";

$incident  = new Incident();
$zones     = $incident->hot_zones(3);
$points    = $incident->incident_points();
$priority  = $incident->priority_incidents();
$recent    = $incident->recent_incidents();

$sevBadge = function ($s) {
    switch (strtolower((string) $s)) {
        case 'severe':   return 'bg-danger';
        case 'moderate': return 'bg-warning text-dark';
        case 'mild':     return 'bg-info text-dark';
        default:         return 'bg-secondary';
    }
};
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
        <p class="text-muted">Live view of where emergencies are happening. The last 24 hours are prioritised by severity.</p>

        <!-- Priority: last 24 hours, by severity -->
        <div class="card shadow-sm mb-4 border-danger">
            <div class="card-header bg-danger text-white"><h5 class="mb-0">🚨 Priority — last 24 hours</h5></div>
            <div class="card-body table-responsive">
                <?php if (empty($priority)): ?>
                    <p class="text-muted mb-0">No emergencies reported in the last 24 hours.</p>
                <?php else: ?>
                    <table class="table table-sm align-middle mb-0">
                        <thead><tr><th>Severity</th><th>Type</th><th>Area</th><th>Reported</th></tr></thead>
                        <tbody>
                        <?php foreach ($priority as $p): ?>
                            <tr>
                                <td><span class="badge <?php echo $sevBadge($p['severity']); ?>"><?php echo htmlspecialchars($p['severity'] ?? 'n/a'); ?></span></td>
                                <td><?php echo htmlspecialchars($p['category_name'] ?? 'Emergency'); ?></td>
                                <td><?php echo htmlspecialchars(trim(($p['lga_name'] ?? '') . ' ' . ($p['state_name'] ? ', ' . $p['state_name'] : ''))); ?></td>
                                <td><?php echo htmlspecialchars($p['alert_time'] ?? ''); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow-sm mb-4"><div class="card-body"><div id="map"></div></div></div>

        <div class="card shadow-sm mb-4">
            <div class="card-header"><h5 class="mb-0">Most-affected areas</h5></div>
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead><tr><th>#</th><th>Area (LGA)</th><th>State</th><th>Total</th><th>Last 24h</th><th>Severe</th><th>Last report</th></tr></thead>
                    <tbody>
                    <?php if (empty($zones)): ?>
                        <tr><td colspan="7" class="text-muted text-center py-3">No hot zones yet.</td></tr>
                    <?php else: $i = 1; foreach ($zones as $z): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($z['lga_name']); ?></td>
                            <td><?php echo htmlspecialchars($z['state_name'] ?? '—'); ?></td>
                            <td><span class="badge bg-danger"><?php echo (int)$z['total']; ?></span></td>
                            <td><?php echo (int)$z['last_24h']; ?></td>
                            <td><?php echo (int)$z['severe_count']; ?></td>
                            <td><?php echo htmlspecialchars($z['last_time'] ?? '—'); ?></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Past 7 days, more detail, not prioritised -->
        <div class="card shadow-sm">
            <div class="card-header"><h5 class="mb-0">Past 7 days</h5></div>
            <div class="card-body table-responsive">
                <?php if (empty($recent)): ?>
                    <p class="text-muted mb-0">Nothing from the past week (outside the 24h window).</p>
                <?php else: ?>
                    <table class="table table-sm align-middle mb-0">
                        <thead><tr><th>Type</th><th>Severity</th><th>Area</th><th>Details</th><th>Reported</th></tr></thead>
                        <tbody>
                        <?php foreach ($recent as $r): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($r['category_name'] ?? 'Emergency'); ?></td>
                                <td><span class="badge <?php echo $sevBadge($r['severity']); ?>"><?php echo htmlspecialchars($r['severity'] ?? 'n/a'); ?></span></td>
                                <td><?php echo htmlspecialchars(trim(($r['lga_name'] ?? '') . ' ' . ($r['state_name'] ? ', ' . $r['state_name'] : ''))); ?></td>
                                <td class="small text-muted"><?php echo htmlspecialchars(mb_strimwidth((string)($r['alert_desc'] ?? ''), 0, 60, '…')); ?></td>
                                <td><?php echo htmlspecialchars($r['alert_time'] ?? ''); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
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
                var color = (String(p.severity).toLowerCase() === 'severe') ? '#dc3545' : '#fd7e14';
                L.circleMarker([p.latitude, p.longitude], {
                    radius: 6, color: color, fillColor: color, fillOpacity: 0.6
                }).addTo(map).bindPopup((p.category_name || 'Emergency') + '<br>' + (p.severity || ''));
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
