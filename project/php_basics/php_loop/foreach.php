<?php
error_reporting(E_ALL);
//associative array

$scores = ["James" => 27, "Samad" => 25, "Sewa" =>30];
$scores["Olu"] = 12;
$scores["Rowland"] = 29;
$scores["Samad"]++;
echo "<pre>";
    print_r($scores);
echo "</pre>";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASSOCIATIVE ARRAY</title>
</head>
<body>
    <div class="container">


    

    <?php
    //the array goes into the bracket
        //IF YOU NEED ONLY THE KEY USE THE METHOD BELOW AND SCHO KEY ALONE;
    //KEY AND VALUE AVAILABLE ON THIS SYNTAX
    //    foreach ($scores as $key => $value) {
    //    echo "<p> $key: $value</p>";
    //    }
    //IF YOU NEED ONLY THE VALUE USE THE METHOD BELOW;
       foreach ($scores as $score => $value) {
       echo "<p>Your score is $score</p>";
       }
    ?>
    
    </div>
</body>
</html>