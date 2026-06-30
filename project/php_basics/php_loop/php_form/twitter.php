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
            <form action="twitter_submit.php" method="post" class="col-5">
                <div class="mb-3">
                    <textarea name="tweet" id="" cols="30" rows="10"></textarea>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-success" name="btntweet" value="login" > Tweet!</button>
                </div>
            </form>
            </div>
        </div>
    
    </div>
</body>
</html>