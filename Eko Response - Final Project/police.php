<?php
ini_set("display_errors", "1");
require_once "classes/Emergency.php";
require_once "partials/header.php";
?>

<?php
if (isset($_GET['loc'])) {
    $loc = intval($_GET['loc']);
    print_r($loc);
    $respondent = new Incident();
    $policeStations = $respondent->police_station($loc);

    echo "<section class='ftco-section mt-5'>";
    echo "<div class='container'>";
    echo "<div class='row justify-content-center'>";
    echo "<div class='col-md-6 text-center mb-5'>";
    echo "<h2 class='heading-section'>Police Stations</h2>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row'>";
    echo "<div class='col-md-12'>";
    echo "<div class='table-wrap'>";

    echo "<table class='table table-bordered table-dark table-hover'>";
    echo "<tr><th>Police Unit ID</th><th>Police Unit Name</th><th>Address</th><th>Phone Number</th><th>Location</th><th>Police Unit</th></tr>";
    foreach ($policeStations as $station) {
        echo "<tr>";
        echo "<th scope='row'>" . $station['police_unit_id'] . "</th>";
        echo "<td>" . $station['police_unit_name'] . "</td>";
        echo "<td>" . $station['police_unit_address'] . "</td>";
        echo "<td>" . $station['police_unit_phone_number'] . "</td>";
        echo "<td>" . $station['lga_name'] . "</td>";
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
