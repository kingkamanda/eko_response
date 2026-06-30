<?php

if(!isset($_SESSION["useronline"])){
    $_SESSION["errormessage"]="You must be logged in to have access to the page";
    header("location:login_signup.php");
    exit();
}
?>