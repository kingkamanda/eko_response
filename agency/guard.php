<?php
// Ensure a staff member is signed in. Include after session_start().
if (!isset($_SESSION['staffonline'])) {
    $_SESSION['staff_error'] = "Please sign in to access the agency portal.";
    header("location: login.php");
    exit();
}
