<?php
ini_set("display_errors", "1");
require_once "sanitizer.php";
if ($_POST["sub"]) {
  
  $fullname = sanitizer($_POST['fullname']);
  $email = ($_POST['email']);
  $phone = ($_POST['phone']);
    //
//   $favfood = ($_POST['food']);

  //Check the checkbox value first
  //if its compulsory the pick one
  if (!isset($_POST["food"])) {
        die("sorry you just have to pick a food");
      }


    if (isset($_POST["food"])) {
        $favfood = $_POST["food"];
            echo"You have selected";
        }

        echo '<ul>';
        for ($i=0; $i < count($favfood); $i++) { 
            echo "<li> $favfood[$i] </li>";
        }
        echo '</ul>';

}else {
    header('location:students.php');
}

?>