<?php 
error_reporting(E_ALL);
//Variables 
$username = "biola";
$age = 400;
$is_married = true;
//CREATE A VARIABLE: final  project:assign the name of your fimal bootcamp project
$final_project = "Eko Response";

//HEREDOC SYNTAX
$first_name = <<< IDENTIFIER
    <h1>HEREDOC</h1>
    <p>This is the syntax for heredoc</p>
    <p>Le'blanche</p>
    <p>the username is  $username</p>

IDENTIFIER;
echo $first_name;



//NOWDOC
$last_name = <<< "IDENTIFIER"
    <h1>NOWDOC</h1>
    <p>This is the syntax for nowdoc</p>
    <p>Le'blanche</p>
    <p>the username is  $username</p>
IDENTIFIER;
echo $last_name;

$username = 156;

echo $username;

//CONSTANT
define("PI", 3.142);
echo PI;

//REUSING CONSTANT IS NOT ALLOWED EG 'PI' IS ALREADY STORING SOMETHING AND CANNOT BE CHANGE
//SAFE WAY TO CREATE A CONSTANT IS TO CHECK IS THE  CONSTANT DOESNT EXIST BEFORE USAGE, SEE SYNTAX BELOW EG
if(!defined("PI")){
    define("P", "i love nigeria");
}

// CONCATENATION
$area = "The area of a circle is circulated using";
$calculation = $area." ".PI;
echo "<br>";
echo $calculation;
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introduction to PHP</title>
</head>
<body>
    <h1>How to output in PHP</h1>
        <ol>
            <li>echo</li>
            <li>print</li>
        </ol>
    <h1><?php echo "Hello World"; ?> </h1>
    <h1><?php print "Hello Earth"; ?> </h1>

    <h1>Display final bootcamp project using single quote</h1>
    <p><?php echo 'My Final bootcamp project is titled $final_project'; ?></p>

    <h1>Display final bootcamp project using double quote</h1>
    <p><?php echo "My Final bootcamp project is titled $final_project"; ?></p>


</body>
</html>