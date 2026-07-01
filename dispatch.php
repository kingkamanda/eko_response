<?php
session_start();
require_once "user_guard.php";
require_once "classes/Emergency.php";
require_once __DIR__ . '/partials/agency_contact.php';

$incidentObj = new Incident();
$alert_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$incident = $alert_id ? $incidentObj->get_incident($alert_id) : null;

// Only the reporter can see their dispatch.
if (!$incident || (int)$incident['user_id'] !== (int)$_SESSION['useronline']) {
    $notFound = true;
} else {
    $services = $incidentObj->responder_services(
        $incident['base_service'],
        !empty($incident['casualties']),
        !empty($incident['weapon'])
    );
    $lga = (int) $incident['lga_id'];
}

$meta = [
    'medical' => ['label' => 'Medical & Ambulance', 'icon' => 'fa-truck-medical', 'name' => 'medical_unit_name', 'addr' => 'medical_unit_address', 'phone' => 'medical_unit_phone_number', 'id' => 'medical_unit_id'],
    'fire'    => ['label' => 'Fire & Rescue',        'icon' => 'fa-fire',          'name' => 'fire_unit_name',    'addr' => 'fire_unit_address',    'phone' => 'fire_unit_phone_number',    'id' => 'fire_unit_id'],
    'police'  => ['label' => 'Police',               'icon' => 'fa-shield-halved', 'name' => 'police_unit_name',  'addr' => 'police_unit_address',  'phone' => 'police_unit_phone_number',  'id' => 'police_unit_id'],
    'other'   => ['label' => 'Road Safety / Other',  'icon' => 'fa-car-burst',     'name' => null],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dispatch - Eko Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/static/css/app.css">
</head>
<body>
    <?php require_once 'partials/logo.php'; ?>
    <div class="container my-5">
        <?php if (!empty($notFound)): ?>
            <div class="alert alert-warning">We couldn't find that report.</div>
            <a href="user_dashboard.php" class="btn btn-outline-secondary">Back to dashboard</a>
        <?php else: ?>
            <div class="text-center mb-4">
                <div class="er-icon-badge mx-auto"><i class="fa-solid fa-circle-check text-success"></i></div>
                <h2 class="fw-bold">Help is on the way</h2>
                <p class="text-muted mb-1">Report <strong>#<?php echo (int)$incident['alert_id']; ?></strong> &mdash;
                    <?php echo htmlspecialchars($incident['category_name'] ?? 'Emergency'); ?>
                    at <strong><?php echo htmlspecialchars(trim(($incident['user_location'] ?? '') . ' ' . ($incident['lga_name'] ? '(' . $incident['lga_name'] . ', ' . ($incident['state_name'] ?? '') . ')' : ''))); ?></strong>
                </p>
                <div>
                    <?php if (!empty($incident['casualties'])): ?><span class="badge bg-danger">Casualties reported → ambulance</span><?php endif; ?>
                    <?php if (!empty($incident['weapon'])): ?><span class="badge bg-dark">Weapon involved → police</span><?php endif; ?>
                </div>
                <p class="mt-3 mb-0">We are dispatching <strong><?php echo count($services); ?></strong>
                    responder<?php echo count($services) === 1 ? '' : 's'; ?>. Contact them directly if you can.</p>
            </div>

            <?php foreach ($services as $svc):
                $m = $meta[$svc] ?? $meta['other'];
                $agency = $incidentObj->agency_for_service($svc, $lga);
                $units = [];
                if (!empty($m['name'])) {
                    $r = $incidentObj->find_units($svc, $lga);
                    $units = $r['units'];
                }
            ?>
            <div class="card er-card mb-4">
                <div class="card-header d-flex align-items-center gap-2">
                    <span class="er-icon-badge" style="width:40px;height:40px;font-size:1.1rem;margin:0;"><i class="fa-solid <?php echo $m['icon']; ?>"></i></span>
                    <h5 class="mb-0"><?php echo htmlspecialchars($m['label']); ?></h5>
                </div>
                <div class="card-body">
                    <?php if ($agency) { render_agency_contact($agency); } ?>

                    <?php if (!empty($m['name'])): ?>
                        <?php if ($units): ?>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle mb-0">
                                    <thead><tr><th>Unit</th><th>Address</th><th>Phone</th><th>LGA</th></tr></thead>
                                    <tbody>
                                    <?php foreach ($units as $u): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($u[$m['name']] ?? ''); ?></td>
                                            <td><?php echo htmlspecialchars($u[$m['addr']] ?? ''); ?></td>
                                            <td><?php $ph = $u[$m['phone']] ?? ''; echo $ph ? '<a href="tel:' . htmlspecialchars($ph) . '">' . htmlspecialchars($ph) . '</a>' : '—'; ?></td>
                                            <td><?php echo htmlspecialchars($u['lga_name'] ?? ''); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-0">No <?php echo htmlspecialchars(strtolower($m['label'])); ?> units are registered for this area yet — use the contact above or call 112.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="d-flex gap-2">
                <a href="incident_view.php?id=<?php echo (int)$incident['alert_id']; ?>" class="btn btn-brand">Track this report</a>
                <a href="user_dashboard.php" class="btn btn-outline-secondary">Back to dashboard</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
