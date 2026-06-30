<?php
if($_POST['btnlogin']== 'login'){
    //retrieve form data
}else {
    header ("location:login.php");
}
//TO KNOW IF AN IMPUT IS EMPTY
// if(empty($_POST['username'])){
// echo "empty";
// }
// if($_POST['usertype']==""){
//     echo "empty";
// }
// if(isset($_POST['usertype'])){
//      $user = $_POST["admin_username"];
// }else{
//     $user = "";
// }

if(isset($_POST['usertype'])){
     $user = $_POST["admin_username"];
}else{
    $user = "";
}

?>