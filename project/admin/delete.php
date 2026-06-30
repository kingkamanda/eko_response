

<?php

require_once "classes/Admin.php";

$delete = $_POST['delete'];

// print_r($delete);

$da = new Admin;
$deactivate = $da->deactivate_user($delete);
$activate= $da->activate_user($delete);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Changes Have been made click <a href="admin_dashboard.php">Here</a> to go back to dashboard</p>
</body>
</html>