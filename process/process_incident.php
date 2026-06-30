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
$latitude    = filter_input(INPUT_POST, 'latitude', FILTER_VALIDATE_FLOAT);
$longitude   = filter_input(INPUT_POST, 'longitude', FILTER_VALIDATE_FLOAT);
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
    $status, $time, $incident_img, $incident_vid, $description, $lga,
    $latitude !== false ? $latitude : null,
    $longitude !== false ? $longitude : null
);

if (!$loc) {
    header("location:../emergency_form.php");
    exit();
}

// Route to the response service relevant to the chosen emergency category.
//   Fire service:   Fire(2), Flood(7), Building Collapse(8), Gas Leak(10)
//   Police:         Theft/Crime(4), Kidnapping(11), Domestic Violence(12), Civil Unrest(15)
//   Medical (default): Medical(1), Accident(3), Ambulance(6), Road Accident(9),
//                      Electrocution(13), Drowning(14)
$fireTypes   = [2, 7, 8, 10];
$policeTypes = [4, 11, 12, 15];

if (in_array($emergency, $fireTypes, true)) {
    $page = "fire.php";
} elseif (in_array($emergency, $policeTypes, true)) {
    $page = "police.php";
} else {
    $page = "hospital.php";
}

header("location:../$page?loc=$loc");
exit();
