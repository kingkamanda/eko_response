<?php
session_start();
require_once "../classes/Admin.php";
require_once "../classes/General.php";

 $admin1 = new Admin();

 if (isset($_POST['adminlogin'])) {
    $email = General::sanitizer($_POST['email']);
    $password = General::sanitizer($_POST['password']);
    $result= $admin1->admin_login($email, $password);

    if($result ==1){ 
        header("location:../admin_dashboard.php");
        exit();
    }
    else{ 
        header("location:../index.php");
    }
} else {
    $_SESSION['admin_errormessage'] = "Please Complete the Form";
    header("location:../index.php");
}

?>