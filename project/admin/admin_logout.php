<?php
session_start();
require_once "classes/Admin.php";

$admin1= new Admin();
$admin1->admin_logout();

header("location: index.php");
exit();

?>