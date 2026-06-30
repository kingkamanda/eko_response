<?php
ini_set("display_errors", "1");
    if ($_POST['btnsubmit']) {
        $name = $_POST("fullname");
        $gender = $_POST("gender");
    } else {
       header ('location:study_form.php');
    }
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<p><?php echo "Welcome" . $name; ?></p>

    <?php
        if ($gender == 'female') {
            echo "Hi";
        }



    ?>
    
</body>
</html>