<?php
session_start();
require_once __DIR__ . '/../classes/Admin.php';
require_once __DIR__ . '/../classes/General.php';

if (!isset($_POST['adminlogin'])) {
    $_SESSION['admin_errormessage'] = "Please complete the form.";
    header("location:../index.php");
    exit();
}

$email    = General::sanitizer($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$admin1 = new Admin();
if ($admin1->admin_login($email, $password) === 1) {
    header("location:../admin_dashboard.php");
    exit();
}

header("location:../index.php");
exit();
