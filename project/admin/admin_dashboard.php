<?php
ini_set("display_errors", "1");
session_start();
require_once "admin_guard.php";
require_once "./classes/Admin.php";

$admin1 = new  Admin();
$fetchuser = $admin1->fetch_users();
$sn = 1;

//$deleteuser = $admin1->delete_user($user_id);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./assets/static/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/static/dashboard2.css">
    <link rel="stylesheet" type="text/css" href="./fontawesome/css/all.min.css">
    <!-- ======REMIX ICON======== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/static/bootstrap/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="animate.min.css"> -->

    <!--=========GOOGLE FONTS===========-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!--=========GOOGLE ICONS===========-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Administrators Dashboard</title>
    <style>
        /* .sidebar-footer {
    position: absolute;
    bottom: 20px;
    left: 20px;
    right: 20px;
    text-align: center;
}

.sidebar-footer a {
    color: #fff;
} */
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay">
        </div>
        <!--=========== SIDE BAR============= -->
        <div id="sidebar">
            <div class="sidebar">
                <a href="#" class="nav__logo">
                    <i class="ri-fire-line"></i>Eko Response
                </a>
            </div>
            <ul class="list-unstyled component m-0">
                <li class="active">
                    <a href="admin_dashboard.php" class="dashboard"><i class="material-icons">
                            dashboard
                        </i>dashboard</a>
                </li>
                <li class="dropdown">
                    <a href="#homesubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="material-icons">aspect_ration</i>Manage Emergency
                    </a>
                    <ul class="collapse list-unstyled menu" id="homesubmenu1">
                        <li><a href="">layout 1</a></li>
                        <li><a href="">layout 2</a></li>
                        <li><a href="">layout 3</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#homesubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="material-icons">apps</i>User
                    </a>
                    <ul class="collapse list-unstyled menu" id="homesubmenu1">
                        <li><a href="">App 1</a></li>
                        <li><a href="">App 2</a></li>
                        <li><a href="">App 3</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#homesubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="material-icons">equalizer</i>Analysis
                    </a>
                    <ul class="collapse list-unstyled menu" id="homesubmenu1">
                        <li><a href="">Page 1</a></li>
                        <li><a href="">Page 2</a></li>
                        <li><a href="">Page 3</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#homesubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="material-icons">extension</i>Settings
                    </a>
                    <ul class="collapse list-unstyled menu" id="homesubmenu1">
                        <li><a href="">app 1</a></li>
                        <li><a href="">app 2</a></li>
                        <li><a href="">app 3</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#homesubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="material-icons">border_color</i>forms
                    </a>
                    <ul class="collapse list-unstyled menu" id="homesubmenu1">
                        <li><a href="">App 1</a></li>
                        <li><a href="">App 2</a></li>
                        <li><a href="">App 3</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#homesubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="material-icons">grid_on</i>tables
                    </a>
                    <ul class="collapse list-unstyled menu" id="homesubmenu1">
                        <li><a href="">Page 1</a></li>
                        <li><a href="">Page 2</a></li>
                        <li><a href="">Page 3</a></li>
                    </ul>
                </li>

                
            </ul>
        </div>
        <!--=========== SIDE BAR DESIGN END============= -->

        <!--=========== PAGE CONTENT============= -->

        <div id="content">
            <!--===========TOP NAV BAR START============= -->
            <div class="top-navbar">
                <div class="xd-topbar">
                    <div class="row">
                        <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                            <div class="xp-menubar">
                                <span class="material-icons text-white">signal_cellular_alt</span>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-3 order-3 order-md-2">
                            <div class="xp-searchbar">
                                <form>
                                    <div class="input-group">
                                        <input type="search" class="form-control" placeholder="search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success" id="button-addon2">Go</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
                            <div class="xp-profilebar text-right">
                                <nav class="navbar p-0">
                                    <ul class="nav navbar-nav flex-row ml-auto">
                                        <li class="downdown nav-item active">
                                            <a href="#" class="nav-link" data-toggle="dropdown">
                                                <span class="material-icons">notifications</span><span class="notification">4</span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">You Have 4 New Messages</a></li>
                                                <li><a href="#">You Have 4 New Messages</a></li>
                                                <li><a href="#">You Have 4 New Messages</a></li>
                                                <li><a href="#">You Have 4 New Messages</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">
                                                <span class="material-icons">question_answer</span>
                                            </a>
                                        </li>

                                        <li class="downdown nav-item">
                                            <a class="nav-link" href="#" data-toggle="dropdown">
                                                <img src="./assets/static/images/profile_pics1.jpg" style="width:40px; border-radius:50%" ; class="" alt="admin image">
                                                <span class="xp-user-live"></span>
                                            </a>
                                            <ul class="dropdown-menu small-menu">
                                                <li><a href="#"><span class="material-icons">person_outline</span>Profile
                                                    </a></li>
                                                <li><a href="#"><span class="material-icons">settings</span>Settings
                                                    </a></li>
                                                <li><a href="admin_logout.php"><span class="material-icons">logout</span>Logout
                                                    </a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="xp-breadcrumbbar text-center">
                        <h4 class="page-title">Admin Dashboard</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Eko Response</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!--==============TOP NAVBAR END=============-->
            <!--==============MAIN CONTENT-START=============-->
            <div class="main-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="row">
                                    <div class="cl-sm-6 p-0 flex justify-content-lg-start justify-content-center">
                                        <h2 class="ml-lg-2">Manage Users</h2>
                                    </div>
                                    <div class="col-sm-6 p-0 flex justify-content-lg-end justify-content-center">
                                        <a href="#addUserModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i><span>Add New User</span></a>
                                        <a href="#deleteUserModal" class="btn btn-danger" data-toggle="modal"><i class="material-icons">&#xE147;</i><span>Delete User</span></a>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><span class="customer-checkbox">
                                                <input type="checkbox" id="selectAll">
                                                <label for="selectAll"></label></th>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Gender</th>
                                        <th>State of Origin</th>
                                        <th>DOB</th>
                                        <th>Login date</th>
                                        <th>User Profile Picture</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <?php
                                foreach ($fetchuser as $users) {
                                    $username = $users['user_fullname'];
                                    $useremail = $users['user_email'];
                                    $userphone = $users['user_phone'];
                                    $usergender = $users['user_gender'];
                                    $userpassword = $users['user_pwd'];
                                    $userage = $users['user_age'];
                                    $useraddy = $users['user_address'];
                                    $userdatereg = $users['user_date_registered'];
                                    $userstateid = $users['state_id'];
                                    $userpp = $users['user_image'];

                                ?>
                                    <tbody>
                                        <tr>
                                            <td><span class="customer-checkbox">
                                                    <input type="checkbox" id="checkbox" name="option[]" value="1">
                                                    <label for="checkbox"></label></td>
                                            <td><?php echo $sn++; ?></td>
                                            <td><?php echo $username; ?></td>
                                            <td><?php echo $useremail; ?></td>
                                            <td><?php echo $userphone; ?></td>
                                            <td><?php echo $useraddy; ?></td>
                                            <td><?php echo $usergender; ?></td>
                                            <td><?php echo $userstateid; ?></td>
                                            <td><?php echo $userage; ?></td>
                                            <td><?php echo $userdatereg; ?></td>
                                            <td><img src="../uploads/<?php echo $userpp; ?>" alt="User Profile Picture" width="50px" height="50px"></td>
                                            <td>
                                                <!-- <a href="#editUserModal" class="edit" data-toggle="modal">
                                                    <i class="material-icons" data-toggle="tooltip" title="edit">&#xE254;</i>
                                                </a>
                                                <a href="#deleteUserModal" class="delete" data-toggle="modal">
                                                    <i class="material-icons" data-toggle="tooltip" title="delete">&#xE872;</i>

                                                </a> -->
                                                <form action="delete.php" method="post">
                                                    <input type="text" name="add" value="<?php echo $users['user_id']; ?>" hidden>
                                                    <input type="text" name="delete" value="<?php echo $users['user_id']; ?>" hidden>
                                                    <input type="submit" value="add" id="add" class="btn btn-success btn-sm">
                                                    <input type="submit" value="delete" id="delete" class="btn btn-danger btn-sm">
                                                </form>
                                            </td>
                                        </tr>


                                    </tbody>
                                <?php
                                }
                                ?>
                            </table>
                            <div class="clearfix">
                                <div class="hint-text">showing <b>5</b> out of <b>25</b></div>
                                <ul class="pagination">
                                    <li class="page-link"><a href="#" class="page-link">Previous</a></li>
                                    <li class="page-link active"><a href="#" class="page-link">1</a></li>
                                    <li class="page-link"><a href="#" class="page-link">2</a></li>
                                    <li class="page-link"><a href="#" class="page-link">3</a></li>
                                    <li class="page-link"><a href="#" class="page-link">4</a></li>
                                    <li class="page-link"><a href="#" class="page-link">5</a></li>
                                    <li class="page-link"><a href="#" class="page-link">Next</a></li>
                                </ul>
                            </div>


                            <!-- add modal start -->
                            <div class="modal fade" tabindex="-1" id="addUserModal" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add User</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input type="text" name="" id="" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" name="" id="" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <textarea name="" id="" cols="" rows="" class="form-control" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" name="" id="" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Phone</label>
                                                <input type="email" name="" id="" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-success">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- add modal end -->

                            <!-- edit modal start -->
                            <div class="modal fade" tabindex="-1" id="editUserModal" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit User</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input type="text" name="" id="" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" name="" id="" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Address</label>
                                                <textarea name="" id="" cols="" rows="" class="form-control" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" name="" id="" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Phone</label>
                                                <input type="email" name="" id="" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-success">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- delete modal end -->
                        </div>
                    </div>
                </div>
            </div>
            <!--==============MAIN CONTENT-END=============-->
            <!-- =============FOOTER-DESIGN ================-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="footer-in">
                        <p class="mb-0">2024 BiolaBizzle Design. All Right Reserved</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>






    <script src="./assets/jquery-3.7.1.js"></script>
    <script src="./assets/static/jquery-3.3.1.slim.min.js"></script>
    <script src="./assets/jquery-3.3.1.min.js"></script>
    <script src="./assets/popper.min.js"></script>
    <script src="./assets/bootstrap.min.js"></script>
    <script src="./assets/bootstrap/js/bootstrap.bundle.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".xp-menubar").on('click', function() {
                $("#sidebar").toggleClass('active');
                $("#content").toggleClass('active');
            });

            $(".xp-menubar, .body-overlay").on('click', function() {
                $("#sidebar, .body-overlay").toggleClass('show-nav  ');
            });

        

        $('#add').click(function(){
            setTimeout(function(){
                alert("User Has been activated")
            })
            
            
        })

         $('#delete').click(function(){
            setTimeout(function(){
                alert("User Has been deactivated")
            })
            
            
        })

        });

    </script>
</body>

</html>
