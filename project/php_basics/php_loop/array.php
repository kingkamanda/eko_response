<?php
// array()




//Malik, Joshua, Racheal, Amanda
//1ST METHOD OF CREATING AN ARRAY
$students = array("Malik", "Joshua", "Racheal", "Amanda");

//print_r($students);
//2ND METHOD OF CREATING AN ARRAY

$fav_fruits = ["Apple", "Banana", "Strawberry", "Avocado"];
//print_r($fav_fruits);

//3RD METHOD OF CREATING AN ARRAY
$cars = [
    10=> "Mercedes Benz",
    20=> "Porsh",
    30=> "Toyota",
    40=> "Honda",
    50=> "Mazeratti",
    60=> "Bugatti",
];
echo"<pre>";
//var_dump($cars); //gives more infomation about the data
echo"</pre>";
//4TH METHOD OF CREATING AN ARRAY

$cities = [];
$cities[0] = "Lagos";
$cities[1] = "Ibadan";
$cities[2] = "Enugu";
$cities[3] = "Kano";
$cities[4] = "Port Harcourt";
$cities[5] = "Benin";

echo "<pre>"; //formats an array
//print_r($cities);
echo "</pre>";




$weather_condition = [
    10=> "rain",
    20=> "sunshine",
    30=> "cloud",
    40=> "hail",
    50=> "sleet",
    60=> "snow",
    70=> "wind",
];

echo "<pre>"; //formats an array
//print_r($weather_condition);
echo "</pre>";

//echo count($weather_condition); //tells us the length and number of an array

//CLASS WORK
$subjects = [
    1=> "English",
    2=> "Maths",
    3=> "Crk",
];

echo "<h1>Loop way of displaying elements in array</h1>";


$num = count($subjects);
for ($p = 1; $p < $num; $p++) {
    echo "<p>$subjects[$p]</p>";
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARRAY</title>
</head>
<body>
    <!-- <h1>My Favourite Students</h1>
    <p><?php //echo $students[0]?></p>
    <p><?php // echo $students[1]?></p>
    <p><?php // echo $students[2]?></p>
    <p><?php // echo $students[3]?></p>

    <p>We've seen all kinds of weather this month. At the beginning of the month, we had  <?php echo $weather_condition[60]?> and <?php echo $weather_condition[70]?>. Then came <?php echo $weather_condition[20]?> with a few <?php echo $weather_condition[30]?> and some <?php echo $weather_condition[10]?>. At least we didn't get any <?php echo $weather_condition[40]?> or <?php echo $weather_condition[50]?> </p> -->

    <p><?php //echo $subjects[1] ?></p>
    <p><?php //echo $subjects[2] ?></p>
    <p><?php //echo $subjects[3] ?></p>
</body>
</html>