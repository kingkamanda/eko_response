    <?php
    // session_start();
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";
    // die();

    #instantiate the class
    $user1 = new User();
    $userdata = $user1->get_current_user($_SESSION["useronline"]);

    $firstname = $userdata["user_fullname"];
    $firstname = ucfirst($firstname);
    ?>

    <div class="container-fluid">
        <!-- <div class="row dash-profile p-2"> -->
        <div class="row">
            <!-- <div class="col-md-6" style="width: 100%;"> -->
            <div class="col-sm-2 bg-light sidebar p-3">
                <!-- <div class="col text-center d-flex flex-column align-items-center">
                <div class="biola"> -->
                <div class="text-center mb-4">

                    <!-- <img src="uploads/<?php //echo $userdata['user_image'] 
                                            ?>" class="img-fluid" alt="admin image"> -->
                    <img src="uploads/<?php echo $userdata['user_image'] ?>" class="img-fluid rounded-circle mb-2" alt="admin image">

                    <!-- </div> -->
                    <h6><?php echo $firstname ?></h6>
                    <span>User</span>
                </div>
                <!-- </div> -->
                <div>
                    <!-- <div class="admin-nav" style="min-height: 50px;">
            <div class="mt-1"> -->
                    <h5> <span>NAVIGATION</span> </h5>
                    <!-- </div> -->
                    <div class="list-group">
                        <!-- <div class="row mt-1">
                <div class="col-12"> -->
                        <!-- <div class="list-group" id="list-tab" role="tablist">
                        <div class="col-sm-2 dashboard-cards shadow-lg p-3 mt-1">  -->
                        <a class="list-group-item list-group-item-action " id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab" aria-controls="list-home"><i class="fas fa-th-large"></i><span class="px-2">Dashboard</span></a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile"><i class="fa-solid fa-users"></i><span class="px-2">Users</span></a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-bs-toggle="list" href="#list-messages" role="tab" aria-controls="list-messages"><i class="fa-solid fa-user-tie"></i><span class="px-2">Agents</span></a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings"><i class="fa-solid fa-building-shield"></i></i><span class="px-2">Police</span></a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings"><i class="fa-solid fa-hospital"></i><span class="px-2">Hospitals</span></a>
                        <a class="list-group-item list-group-item-action" id="list-settings-list" data-bs-toggle="list" href="#list-settings" role="tab" aria-controls="list-settings"><i class="fa-solid fa-fire-extinguisher"></i><span class="px-2">Fire Stations</span></a>
                    </div>
                </div>
    </div>

            <!-- <div class="sidebar-footer">
                            <a href="#"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div> -->

            <!-- </div>
        </div>

    </div>
    </div> -->