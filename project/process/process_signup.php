<?php
ini_set("displayerrors", "1");
session_start();
require_once "../classes/User.php";
require_once('../classes/utilities.php');

if (isset($_POST['btnsignup'])){
    
    $fullname = sanitizer($_POST['fullname']);
    $email = sanitizer($_POST['email']);
    $password = sanitizer($_POST['pwd']);
    $state = $_POST["state"];
    $lga = $_POST["lga"];

    // print_r($_POST);
    // die;

    if (empty($fullname)|| empty($email)||empty($password)||empty($state)||empty($lga)) {
        $_SESSION['errormsg'] = "All Fields are required";
        header("location:../login_signup.php");
        exit();
    }
   
       $user= new User();
       $check = $user->insert_user($fullname,$email,$password,$state, $lga);
        if ($check) {
            $_SESSION['useronline'] = $check;
            header('location:../user_dashboard.php');
            // print_r($check);
            // die();
        } 
        else {
            header('location:../login_signup.php');
        } 
     
        //$user->insert_user($fullname,$email,$password);
} else {
    $_SESSION["errormsg"] = "Please Complete the registration";
    header("location:../login_signup.php");
    exit();
}
?>