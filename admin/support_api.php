<?php
session_start();
require_once __DIR__ . '/admin_guard.php';
require_once __DIR__ . '/classes/Admin.php';

header('Content-Type: application/json');

$admin   = new Admin();
$user_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT)
    ?: filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);

if (!$user_id) {
    echo json_encode(['messages' => []]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admin->support_reply($user_id, $_SESSION['adminonline'] ?? null, $_POST['body'] ?? '');
}

$since = filter_input(INPUT_GET, 'since', FILTER_VALIDATE_INT) ?: 0;
echo json_encode(['messages' => $admin->support_fetch($user_id, $since)]);
