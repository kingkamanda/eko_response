<?php
error_reporting(E_ALL);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Form Submission</title>
</head>
<body>


<h1>BIO DATA</h1>
<form action="form_submit.php" method="post">
   <div class="col-4"> <label for="name">Fullname</label>
    <input type="text" name="fullname" class="form-control" ></div>

    <div class="col-4">
        <label for="text area">Message</label>
        <textarea name="message" id="message" cols="30" rows="10" class="form-control border-dark"></textarea>
    </div>

    <div class="col-4 mt-5">
        <button type="submit"class="btn btn-primary col-md-12" >Submit</button>
    </div>
</form>


    
</body>

</html>