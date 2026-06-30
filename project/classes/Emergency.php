<?php
ini_set("display_errors", "1");
require_once("Db.php");

class Incident extends Db
{
   private $dbconn;

   public function __construct()
   {
       $this->dbconn = $this->connect();
   }
   // public function addIncident($fullname, $phone, $location, $emergency, $status, $time, $incident_img, $incident_vid, $description)
   public function addIncident($fullname, $phone, $location, $emergency, $status, $time, $incident_img, $incident_vid, $description, $lga)
   {
       //  FOR IMAGE UPLOAD
       $tmp_name = $incident_img["tmp_name"];
       $file_name = $incident_img["name"];
       $size = $incident_img["size"];
       $error = $incident_img["error"];
       $mime_type = $incident_img["type"];
       $r = explode(".", $file_name);
       $newname = time() . rand() . "." . $r[1];
       move_uploaded_file($tmp_name, "../incident_media/$newname");

       //  FOR VIDEO UPLOAD

       $temp_name = $incident_vid["tmp_name"];
       $video_name = $incident_vid["name"];
       $size = $incident_vid["size"];
       $error = $incident_vid["error"];
       $mime_type = $incident_vid["type"];
       $r = explode(".", $video_name);
       $newvideoname = time() . rand() . "." . $r[1];
       move_uploaded_file($tmp_name, "../incident_media/$newvideoname");



       try {
           $query = "INSERT INTO emergency_alert_table(user_fullname, user_phone, user_location, emergency_type, alert_status, alert_time, emergency_alert_image, emergency_alert_video, alert_desc, lga_id)VALUES(?,?,?,?,?,?,?,?,?,?)";
           $stmt = $this->dbconn->prepare($query);
           $stmt->execute([$fullname, $phone, $location, $emergency, $status, $time, $newname, $newvideoname, $description, $lga]);
           $result = $this->dbconn->lastInsertId();
           // // return $emergency;
           if ($result) {

               // $lga= $stmt->fetchColumn(5);
               return $lga;
               // echo $location;
               // return $incidentlocation = ['user_location'];
               // echo $incidentlocation;
           }
       } catch (PDOException $e) {
           $_SESSION['errormsg'] = "An Error Occured";  //This is not appropiate to users $e->getMessage(); //echo $e->getMessage();
           return 0;
       } catch (Exception $e) {
           $_SESSION['errormsg'] = "An Error Occured";
           return 0;
       }
   }


   public function fetch_category()
   {
       $query = "SELECT * FROM category";
       $sqlstmt = $this->dbconn->prepare($query);
       $sqlstmt->execute();
       $result = $sqlstmt->fetchAll(PDO::FETCH_ASSOC);
       return $result;
   }


    public function police_station($police)
    {
        $sql = "SELECT * FROM police_unit
        JOIN lga ON lga.lga_id = police_unit.police_unit_location
        WHERE police_unit_location =?";
        $stmt = $this->dbconn->prepare($sql);
        
        if (!$stmt->execute([$police])) {
           // Log the error message remove and add seesion
           error_log("Error executing query: " . print_r($stmt->errorInfo(), true));
           return []; // Return an empty array if there's an error
       }

       $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $result;

    }

   public function hospital($hospital)
   {
      $sql = "SELECT * FROM medical_unit 
      JOIN lga ON lga.lga_id = medical_unit.medical_unit_location 
      WHERE medical_unit_location =?";
      $stmt = $this->dbconn->prepare($sql);

       if (!$stmt->execute([$hospital])) {
           // Log the error message remove and add seesion
           error_log("Error executing query: " . print_r($stmt->errorInfo(), true));
           return []; // Return an empty array if there's an error
       }

       $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $result;
   }

   public function fire_station($fire)
   {
      $sql = "SELECT * FROM fire_unit 
      JOIN lga ON lga.lga_id = fire_unit.fire_unit_location 
      WHERE fire_unit_location =?";
      $stmt = $this->dbconn->prepare($sql);

       if (!$stmt->execute([$fire])) {
           // Log the error message remove and add seesion
           error_log("Error executing query: " . print_r($stmt->errorInfo(), true));
           return []; // Return an empty array if there's an error
       }

       $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $result;
   }
}

//  $user=new Incident;
//      $cops = $user->emergency(517);
//      print_r($cops); 

// $user= new Incident();
//     $result=$user->addIncident("Oyebola Stanley", "07033296785", "Amuwo Odofin", "Accident", "Severe", "2024-05-25T00:44","Hello",517);

//      echo $result;