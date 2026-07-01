<?php
session_start();
require_once __DIR__ . '/../classes/User.php';
require_once __DIR__ . '/../classes/utilities.php';

if (!isset($_POST['btnsignup'])) {
    $_SESSION["errormsg"] = "Please complete the registration form.";
    header("location:../login_signup.php");
    exit();
}

$fullname = sanitizer($_POST['fullname'] ?? '');
$email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = $_POST['pwd'] ?? '';
$state    = filter_input(INPUT_POST, 'state', FILTER_VALIDATE_INT);
$lga      = filter_input(INPUT_POST, 'lga', FILTER_VALIDATE_INT);

if (empty($fullname) || !$email || empty($password) || !$state || !$lga) {
    $_SESSION['errormsg'] = "All fields are required and the email must be valid.";
    header("location:../login_signup.php");
    exit();
}

if (strlen($password) < 6) {
    $_SESSION['errormsg'] = "Password must be at least 6 characters long.";
    header("location:../login_signup.php");
    exit();
}

$user  = new User();
$check = $user->insert_user($fullname, $email, $password, $state, $lga);

if ($check) {
    $_SESSION['useronline'] = $check;
    $_SESSION['user_id'] = $check;
    $_SESSION['logged_in'] = true;
    $_SESSION['loggedin'] = true;
    // Send new users straight to their profile to complete their details.
    $_SESSION['feedback'] = 'Welcome! Please complete your profile.';
    header('location:../update_profile.php?id=' . $check);
    exit();
}

header('location:../login_signup.php');
exit();
