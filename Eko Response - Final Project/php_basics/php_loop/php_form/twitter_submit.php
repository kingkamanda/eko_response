<?php
error_reporting(E_ALL);
// CORRECTION
if ($_POST['btntweet']) {
    //RETRIEVE FORM DATA
    $textarea = $_POST['tweet'];

    $location = strpos($textarea, "terrorist");
    if($location !==false ){
        echo "Your tweet is forbidden";
    }else {
        echo"Your tweet has been sent to your followers";
    }
}else {
   header("location:login.php");
   exit();
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
            // ATTEMPT
            //    if (($textarea === "terrorist")){
            //         echo "<p>That is a forbidden word</p>";
            //      } else {
            //        echo"<p>Tweet posted successfully</p>";

            //      }


    ?>
</body>
</html>