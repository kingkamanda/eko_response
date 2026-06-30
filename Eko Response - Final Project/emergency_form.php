<?php
session_start();
require_once "classes/User.php";
require_once "classes/Emergency.php";
require_once "classes/State.php";

$data = new User();
$incident1 = new Incident();
$categories = $incident1->fetch_category();
$lga = new State;

// $getlga = $lga->getLocalGovernment($state_id);
// $user = $data->get_current_user($_SESSION['useronline']);
// $incident = new Incident();
// var_dump($getlga);
// die;
// var_dump($categories);
// die;

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Clear the error message after displaying it
    echo "<p>Error: $error_message</p>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Form</title>
    <link rel="stylesheet" type="text/css" href="./assets/static/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <?php
    require_once 'partials/logo.php';
    ?>
    <div class="container my-5">
        <h1 class="text-center mb-4">Incident Form</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="emergencyForm" action="process/process_incident.php" method="post" enctype="multipart/form-data">
                    <div class="form-group mt-5">
                        <label for="name">Fullname</label>
                        <input type="text" class="form-control" id="name" name="fullname">
                    </div>
                    <div class="form-group mt-5">
                        <label for="phone">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="form-group mt-5">
                        <label for="location">Address</label>
                        <input type="text" class="form-control" id="location" name="location">
                    </div>
                    <div class="form-group mt-1 d-none" id="lgadiv">
                        <label for="local_government_area" id="pick">Select Your Local Government</label>
                        <select name="lga" id="lga" class="form-select my-1 form-control" style="display: none;">
                        </select>
                    </div>
                    <div class="form-group mt-5">
                        <label for="emergency">Emergency Type</label>
                        <select class="form-control" id="emergency" name="emergency_type" aria-label="Default select example">
                            <option value="" hidden>Select an emergency</option>
                            <?php foreach ($categories as $category) {     
                                $categoryname = $category['category_name'];
                                $categoryid = $category['category_id'];
                            ?>
                                <option value='<?php echo $categoryid ?>'><?php echo $categoryname ?></option>
                            <?php 
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mt-5">
                        <label for="emergency">Emergency Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="" hidden>Status</option>
                            <option value="severe">Severe</option>
                            <option value="moderate">Moderate</option>
                            <option value="medical">Mild</option>
                        </select>
                    </div>
                    <div class="form-group mt-5">
                        <label for="time_date">Date & Time of Incident</label>
                        <input type="datetime-local" name="time" id="time">
                    </div>
                    <div class="form-group mt-5">
                        <label for="image">Upload Images</label>
                        <input type="file" name="imageUpload" id="imageUpload">
                    </div>
                    <div class="form-group mt-5">
                        <label for="image">Upload Video</label>
                        <input type="file" name="videoUpload" id="videoUpload">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" rows="3" name="desc"></textarea>
                    </div>
                    <div class="d-grid gap-2 col-12 mx-auto mt-5">
                        <button type="submit" class="btn btn-primary col-12" name="btnform">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#location").change(function() {
                var value = $(this).val();
                $.ajax({
                    url: "server.php",
                    method: "post",
                    data: value,
                    dataType: "json",
                    success: function(res) {
                        $("#lga").empty()
                        $("#lga").show()
                        $("#lgadiv").removeClass('d-none');
                        res.forEach(value => {
                            $("#lga").append(`<option value="${value['lga_id']}">${value['lga_name']}</option>`);
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            // $('#emergencyForm').submit(function(e) {
            //     e.preventDefault(); // Prevent the form from submitting
            // 
            //     // Get form data
            //     var name = $('#name').val();
            //     var phone = $('#phone').val();
            //     var location = $('#location').val();
            //     var emergency = $('#emergency').val();
            //     var description = $('#description').val();
            // 
            //     // Perform form validation
            //     if (name && phone && location && emergency && description) {
            //         // Form is valid, you can handle the data here
            //         console.log('Form submitted successfully!');
            //         console.log('Name:', name);
            //         console.log('Phone:', phone);
            //         console.log('Location:', location);
            //         console.log('Emergency Type:', emergency);
            //         console.log('Description:', description);
            // 
            //         // Clear the form
            //         $('#emergencyForm')[0].reset();
            //     } else {
            //         alert('Please fill in all required fields.');
            //     }
            // });
        });
    </script>
</body>
</html>
