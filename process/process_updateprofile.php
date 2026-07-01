<?php
session_start();
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/utilities.php';

if (!isset($_POST["btnupdate"])) {
    $_SESSION['errormsg'] = "Please complete the form.";
    header("location:../update_profile.php");
    exit();
}

if (!isset($_SESSION['useronline'])) {
    header("location:../login_signup.php");
    exit();
}

$user_id = $_SESSION['useronline'];
$fname   = sanitizer($_POST["name"] ?? '');
$email   = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone   = sanitizer($_POST["phonenumber"] ?? '');
$gender  = in_array($_POST["gender"] ?? '', ['male', 'female'], true) ? $_POST["gender"] : null;
$age     = sanitizer($_POST["age"] ?? '');
$address = sanitizer($_POST["address"] ?? '');

if ($fname === '' || !$email) {
    $_SESSION['errormsg'] = "Name and a valid email are required.";
    header("location:../update_profile.php");
    exit();
}

$userObj = new User();
$current = $userObj->get_current_user($user_id);
$imageName = $current['user_image'] ?? null;   // keep existing picture by default

// A new picture is optional; validate and store it only when supplied.
$file = $_FILES["profile_pic"] ?? null;
if ($file && isset($file['error']) && $file['error'] === UPLOAD_ERR_OK) {
    if ($file['size'] > 2 * 1024 * 1024) {
        $_SESSION['errormsg'] = "The picture is too large (max 2 MB).";
        header("location:../update_profile.php");
        exit();
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
        $_SESSION['errormsg'] = "Only JPEG, JPG and PNG pictures are allowed.";
        header("location:../update_profile.php");
        exit();
    }
    $dir = __DIR__ . '/../uploads';
    if (!is_dir($dir)) { mkdir($dir, 0775, true); }
    $newname = time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;
    if (move_uploaded_file($file['tmp_name'], "$dir/$newname")) {
        $imageName = $newname;
    }
}

if ($userObj->update_user($fname, $email, $phone, $gender, $age, $address, $imageName, $user_id)) {
    $_SESSION['feedback'] = 'Profile updated!';
    header("location:../user_dashboard.php");
    exit();
}

$_SESSION['errormsg'] = 'Something went wrong, please try again.';
header("location:../update_profile.php");
exit();
