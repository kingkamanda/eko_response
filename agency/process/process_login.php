<?php
session_start();
require_once __DIR__ . '/../classes/Staff.php';

if (!isset($_POST['stafflogin'])) {
    header("location: ../login.php");
    exit();
}

$email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = $_POST['password'] ?? '';

if (!$email || $password === '') {
    $_SESSION['staff_error'] = "Please enter a valid email and password.";
    header("location: ../login.php");
    exit();
}

$staff = new Staff();
if ($staff->login($email, $password)) {
    header("location: ../dashboard.php");
    exit();
}

header("location: ../login.php");
exit();
