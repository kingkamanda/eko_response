<?php
session_start();
require_once __DIR__ . '/admin_guard.php';
require_once __DIR__ . '/classes/Admin.php';

$user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
$action  = $_POST['action'] ?? '';

if ($user_id && in_array($action, ['activate', 'deactivate'], true)) {
    $admin = new Admin();
    if ($action === 'activate') {
        $admin->activate_user($user_id);
        $_SESSION['admin_feedback'] = "User account activated.";
    } else {
        $admin->deactivate_user($user_id);
        $_SESSION['admin_feedback'] = "User account deactivated.";
    }
}

header("location: admin_dashboard.php");
exit();
