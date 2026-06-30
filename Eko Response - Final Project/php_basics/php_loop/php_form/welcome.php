<?php
ini_set("display_errors", "1");

// //retieve form data
// if ($_POST['btnsubmit']) {
//     $fullname = $_POST['fullname'];
//     $gender = $_POST['gender'];
// }else {
//     header("location:classquiz1.php");
// }

// if ($_POST['btnsubmit']) {
//     $name = $_POST['fullname'];
//     $gender = $_POST['gender'];
// } else {
//     header['location:classquiz.php'];
// }

if ($_POST[btnoperator]) {
    $numberone = $_POST("number1");
    $numbertwo = $_POST("number");
} else {
    header("location:classquiz1.php");
}













?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Page</title>
</head>
<body>
<!-- <p><?php echo "weldone".$name;?> </p>
<?php
    if ($gender == "female") {
       echo "<img src='female_avatar.png' width='200'> ";
    }elseif ($gender == "male") {
        echo "<img src='male_avatar.png' width='200'> ";
    }
       
?> -->






<!-- <p><?php echo $name;?></p>

<?php 
//if ($gender == "female") {
    echo "<img src='female_avatar.png' >";
//} //elseif ($gender == "male") {
    echo "<img src='male_avatar.png'>";
//}



?> -->


</body>
</html>

