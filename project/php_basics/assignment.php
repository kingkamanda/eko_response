<?php 
error_reporting(E_ALL);




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

    $candidate_age = 70;
    $candidate_party = "apc";
if (($candidate_age == 80) || ($candidate_party == "apc")) {
    echo "<script>alert('You are eligible to contest')</script>";
} else {
    echo "<br><h1>You are not eligible to contest</h1>";
}   
    ?>

    
    
</body>
</html>