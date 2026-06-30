<?php
session_start();
require_once "user_guard.php";
require_once "classes/User.php";
require_once "classes/Emergency.php";
require_once "classes/State.php";

$userObj  = new User();
$incident = new Incident();
$stateObj = new State();

$user       = $userObj->get_current_user($_SESSION['useronline']);
$categories = $incident->fetch_category();
$states     = $stateObj->get_state();

$error = $_SESSION['errormsg'] ?? null;
unset($_SESSION['errormsg']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report an Emergency - Eko Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> body { background-color: #f8f9fa; } </style>
</head>
<body>
    <?php require_once 'partials/logo.php'; ?>
    <div class="container my-5">
        <h1 class="text-center mb-4">Report an Emergency</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form id="emergencyForm" action="process/process_incident.php" method="post" enctype="multipart/form-data">
                    <div class="form-group mt-3">
                        <label for="name">Full name</label>
                        <input type="text" class="form-control" id="name" name="fullname"
                               value="<?php echo htmlspecialchars($user['user_fullname'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="phone">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                               value="<?php echo htmlspecialchars($user['user_phone'] ?? ''); ?>" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="location">Address / Landmark</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <div class="form-group mt-3">
                        <label for="state">State</label>
                        <select name="state" id="state" class="form-select" required>
                            <option value="">Select State</option>
                            <?php foreach ($states as $state): ?>
                                <option value="<?php echo $state['state_id']; ?>">
                                    <?php echo htmlspecialchars($state['state_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="lga">Local Government Area</label>
                        <select name="lga" id="lga" class="form-select" required>
                            <option value="">Select a state first</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="emergency">Emergency Type</label>
                        <select class="form-select" id="emergency" name="emergency_type" required>
                            <option value="">Select an emergency</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['category_id']; ?>">
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="status">Severity</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="">Select severity</option>
                            <option value="severe">Severe</option>
                            <option value="moderate">Moderate</option>
                            <option value="mild">Mild</option>
                        </select>
                    </div>
                    <div class="form-group mt-3">
                        <label for="time">Date &amp; Time of Incident</label>
                        <input type="datetime-local" class="form-control" name="time" id="time">
                    </div>
                    <div class="form-group mt-3">
                        <label for="imageUpload">Upload Image (optional)</label>
                        <input type="file" class="form-control" name="imageUpload" id="imageUpload" accept="image/*">
                    </div>
                    <div class="form-group mt-3">
                        <label for="videoUpload">Upload Video (optional)</label>
                        <input type="file" class="form-control" name="videoUpload" id="videoUpload" accept="video/*">
                    </div>
                    <div class="form-group mt-3">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" rows="3" name="desc"></textarea>
                    </div>
                    <div class="d-grid gap-2 col-12 mx-auto my-4">
                        <button type="submit" class="btn btn-danger col-12" name="btnform">Submit Report</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // When a state is chosen, load only the LGAs that belong to it.
        $("#state").change(function () {
            var stateId = $(this).val();
            var $lga = $("#lga");
            $lga.html('<option value="">Loading...</option>');
            if (!stateId) {
                $lga.html('<option value="">Select a state first</option>');
                return;
            }
            $.ajax({
                url: "server.php",
                method: "post",
                data: { state: stateId },
                dataType: "json",
                success: function (res) {
                    $lga.empty().append('<option value="">Select LGA</option>');
                    res.forEach(function (lga) {
                        $lga.append('<option value="' + lga.lga_id + '">' + lga.lga_name + '</option>');
                    });
                }
            });
        });
    </script>
</body>
</html>
