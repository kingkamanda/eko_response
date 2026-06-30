<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Study one</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <form action="study_submit_form.php" method="post">
                    <div>
                        <label for="fullname">Fullname</label>
                        <input type="text" name="fullname" class="form-control">
                    </div>
                    <div>
                        <select name="gender" id="">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <button type="submit" name="btnsubmit" class="btn btn-danger" >Submit</button>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>