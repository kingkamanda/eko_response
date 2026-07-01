<?php
session_start();
require_once __DIR__ . '/classes/Staff.php';
(new Staff())->logout();
header("location: login.php");
exit();
