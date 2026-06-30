<?php
ini_set("display_errors", "1");
    session_start();
    require_once ("../classes/User.php");


    if(isset($_POST["btnupdate"])){
        $fname = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phonenumber"];
        $gender = $_POST["gender"];
        $age = $_POST["age"];
        $address = $_POST["address"];
        $file = $_FILES["profile_pic"];

         if(($file["error"]) != 0){
            $_SESSION['errormsg'] =  "Please Upload a picture!";
            header("location:../update_profile.php");
            die();
        }

        $tmp_name = $file["tmp_name"] ;
        $file_name = $file["name"] ;
        $file_size = $file["size"] ;
        $error =$file["error"] ;
        $file_type =$file["type"] ;

        $max_file_size = 2 * 1024 * 1024;
        if($file_size > $max_file_size){
            $_SESSION['errormsg'] =   "The uploaded file is too large. Maximum file size is 2 MB.";
            header("location:../update_profile.php");
            die();
        }
       
        $allowed_file_types = ["image/jpeg", "image/jpg", "image/png"];
        if(!in_array($file_type, $allowed_file_types)){
            $_SESSION['errormsg'] =   "Invalid file format. Only JPEG, PNG, and JPG files are allowed.";
            header("location:../update_profile.php");
            die();
        }

      
        $r = explode(".",$file_name);
        $newname = time().rand().".".$r[1];
        if(move_uploaded_file($tmp_name, "../uploads/$newname")){
            
        }



      

    if(empty($fname) || empty($email) || empty($phone) || (empty($gender)||$gender=="")|| empty($gender)|| empty($age)||empty($address)){
            $_SESSION['errormsg'] = "All fields are required.";
            header("location:../update_profile.php");
            exit();
        }

        $user = new User;
        $check =  $user -> update_user($fname, $email, $phone, $gender, $age, $address, $newname, $_SESSION['useronline']);
     if($check){
        $_SESSION['feedback'] = 'profile updated!';
        header("location:../user_dashboard.php");
        exit();
     }else{
        $_SESSION['errormsg'] = 'Something bad happened, please try again!';
        header("location:../update_profile.php");
     }

    }else{
        $_SESSION['errormsg']  = "please complete the form!!";
        header("location:../update_profile.php");
        exit();
    }















?>
