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

<!-- CLASSWORK 1 -->
<h1>BIO DATA</h1>
<form action="welcome.php" method="post">
   <div class="col-4"> <label for="name">Fullname</label>
    <input type="text" name="fullname" class="form-control" ></div>

    <div class="col-4">
       <label for="gender">Gender:</label>
        <select name="gender" id="gender">
        <option value="">Please select...</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
        </select>
    </div>

    <div class="col-4 mt-5">
        <button type="submit"class="btn btn-primary col-md-12" name="btnsubmit" value="submit">Submit</button>
    </div>
</form>


<div class="container mt-5">
    <div class="row">
        <div class="col-5">
        <form action="newsletter_submit.php" method="post">
            <div class="mb-3">
                <label for="">Enter your name</label>
                <input type="text" name="name"  class="form-control">
            </div>

            <div class="mb-3">
                <label for="">Enter your Email</label>
                <input type="email" name="email"  class="form-control">
            </div>
            <div>
                <input type="submit" value="subscribe" name="btn_news" class="btn btn-danger">
            </div>
        
        </form>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col">
            <form action="welcome.php" method="post">
                <div>
                    <label for="number">Number 1</label>
                    <input type="number" name="number1" >
                
                <label for="number">Number 2</label>
                <input type="number" name="number2" >

                <button type="submit" class="btn btn-danger" name="btnoperator" >Add</button>
                <button type="submit" class="btn btn-success" name="btnoperator" >Subtract</button>
                <button type="submit" class="btn btn-warning" name="btnoperator" >Multiply</button>
                </div>
            
            </form>
        </div>
    </div>
</div>
</body>

</html>