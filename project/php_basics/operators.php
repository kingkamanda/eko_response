<?php 
error_reporting(E_ALL);
$x = 5;

$y = 3;

$q = "5";

$ans = $x + $y;
$ans1 = $x - $y;
$ans2 = $x * $y;
$ans3 = $x / $y;

$ans4 = $x=$x+$y;
$ans5 = $x=$x-$y;

//Updating the variable 
$age = 25;
$age = $age + 10;

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introduction to PHP</title>
</head>
<body>
    <h1><?php echo "The answer to the operation above is $ans"; ?></h1>
    <h1><?php echo "The answer to the operation above is $ans1"; ?></h1>
    <h1><?php echo "The answer to the operation above is $ans2"; ?></h1>
    <h1><?php echo "The answer to the operation above is $ans3"; ?></h1>
    <h1><?php echo "The answer to the operation above is $ans4"; ?></h1>
    <h1><?php echo "The answer to the operation above is $ans5"; ?></h1>


    <h1>X is greater than Y:<?php echo $x > $y; ?></h1>
    <h1>X is less than Y:<?php echo $x < $y; ?></h1>
    <h1>X is equal to Q:<?php echo $x == $q; ?></h1>
    <h1>X is equal to Q and also the same type:<?php echo $x === $q; ?></h1>

    <h1>In PHP we have preincrement: <?php //echo ++$x; ?></h1>
    <!-- it will echo x before perfoming the increment fucntion -->
    <h1>In PHP we have postincrement: <?php echo $x++; ?></h1> 
    <h1>after: <?php echo $x;?></h5>


    <h1>predecrement <?php echo--$y; ?></h1>
        <h1>postdecrement <?php echo $y--; ?></h1>
        <h1>after <?php echo $y; ?></h1>

    <!-- UPDATING A VARIABLE -->
            <h1>Age after 10 years is: <?php echo $age; ?></h1>


</body>
</html>