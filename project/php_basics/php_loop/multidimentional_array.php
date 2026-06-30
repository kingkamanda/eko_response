<?php
   //$

   $students =[
                ["semad", 35, "male"],
                ["sewa", 55, "female"],
                ["Maleek", 40, "male"],
                ["chichi", 90, "female", "akara"]
   ];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Name: <?php echo $students[0][0]; ?> Age: <?php echo $students[0][1]; ?> Gender: <?php echo $students[0][2]; ?></p>
        <p>Name: <?php echo $students[1][0]; ?> Age: <?php echo $students[1][1]; ?> Gender: <?php echo $students[0][2]; ?></p>
    <p>Name: <?php echo $students[2][0]; ?> Age: <?php echo $students[2][1]; ?> Gender: <?php echo $students[2][2]; ?></p>


<H1>USING FOR LOOP</H1>
    <?php 
// USING LOOP TO CHECK INSIDE AN ARRAY
        // for ($i=0; $i <count($students); $i++) { 
        //     for ($j=0; $j <count($students[$i]); $j++) { 
        //        echo "<p>". $students[$i][$j] ."</p>";
        //     }
        // }
//ALTERNATIVE
        // for ($i=0; $i <count($students[]); $i++) { 
        //     echo "<p>"
        //     for ($j=0; $j <count($students[$i]); $j++) { 
        //        echo $students[$i][$j] .":";
        //     }
        //     echo "</p>";
        // }


        foreach ($students as $st) { 
        //    echo "<p>" $st[0] $st[1] $st[2]"</p>";
        echo "<p>";
        for ($x=0; $x < count($st); $x++) { 
            echo $st[$x]. "  ";
        }
        echo "</p>"
        }
    ?>
</body>
</html>