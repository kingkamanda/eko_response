
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ======REMIX ICON======== -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,700,0,200" />
    <link rel="stylesheet" type="text/css" href="assets/static/bootstrap/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

    <!-- <link rel="stylesheet" href="animate.min.css"> -->
    <!--============== CSS================ -->
    <link rel="stylesheet" href="assets/static/css/emergency.css">
    <link rel="stylesheet" type="text/css" href="assets/static/fontawesome/css/all.min.css">

    <title>Welcome to Eko Response - Sign up</title>
</head>
<style>
div{
    /* border: 2px solid red; */
}

.container-fluid{
    background-color: #FFFFFF;
}
.emergency-button {
    text-align: center;
}

.emergency-button .btn {
    font-size: 2rem;
    padding: 1rem;
    width: 5rem;
    height: 5rem;
}

.card {
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); 
}

.card-body {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.card-body:active{
    bottom: 16px;
    right: 8px;
    box-shadow: none;
}

.card-title {
    margin-top: 0.5rem;
    font-weight: bold;
}
@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
    100% { transform: translateX(0); }
}

.shake {
    animation: shake 0.5s;
}
</style>
<body>
    
    <div class="container-fluid vh-100 bg">
        <div class="text-center mt-5 rounded">
            <div class="emergency-btn">
                <button class="btn btn-danger btn-lg rounded-circle">
                    <i class="fas fa-bell"></i>
                </button>
                <p>Click in case of emergency</p>
            </div>
            <h4 class="mt-4">Emergency Drill</h4>
            <div class="row justify-content-center">
                <div class="col-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body" id="hospital" class="hospital">
                            <i class="fas fa-medkit fa-3x" style="color: #f23747;"></i>
                            <h5 class="card-title mt-2">Hospitals</h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body" id="fire">
                            <i class="fas fa-fire fa-3x" style="color: #f23747;"></i>
                            <h5 class="card-title mt-2">Fire Station</h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body" id="ambulance">
                            <i class="fas fa-ambulance fa-3x" style="color: #f23747;"></i>
                            <h5 class="card-title mt-2">Ambulance Service</h5>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body" id="police">
                            <i class="fas fa-user-secret fa-3x" style="color: #f23747;"></i>
                            <h5 class="card-title mt-2">Police Stations</h5>
                        </div>
                    </div>
                </div>

               <div class="col-md-8 m-5 rounded-pill" style="min-height: 50px;">
                    <div class="col-md-12 rounded-pill" style="min-height: 50px;">
                        <div class="col-md-12 rounded-pill" style="min-height: 50px;">
                        <div class="col-md-12 rounded-pill shadow" style="min-height: 50px;">
                            <div class="row justify-content-center">
                            <div class="col-6 col-md-3">
                                <div class="">
                                <div class="">
                                    <i class="fa-solid fa-bell fa-2x"></i>
                                    <h5 class="card-title mt-2">Notification</h5>
                                </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="">
                                    <div class="" id="home">
                                        <i class="fa-solid fa-house fa-2x"></i>
                                        <h5 class="card-title mt-2">Home</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-md-3">
                                <div class="">
                                    <div class="" id="login">
                                        <i class="fa-solid fa-user-large fa-2x"></i>
                                        <h5 class="card-title mt-2">Dashboard</h5>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>

    <img src="./assets/static/images/873a0ad70c789771898a49c1453d1f6b.jpg" alt="">
                              
                              
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    //LITTLE JQUERY EFFECTS HERE AND THERE
    $(document).ready(function() {
    $('.emergency-btn').click(function() {
        $('.card').addClass('shake');
        setTimeout(function() {
            $('.card').removeClass('shake');
        }, 1000);
    });
});


// LINK TO EMERGENCY FORM
$('#hospital').click(function(){
   window.location.href='emergency_form.php';
})
$('#fire').click(function(){
   window.location.href='emergency_form.php';
})
$('#police').click(function(){
   window.location.href='emergency_form.php';
})
$('#ambulance').click(function(){
   window.location.href='emergency_form.php';
})

$('#home').click(function(){
   window.location.href='index.php';
})

$('#login').click(function(){
   window.location.href='user_dashboard.php';
})
    </script>
</body>