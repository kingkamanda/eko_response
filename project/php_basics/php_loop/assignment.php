<?php
$multiCity = array(
    array("City", "Country", "Continent"),
    array("Tokyo", "Japan", "Asia"),
    array("Mexico City", "Mexico", "North America"),
    array("New York City", "USA", "North America"),
    array("Mumbai", "India", "Asia"),
    array("Seoul", "Korea", "Asia"),
    array("Shanghai", "China", "Asia"),
    array("Lagos", "Nigeria", "Africa"),
    array("Buenos Aires", "Argentina", "South America"),
    array("Cairo", "Egypt", "Africa"),
    array("London", "UK", "Europe")
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Countries Table</title>
</head>

<body>
    <div class="container">
        <h2>Countries </h2> <!-- Table Title -->

        <table class="table">
            <thead class="">
                <tr>
                    <?php foreach ($multiCity[0] as $thead) {
                    ?>
                        <th>
                            <?php
                            echo $thead;
                            ?>
                        </th>
                    <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php

                for ($a = 1; $a < count($multiCity); $a++) {

                ?>
                    <tr>
                        <?php

                        foreach ($multiCity[$a] as $tdata) {

                        ?>
                            <td>
                                <?php
                                echo $tdata;
                                ?>
                            </td>
                        <?php
                        }
                        ?>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>



   <table border = '1'>
   
    <?php
        for ($i=0; $i < count($multicity); $i++) { 
            echo "<tr>";
            foreach($multiCity[$i] as $data){
                 echo "<td>$data</td>";
            }
            echo "</tr>";
             }
    ?>
      </table>
</body>

</html>