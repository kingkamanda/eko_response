<?php
ini_set("display_errors", "1");
    echo '<pre>';
    print_r($_SERVER);
    echo '</pre>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>REQUEST_METHOD:<?php echo $_SERVER['REQUEST_METHOD']?></h1>
        <h1>REQUEST_METHOD:<?php echo $_SERVER['REQUEST_ADDR']?></h1>
    <h1>REQUEST_METHOD:<?php echo $_SERVER['REQUEST_METHOD']?></h1>

</body>
</html>