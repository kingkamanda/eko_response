<?php
error_reporting(E_ALL);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DO WHILE LOOP</title>
</head>
<body>
<!-- DOWHILE LOOP SYNTAX
$= VARABLE;
do{
	//Block of code goes here

}while(condition); -->

<?php
$i = 1;

do {
  echo "<p>$i</p>";
  $i++;
} while ($i <= 10);
?>
    
</body>
</html>