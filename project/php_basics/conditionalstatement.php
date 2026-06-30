<?php 
error_reporting(E_ALL);
// $age = 25;

//18: you can enter
// if($age >= 18){
//     echo "You can attend the party";
// }else{
//     echo "Go Home";
// }


// $gender = "female";
// if($gender == "male" ){
//     echo "Phones are available";
// }elseif($gender == "female"){
//     echo "shoes are available";
// }else{
//     echo "We dont have your product";
// }


?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conditional Statement to PHP</title>
</head>
<body>
    <?php
        // $guestage = 50;
        // if (($guestage >= 0) && ($guestage <=17)){
        //     echo "Go home";
        // }elseif(($guestage >= 18) && ($guestage <=45)){
        //     echo "Come in";
        // }elseif(($guestage >= 46) && ($guestage <=70)){
        //     echo "Please come in";
        // }else{
        //     echo "sorry go back home";
        // }

        $username = "bizzle";
        $password = "";
        $statement = strlen($username);

        if (($username !=="" ) && ($password !== "") && $statement >=3){
            echo "You are good to go";
        }else{
            echo "failed";
        }




        // elseif(($username < 3)) && (($username !=="")) && ($password !== "abiola")){
        //     echo "failed";

        // }else{
        //     echo "youa re good to go"
        // }
    ?>
</body>
</html>