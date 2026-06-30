<?php
require_once "classes/Emergency.php";
require_once "partials/header.php";

$loc = isset($_GET['loc']) ? intval($_GET['loc']) : 0;
$respondent = new Incident();
$location = $respondent->get_location($loc);
$result   = $respondent->find_units('medical', $loc);
$hospitals = $result['units'];
?>
<section class="ftco-section mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center mb-4">
                <h2 class="heading-section">Hospitals &amp; Medical Units</h2>
                <?php if ($location): ?>
                    <p class="text-muted mb-1">Reported location:
                        <strong><?php echo htmlspecialchars($location['lga_name'] . ', ' . $location['state_name']); ?></strong>
                    </p>
                <?php endif; ?>
                <?php if ($result['scope'] === 'state'): ?>
                    <div class="alert alert-warning">No medical units are registered in that LGA yet &mdash;
                        showing the nearest units across <strong><?php echo htmlspecialchars($location['state_name'] ?? 'the state'); ?></strong>.</div>
                <?php elseif ($result['scope'] === 'none'): ?>
                    <div class="alert alert-danger">No medical units are registered for this location yet.
                        Please call the national emergency line <strong>112</strong>.</div>
                <?php endif; ?>
            </div>
        </div>
        <?php if ($hospitals): ?>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered table-dark table-hover">
                    <tr><th>ID</th><th>Name</th><th>Address</th><th>Phone</th><th>Type</th><th>LGA</th></tr>
                    <?php foreach ($hospitals as $h): ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars($h['medical_unit_id']); ?></th>
                        <td><?php echo htmlspecialchars($h['medical_unit_name']); ?></td>
                        <td><?php echo htmlspecialchars($h['medical_unit_address']); ?></td>
                        <td><?php echo htmlspecialchars($h['medical_unit_phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($h['medical_unit_type']); ?></td>
                        <td><?php echo htmlspecialchars($h['lga_name']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <?php endif; ?>
        <div class="text-center mb-5">
            <a href="user_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
        </div>
    </div>
</section>
<?php require_once "partials/footer.php"; ?>
