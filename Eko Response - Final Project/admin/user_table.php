<?php
session_start();
require_once "./classes/Admin.php";
//require_once "admin_guard.php";
$admin1 = new  Admin();
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
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>Administrators Dashboard</title>
    </head>

    <body>
        
        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                            <th><span class="customer-checkbox">
                            <input type="checkbox" id="selectAll">
                            <label for="selectAll"></label></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Login date</th>
                            <th>Action</th>
                            </tr>
                            </thead>
                            <?php
                            $users = new Admin();
                            $result = $users->fetch_users();
                            $sn =1;
                            foreach($result as $r){
                            ?>

                            <tbody>
                            <tr>
                            <th><span class="customer-checkbox">
                            <input type="checkbox" id="checkbox" name="option[]" value="1">
                            <label for="checkbox"></label></th>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $r['user_fname']." ".$r['user_lname']; ?></td>
                            <td><?php echo $r['user_email']; ?></td>
                            <td><?php echo $r['user_gender']; ?></td>
                            <td><?php echo $r['user_state']; ?></td>
                
                            <td><a href="#editUserModal" class="edit" data-toggle="modal">
                            <i class="material-icons" data-toggle="tooltip" title="edit">&#xE254;</i>
                            </a>
                            <a href="#deleteUserModal" class="delete" data-toggle="modal">
                            <i class="material-icons" data-toggle="tooltip" title="delete">&#xE872;</i>
                            </a>
                            </td>
                            </tr>
                            </tbody>
                            <?php
                                }
                            ?>

                            </table>
                         </body>