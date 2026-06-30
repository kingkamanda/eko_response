<?php
if($_POST){
    
    $state = $_POST;
   foreach($state as $key=>$value){
  
        require_once "classes/State.php";
        $states = new State;
        $lgas = $states->getLocalGovernment($key);
        echo json_encode($lgas);
   }
   }else{
        header("location:login_signup.php");
    }



?>