<?php
ini_set("display_errors", "1");
require_once "classes/Emergency.php";
require_once "partials/header.php";
?>

<?php
if (isset($_GET['loc'])) {
    $loc = intval($_GET['loc']);
    // print_r($loc);
    $respondent = new Incident();
    $firestations = $respondent->fire_station($loc);
    // print_r($firestations );

    echo "<section class='ftco-section mt-5'>";
    echo "<div class='container'>";
    echo "<div class='row justify-content-center'>";
    echo "<div class='col-md-6 text-center mb-5'>";
    echo "<h2 class='heading-section'>Fire Stations</h2>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-md-12'>";
    echo "<div class='table-wrap'>";

    echo "<table class='table table-bordered table-dark table-hover'>";
    echo "<tr><th>Firestation ID</th><th>Fire Station</th><th>Fire Station Address</th><th>Fire Station Phone Number</th><th>Fire Station Type</th><th>Fire Station Location</th></tr>";
    foreach ($firestations as $firestation) {
        echo "<tr>";
        echo "<th scope='row'>" . $firestation['fire_unit_id'] . "</th>";
        echo "<td>" . $firestation['fire_unit_name'] . "</td>";
        echo "<td>" . $firestation['fire_unit_address'] . "</td>";
        echo "<td>" . $firestation['fire_unit_phone_number'] . "</td>";
        echo "<td>" . $firestation['fire_unit_type'] . "</td>";
        echo "<td>" . $firestation['lga_name'] . "</td>";
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
