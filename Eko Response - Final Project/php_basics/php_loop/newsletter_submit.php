<?php



if ($_POST['btn_news']) {
    //RETRIEVE FORM DATA
    $fullname = $_POST['name'];
    $email = $_POST['email'];
}else {
    header("location:classquiz1.php");
    exit();
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
    <div class="container">
        <div class="row">
            <div class="col">
            
                <?php
                //ATTEMPT
                // if (($fullname == "") || ($email =="")){
                //     echo "<p>Your form could not be submitted, the following fields were empty:Name, Email Please <a href=''>click here </a>to try again</p>";
                // } else {
                //     echo"<p>Your email, $email has been added to our subscription list.</p>";
                // }
                
                    //CORRECTION
                    if (($fullname !="") && ($email !="")) {
                        echo "Thank you, your email $email, has been added to our mailing list";
                    } else {
                        $error ="<p>your form was not submitted, please complete the following fields:</p>";
                        if ($email =="") {
                            $error = $error . "<p>Email</p>";
                        }
                         if ($fullname =="") {
                            $error = $error . "<p>Name</p>";
                        }
                        echo error. "<p> <a href=''>Click here to try again</a></p> ";
                    }
                    

                ?>
            </div>
        
        </div>
    
    </div>
</body>
</html>