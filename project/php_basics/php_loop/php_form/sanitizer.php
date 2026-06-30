<?php 
error_reporting(E_ALL);
function sanitizer($evilstring){ 
        $safe_string = strip_tags($evilstring, ["i"]);        
    $safe_string = htmlspecialchars($safe_string);
    $safe_string = trim($safe_string);
    $safe_string = trim($safe_string);
    $safe_string = addslashes($safe_string);
    
    return $safe_string;
}

// Then type require_once "sanitizer.php";