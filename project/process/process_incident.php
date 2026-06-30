<?php
ini_set("displayerrors", "1");
session_start();
require_once "../classes/Emergency.php";


//  echo"<pre>";
//  print_r($_FILES);
//   print_r($_POST);
//     die();
//  echo"</pre>";
  

if (isset($_POST['btnform'])) {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $lga = $_POST['lga'];
    $emergency = $_POST['emergency_type'];
    $status = $_POST['status'];
    $time = $_POST['time'];
    $incident_img = $_FILES['imageUpload'];
    $incident_vid = $_FILES['videoUpload'];
    $description = $_POST['desc'];

// echo"<pre>";
//       print_r($_POST);
//      die();  
// echo"</pre>";


  
    // if (empty($fullname) || empty($phone)||empty($location)||$emergency==""||$status==""||empty($time)||empty($incident_img)||empty($incident_vid)||empty($description)) {
    //     $_SESSION['essormsg'] = "All fields are required";
    //     header("location:../emergency_form.php");
    //         exit();
    // }

    $incident = new Incident();
    $check = $incident->addIncident($fullname, $phone, $location, $emergency, $status, $time, $incident_img, $incident_vid, $description, $lga);

    $loc = $check;

  

    switch ($emergency) {

        case 4:
            header("Location: ../police.php?loc=$loc");
            break;
        case 3:
            header("Location: ../Ambulance.php?loc=$loc");
            break;
        case 2:
            header("Location: ../fire.php?loc=$loc");
            break;
        case 1:
            header("Location: ../hospital.php?loc=$loc");
            break;    
        
    }





    
//    if ($emergency =4) {
//     $loc = $check;
//     header("location: ../police.php?loc=$loc");
// }elseif ($emergency ===  2) {
//     $loc = $check;
//     header("location: ../fire.php?loc=$loc");    
// }elseif ($emergency ===  1) {
//     $loc = $check;
//     header("location: ../hospital.php?loc=$loc");
//     exit;
    
// }else {
//     echo "Pick an Emergency";
// }
    // if ($check) {
    //         $_SESSION['useronline'] = $check;
    //         header('location:../thankyou.php');
    //         echo "<pre>";
    //         print_r($check);
    //         echo  "</pre>";
    //     } 
        // else {
        //     header('location:../index.php');
        // } 
}



?>