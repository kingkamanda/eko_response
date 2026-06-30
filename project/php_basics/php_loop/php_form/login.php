<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Login Form</title>
</head>
<body>
<!-- USING RADIO -->
    <div class="container">
        <div class="row">
            <div class="col">
            <h2>Login Form</h2>
            <form action="submit_login.php" method="post" class="col-5">
                <div class="mb-3">
                    <label for="username" >Username</label>
                    <input type="text" name="username" class="form-control" >
                </div>

                 <div class="mb-3">
                    <label for="password" >Username</label>
                    <input type="text" name="pwd" class="form-control" >
                </div>

                <div class="mb-3">
                    <label >User type</label>
                    <input type="radio" name="usertype" value="student" >   Student
                    <input type="radio" name="usertype" value="parent" >    Parent
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success" name="btnname" value="login" > Login!</button>
                </div>
            </form>
            </div>
        </div>
    
    </div>
</body>
</html>