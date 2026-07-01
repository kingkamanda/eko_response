<?php
session_start();
require_once __DIR__ . '/../classes/utilities.php';
require_once __DIR__ . '/../classes/User.php';

if (!isset($_POST['btnlogin'])) {
    $_SESSION['user_errormessage'] = "Please complete the form.";
    header("location:../login_signup.php");
    exit();
}

$email    = sanitizer($_POST["email"] ?? '');
$password = $_POST['pwd'] ?? '';

$user = new User();
$data = $user->login($email, $password);

if ($data) {
    $_SESSION['useronline'] = $data;
    $_SESSION['user_id'] = $data;
    $_SESSION['logged_in'] = true;
    $_SESSION['loggedin'] = true;
    header("location:../user_dashboard.php");
    exit();
}

header("location:../login_signup.php");
exit();
