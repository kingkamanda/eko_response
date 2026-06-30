<?php 
ini_set("display_errors", "1");
// SANITIZER BEGINS
require_once "sanitizer.php";
$safe_msg = sanitizer($msg);
echo $safe_msg;
// SANITIZER ENDS


if ($_POST["sub"]) {
    $msg = $_POST["message"];
    //echo "unsafe input says:" . $msg;
    echo "<br>";
    // $safe_msg = strip_tags($msg["i", "<strong>"]);
   
    //htmlspecialchars
// $safe_msg = htmlspecialchars($msg);
    //htmlspecialchars()
    // $safe_msg = trim($msg);
    // $safe_msg = ucfirst($safe_msg);
    // $safe_msg = ucwords($safe_msg);
    
    // $safe_msg = trim($msg);
    // $safe_msg = str_replace(" ", "_" , $safe_msg);
    //  echo "safe input say:" . $safe_msg;
    // THEN CALL THE FUNCTION HERE
    
}
// else {
//    header["location:securing_form_data.php"];
// }


// $story = "Mr God's power came yesterday";

// $story = addslashes($story);
// echo stripslashes($story);

// echo $story;



// $evilstring ="Arsenal Will win the league";
// echo  sanitizer($evilstring);




//WRITING IT INSIDE A TXT FILE AND GIVE THEM A RESPONSE

$filename = "messanger.txt";
$resp = file_put_contents($filename, $safe_msg, FILE_APPEND);

if ($resp) {
    echo "Message delivery successfully";
    }else {
        echo "Message not delivery";
    }





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php   


?>
    
</body>
</html>