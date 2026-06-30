<?php
echo "current time before setting timezone is". date("h-i-s");
echo "<br>";
date_default_timezone_set("America/New_York");
echo "current time after setting time zone is ". date("h-i-s");


?>