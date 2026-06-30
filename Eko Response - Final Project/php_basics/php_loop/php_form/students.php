<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <title>STUDENT BIODATA</title>
</head>
<body>
    <div class="container">
        <div class="rows">
            <div class="col-5 mt-5">
                <form action="bio_action.php" method="post">
                    <div>
                        <label for="fullname">Fullname</label>
                        <input type="text" name="fullname" id="fullname" class="form-control">
                    </div>


                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <div>
                        <label for="phone">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control">
                    </div>

                    <div class="mt-3">
                    <label >Which are your favourite Menu</label>
                    <br>

                    <label for="pizza">Pizza</label> <input type="checkbox" name="food[0]" id="pizza" value="pizza"> <br>
                    <label for="plantain">Plantain</label> <input type="checkbox" name="food[]" id="plantain" value="plantain"><br>
                    <label for="potatoes">Potatoes</label> <input type="checkbox" name="food[]" id="potatoes" value="potatoes"><br>
                    <label for="friedeggs">Fried Eggs</label> <input type="checkbox" name="food[]" id="friedeggs" value="friedeggs"><br>
                    <label for="toastbread">Toast Bread</label> <input type="checkbox" name="food[]" id="toastbread" value="toastbread"><br>
                    <br>
                    <input type="submit" value="submit" name="sub" class="btn btn-primary"> 
                    
                    </div>
                </form>
            </div>
        </div>
    </div>

    
</body>
</html>