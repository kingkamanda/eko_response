<?php 
error_reporting(E_ALL);

//USING RETURN STATEMENT
// function final_project($project_name){
//     return "My final bootcamp project is $project_name";
// }


// function accepts($num1 , $num2){
//     return $num1 * $num2;
// }
// // $pro = accepts(10, 5) this means you are recieving in a variable


// function funk_2($num1 , $num2){
//     return $num1 * $num2;
// }




function gender_ish(){
    
    switch($gender){
    case 'female':
    return "Hi Lady we have shoes and bags for sale";
    break;

    case 'male':
    return "Gentleman, we have clipper for sale";
    break;

    default:
    return "Can we meet you?";
    
};
}
echo  gender_ish("male");
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Statement</title>
</head>
<body>
    <!-- <h1> <?php //echo
   // final_project("Eko Response");
    
    ?> </h1>

    <h1> <?php //echo accepts(10 , 5);
    
    ?> </h1>

    <h1> <?php //echo funk_2(10 , 5);
    
    ?> </h1> -->
</body>
</html>