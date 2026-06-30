<?php

class General{ //the sanitizer class
    
   public static function sanitizer($evilstring){
        $clean_string = strip_tags($evilstring);
        $clean_string = addslashes($clean_string);
        $clean_string = htmlentities($clean_string);
        return $clean_string;
       }
       
}
?>