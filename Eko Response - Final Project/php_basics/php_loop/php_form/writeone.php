<!-- //HOW TO USE PHP TO WRITE INSIDE A FILE -->
<?php
ini_set("display_errors", "1");
//arg:name of file to write inside," ",
    $resp = file_put_contents("noisemaker.txt", "Jeremiah", FILE_APPEND);
echo $resp;

?>