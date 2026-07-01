<?php
/**
 * Shared logged-in detection for public pages. Include after (or it will start)
 * the session. Exposes $loggedIn (bool) and $currentUserId (int|null).
 *
 * Accepts the several session keys used across the app so the public header,
 * home page and other entry points all agree on login state.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loggedIn = false;
$currentUserId = null;

foreach (['useronline', 'user_id', 'user', 'loggedin', 'logged_in', 'is_logged_in', 'email', 'user_email'] as $key) {
    if (!empty($_SESSION[$key])) {
        $loggedIn = true;
        break;
    }
}

if (!empty($_SESSION['useronline'])) {
    $currentUserId = $_SESSION['useronline'];
} elseif (!empty($_SESSION['user_id'])) {
    $currentUserId = $_SESSION['user_id'];
}
