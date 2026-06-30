<?php
session_start();
require_once('../classes/utilities.php');
require_once("../classes/user.php");
$user = new User;
if (isset($_POST['btnlogin'])) {//form was submitted
     //retrive and sanitized form data
     $email =sanitizer($_POST["email"]);
     $password = sanitizer($_POST['pwd']);
  //we want to call the method that will check if the credentials are valid
     $data = $user->login($email,$password);
      if ($data) {//log him in
     $_SESSION['useronline']= $data;
         header("location:../user_dashboard.php");
     exit();
  } else {
     header("location:../login_signup.php");
  }
 
 } else {//direct visit
   $_SESSION['errormsg'] = "Please Conplete the form";
   header("location:../login_signup.php");
  exit();
}
?>