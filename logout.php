<?php
ini_set("display_errors", "1");
session_start();
require_once "classes/User.php";

$user1 = new User();
$user1->logout();
header("location:login_signup.php");
exit();


#go to partials/menu.php and link the button to "logout.php"
?>