<?php
require_once "classes/Emergency.php";
require_once "partials/header.php";
?>

<?php
if (isset($_GET['loc'])) {
    $loc = intval($_GET['loc']);
    // print_r($loc);
    $respondent = new Incident();
    $hospitals = $respondent->hospital($loc);
    // print_r($hospitals);
    // die;

    echo "<section class='ftco-section mt-5'>";
    echo "<div class='container'>";
    echo "<div class='row justify-content-center'>";
    echo "<div class='col-md-6 text-center mb-5'>";
    echo "<h2 class='heading-section'>Hospitals</h2>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-md-12'>";
    echo "<div class='table-wrap'>";

    echo "<table class='table table-bordered table-dark table-hover'>";
    echo "<tr><th>Hospital ID</th><th>Hospital Name</th><th>Hospital Address</th><th>Hospital Phone Number</th><th>Hospital Type</th><th>Hospital Location</th></tr>";
    foreach ($hospitals as $hospital) {
        echo "<tr>";
        echo "<th scope='row'>" . $hospital['medical_unit_id'] . "</th>";
        echo "<td>" . $hospital['medical_unit_name'] . "</td>";
        echo "<td>" . $hospital['medical_unit_address'] . "</td>";
        echo "<td>" . $hospital['medical_unit_phone_number'] . "</td>";
        echo "<td>" . $hospital['medical_unit_type'] . "</td>";
        echo "<td>" . $hospital['lga_name'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</section>";
}
?>

<?php
require_once "partials/footer.php";
?>
```