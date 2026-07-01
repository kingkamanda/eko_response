<?php
/**
 * JSON endpoint for the user's support chat.
 *   GET  ?since=<id>   -> new messages in the user's conversation
 *   POST body=<text>   -> send a message, returns the new messages
 */
session_start();
require_once __DIR__ . '/classes/Support.php';

header('Content-Type: application/json');

if (empty($_SESSION['useronline'])) {
    http_response_code(401);
    echo json_encode(['error' => 'not_authenticated']);
    exit();
}

$user_id = $_SESSION['useronline'];
$support = new Support();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $support->send_user_message($user_id, $_POST['body'] ?? '');
}

$since = filter_input(INPUT_GET, 'since', FILTER_VALIDATE_INT) ?: 0;
echo json_encode(['messages' => $support->fetch_conversation($user_id, $since)]);
