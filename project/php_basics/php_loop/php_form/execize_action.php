<?php
error_reporting(E_ALL);



 if(isset($_POST["sub"])){
   die("You must pick at least one source");
   
    
 }else{
    print_r($_POST);
 }
?>
  
<!-- //   if (!isset($_POST["select"])) {
//         die("You must pick at least one source");
//       }


//     if (isset($_POST["select"])) {
//         $select = $_POST["select"];
//             echo"Thank you, you have selected";
//         }

//         echo '<ul>';
//         for ($x=0; $x < count($select); $x++) { 
//             echo "<li> $select[$x] </li>";
//         }
//         echo '</ul>';

// }

if (!isset($_POST["select"])) {
    die("You must pick at least one source");
}
$media = $_POST["select"];
echo "<h1>Thank you, you selected the following:</h1>";
echo "<ul>";
foreach ($media as $med) {
   echo "<li>$med</li>";
}
echo "</ul>";
 } -->
