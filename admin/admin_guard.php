<?php
if(!isset($_SESSION["adminonline"])){
    $_SESSION["errormessage"]="You must be logged in to have access to the page";
    header("location:index.php");
    exit();

    
}
?>