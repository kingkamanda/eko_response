<?php
session_start();
require_once __DIR__ . '/../classes/Emergency.php';
require_once __DIR__ . '/../classes/utilities.php';

// Only signed-in users may file a report, so every report is tied to an account.
if (!isset($_SESSION['useronline'])) {
    $_SESSION['errormessage'] = "You must be logged in to report an emergency.";
    header("location:../login_signup.php");
    exit();
}

if (!isset($_POST['btnform'])) {
    $_SESSION['errormsg'] = "Please complete the form.";
    header("location:../emergency_form.php");
    exit();
}

$user_id     = $_SESSION['useronline'];
$fullname    = sanitizer($_POST['fullname'] ?? '');
$phone       = sanitizer($_POST['phone'] ?? '');
$location    = sanitizer($_POST['location'] ?? '');
$lga         = filter_input(INPUT_POST, 'lga', FILTER_VALIDATE_INT);
$emergency   = filter_input(INPUT_POST, 'emergency_type', FILTER_VALIDATE_INT);
$status      = sanitizer($_POST['status'] ?? '');
$time        = sanitizer($_POST['time'] ?? '');
$description = sanitizer($_POST['desc'] ?? '');
$incident_img = $_FILES['imageUpload'] ?? null;
$incident_vid = $_FILES['videoUpload'] ?? null;

if (empty($fullname) || empty($phone) || empty($location) || !$lga || !$emergency || empty($status)) {
    $_SESSION['errormsg'] = "Please fill in all required fields.";
    header("location:../emergency_form.php");
    exit();
}

$incident = new Incident();
$loc = $incident->addIncident(
    $user_id, $fullname, $phone, $location, $emergency,
    $status, $time, $incident_img, $incident_vid, $description, $lga
);

if (!$loc) {
    header("location:../emergency_form.php");
    exit();
}

// Route to the response units relevant to the chosen emergency category.
// Categories: 1 Medical, 2 Fire, 3 Accident, 4 Theft/Crime, 6 Ambulance Service.
switch ($emergency) {
    case 2:
        $page = "fire.php";
        break;
    case 4:
        $page = "police.php";
        break;
    default: // Medical, Accident, Ambulance -> medical units
        $page = "hospital.php";
        break;
}

header("location:../$page?loc=$loc");
exit();
