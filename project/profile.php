<?php
    session_start();
    require_once("classes/User.php");
    $userid = new User;

   
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
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form action="./process/process_updateprofile.php" method="post">
                <br><br><br>
                <h1>Update Profile</h1>

                <div class="image_upload">
                    <input type="file" name="profile_pic" id="profile_pic">
                </div>
                <br><br>
                 <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control"
                       value="<?php echo (isset($userdata['user_email'])) ? $userdata['user_email'] : ""; ?>">
                <br>
                <labzel for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                       value="<?php echo (isset($userdata['user_email'])) ? $userdata['user_email'] : ""; ?>">
                <br><br>
                <label for="Name">Phone Number</label>
                <input type="text" name="phonenumber" id="phonenumber" class="form-control"
                       value="<?php echo (isset($userdata['user_phone'])) ? $userdata['user_phone'] : ""; ?>">
                <br><br>
                <label for="Name">Gender</label>
                <select name="gender" id="gender" class="form-control">
                    <option value="select">Select Gender</option>
                    <option value="1" <?php echo (isset($userdata['user_gender']) && $userdata['user_gender'] == 1) ? 'selected' : ''; ?>>Male</option>
                    <option value="2" <?php echo (isset($userdata['user_gender']) && $userdata['user_gender'] == 2) ? 'selected' : ''; ?>>Female</option>

                </select>
                <br><br>
                <label for="age">Age</label>
                <input type="date" name="age" id="age" class="form-control"
                       value="<?php echo (isset($userdata['user_age'])) ? $userdata['user_age'] : ""; ?>">
                <br><br>
                <label for="Name">Address</label>
                <input type="text" name="address" id="address" class="form-control"
                       value="<?php echo (isset($userdata['user_address'])) ? $userdata['user_address'] : ""; ?>">

                <input type="hidden" name="id" id="id" class="form-control"
                       value="<?php echo (isset($userdata['user_id'])) ? $userdata['user_id'] : ""; ?>">
                <br><br>

                <button type="submit" class="btn btn-primary" value="btnupdate">Update Profile</button>


            </form>
        </div>
    </div>
</div>
<script src="jquery-3.7.1.js"></script>
</body>
</html>


