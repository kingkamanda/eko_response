<?php
error_reporting(E_ALL);
$i = 1;
while ($i < 6) {
  echo $i;
  $i++;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOR LOOP</title>
</head>
<body>
    <table border= "1">
        <tr>
        <th>
        S/N
        </th> 
        </tr>
        <?php
            for ($x = 1; $x <= 10; $x++) {
                echo "<tr><td>$x</td></tr><br>";
                }

            ?>
           
    </table>



    
</body>
</html>