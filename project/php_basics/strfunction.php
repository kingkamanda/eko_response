<?php 
error_reporting(E_ALL);

$story = "Hello World, greeting from Mars";
//TO RETURN THE LENGTH OF THE STRING BELOW strlen(): length of a string/letter
echo strlen("Hello World");
$len = strlen("Hello World"); 

//str_word_count() counts the words
$countword = str_word_count($story);

//str_rev stands for reverse
$reverse_string = strrev($story);
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introduction to PHP</title>
</head>
<body>
    <p> <?php echo $story;?></p>

    <h1>The length of the string: Hello World is:<?php echo $len;?></h1>
    <h2>The number of word we have in the variable is:<?php echo $countword;?></h2>
    <h3>The Reverse version of the story is: <?php echo $reverse_string;?></h3>
</body>
</html>