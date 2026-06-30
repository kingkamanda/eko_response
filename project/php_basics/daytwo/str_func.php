<?php 
error_reporting(E_ALL);
//BUILT IN FUCTION, Used to check if a variable is empty
// $username = "";

// if($username == ""){
//     echo "username is required";
// }
// //ALTERNATIVE
// if (empty($username)) {
//     echo "username is required";
// }


//BUILT IN FUNCTION
//THIS FUCNTION ENABLES US TO SEARCH FOR A WORD
//echo strpos("Hello world greetings from Mars", "world");

$story = "American Gangster accurately depicts the rise and fall of crime boss Frank Lucas, showcasing his brutal nature and 
empire-building techniques. Lucas's heroin smuggling operation, facilitated by a retired Army sergeant, generated over $400 million and involved US soldiers and creative smuggling methods.";
// 1 strpos
// echo strpos($story, "accurately");
// 1. if the word is there it will return the position.
// 2. if its not there it will return false
// strpos is case sensitive
// if (strpos($story, "crime")) {
//     echo "you have been banned";
// }else{
//     echo "you are good";
// }
//2. stripos
//its isnt case sensitive
// if (stripos($story, "crime")) {
//     echo "you have been banned";
// }else{
//     echo "you are good";
// }

//stripos OR stripos
//replaces the word with "good, $story"; 
// $good_story= str_replace("crime", "good" $story); //what to replace, replace with what, where to replace;
// //str_replace is case sensitive
// echo $good_story;

$what_is_on_your_mind = "Once upon a time in the land of myths. there lives a boy in the myth land";
$what_is_really_on_your_mind =str_replace("myth", "legend", $what_is_on_your_mind );
echo $what_is_really_on_your_mind;
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
</body>
</html>