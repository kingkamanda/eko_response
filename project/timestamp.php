//strtotime(): takes a string date and convert to unix tomestamp
<?php
ini_set("display_errors","1");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<h1>format D: <?php echo date("D"); ?></h1>
<h1>format d: <?php echo date("d"); ?></h1>
<h1>format m: <?php echo date("m"); ?></h1>
<h1>format M: <?php echo date("M"); ?></h1>
<h1>format y: <?php echo date("y"); ?></h1>
<h1>format Y: <?php echo date("Y"); ?></h1>
<h1>format h: <?php echo date("h"); ?></h1>
<h1>format D: <?php echo date("D"); ?></h1>
<h1>format i: <?php echo date("i"); ?></h1>
<h1>format s: <?php echo date("s"); ?></h1>
<h1>format l: <?php echo date("l"); ?></h1>

<h1>multiple format: <?$d=strtotime("10:30pm April 15 2014");
echo "Created date is " . date("Y-m-d h:i:sa", $d);?></h1>


<h1> To format a specific date</h1>
<h2>to format 2000-01-20 2:30:21 to show just the year: <?php //echo date("D-M-Y",strtotime(2000-01-20 2:30:21));?></h2> 

    
<!-- TIME ZOME -->

date_default_timezone_set()
</body>
</html>