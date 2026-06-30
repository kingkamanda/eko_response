<?php
session_start();
// Check if user is logged in (optional)
// if (!isset($_SESSION['user'])) {
//     header("Location: login.php");
//     exit();
// }

// Include necessary files
require_once "classes/User.php";
require_once "user_guard.php";
require_once "partials/dashboardhead.php";
$user1 = new User();
$userdata = $user1->get_current_user($_SESSION["useronline"]);
$firstname = $userdata["user_fullname"];
$firstname = ucfirst($firstname);

// echo "<pre>";
// print_r($userdata);
// echo "</pre>";

// Check if user ID is passed (GET method)

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $user = new User();

    // Retrieve user data by ID
    $userdata = $user->get_current_user($user_id);

    // Check if user data is retrieved successfully
    if (!$userdata) {
        // Handle user not found scenario (optional)
        echo "Error: User not found.";
        exit();
    }
}

// Optional: Display error message from session (if set)
if (isset($_SESSION['errormessage'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['errormessage'] . "</div>";
    unset($_SESSION['errormessage']); // Clear error message after display
}
?>

<body>
    <aside class="col-md-2 bg-light sidebar p-3">


        <div class="top">
            <div class="logo">
                <a href="index.php" class="navbar-brand nav__logo">
                    <i class="ri-fire-line"></i>Eko Response
                </a>
            </div>
            <div class="close" id="close_btn">
                <span class="material-symbols-sharp">
                    close
                </span>
            </div>
        </div>
        <!-- <div class="biola"> -->
        <div class="text-center mb-4 ">

            <!-- <img src="uploads/<?php //echo $userdata['user_image'] 
                                    ?>" class="img-fluid" alt="admin image"> -->
            <img src="uploads/<?php echo $userdata['user_image'] ?>" class="img-fluid rounded-circle mt-5" alt="User image" style="width:100px; border-radius:50%;">

            <!-- </div> -->
            <h6><?php echo $firstname ?></h6>
            <b><span>User</span></b>
        </div>
        <!-- </div> -->
        <div>
            <div class="list-group list-holder">
                <!-- <div class="row mt-1">
                        <div class="col-12"> -->
                <!-- <div class="list-group" id="list-tab" role="tablist">
                        <div class="col-sm-2 dashboard-cards shadow-lg p-3 mt-1">  -->
                <a class="list-group-item list-group-item-action " id="list-home-list" data-bs-toggle="list" href="user_dashboard.php" role="tab" aria-controls="list-home"><i class="fas fa-th-large"></i><span class="px-2">Dashboard</span></a>
                <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile"><i class="fa-solid fa-users"></i><span class="px-2">Users</span></a>
                <a class="list-group-item list-group-item-action" id="list-messages-list" data-bs-toggle="list" href="#list-messages" role="tab" aria-controls="list-messages"><i class="fa-solid fa-truck-medical"></i><span class="px-2">Ambulance</span></a>
                <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings"><i class="fa-solid fa-handcuffs"></i><span class="px-2">Police</span></a>
                <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings"><i class="fa-solid fa-star-of-life"></i><span class="px-2">Hospitals</span></a>
                <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings"><i class="fa-solid fa-fire-extinguisher"></i><span class="px-2">Fire Stations</span></a>
                <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="update_profile.php?id=<?php echo $userdata['user_id']; ?>" role="tab" aria-controls="list-settings"><i class="fa-solid fa-user"></i><span class="px-2">Update Profile</span></a>
                <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings"><i class="fa-solid fa-gear"></i><span class="px-2">Settings</span></a>
                <a class="list-group-item " id="list-settings-list" data-bs-toggle="list" href="logout.php" role="tab" aria-controls="list-settings"><i class="fa-solid fa-arrow-right-from-bracket"></i><span class="px-2">Logout</span></a>
            </div>
        </div>
    </aside>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">

                <?php if (isset($_SESSION['errormsg'])) {
                ?>
                    <div class='alert alert-danger'>
                        <p> <?php echo $_SESSION['errormsg'] ?> </p>
                    </div>
                <?php
                    unset($_SESSION['errormsg']);
                }
                ?>

                <?php if (isset($_SESSION['feedback'])) {
                ?>
                    <div class='alert alert-success'>
                        <p> <?php echo $_SESSION['feedback'] ?> </p>
                    </div>
                <?php
                    unset($_SESSION['feedback']);
                }
                ?>
                <form action="./process/process_updateprofile.php" method="post" enctype="multipart/form-data">
                    <br><br><br>
                    <h1>Update Profile</h1>
                    <div class="image_upload">
                        <input type="file" name="profile_pic" id="profile_pic">
                    </div>
                    <br><br>
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo (isset($userdata['user_fullname'])) ? $userdata['user_fullname'] : ""; ?>">
                    <br>
                    <labzel for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo (isset($userdata['user_email'])) ? $userdata['user_email'] : ""; ?>">
                        <br><br>
                        <label for="Name">Phone Number</label>
                        <input type="text" name="phonenumber" id="phonenumber" class="form-control" value="<?php echo (isset($userdata['user_phone'])) ? $userdata['user_phone'] : ""; ?>">
                        <br><br>
                        <label for="Name">Gender</label>
                        <select name="gender" id="gender" class="form-control">
                            <option value="">Select Gender</option>
                            <option value="1" <?php echo (isset($userdata['user_gender']) && $userdata['user_gender'] == 1) ? 'selected' : ''; ?>>Male</option>
                            <option value="2" <?php echo (isset($userdata['user_gender']) && $userdata['user_gender'] == 2) ? 'selected' : ''; ?>>Female</option>
                        </select>
                        <br><br>
                        <label for="age">Age</label>
                        <input type="date" name="age" id="age" class="form-control" value="<?php echo (isset($userdata['user_age'])) ? $userdata['user_age'] : ""; ?>">
                        <br><br>
                        <label for="Name">Address</label>
                        <input type="text" name="address" id="address" class="form-control" value="<?php echo (isset($userdata['user_address'])) ? $userdata['user_address'] : ""; ?>">
                        <input type="hidden" name="id" id="id" class="form-control" value="<?php echo (isset($userdata['user_id'])) ? $userdata['user_id'] : ""; ?>">
                        <br><br>
                        <button type="submit" class="btn btn-primary" name="btnupdate" value="btnupdate">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
    <script src="jquery-3.7.1.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>