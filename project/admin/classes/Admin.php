<?php
ini_set("display_errors", "1");

require_once "Db.php";

class Admin extends Db{
    private $dbconnect;

    public function __construct()
    {
        $this->dbconnect = $this->connect();
    }

    public function admin_login($admin_email, $admin_password){
        try {
            $sqlquery = "SELECT * FROM admin WHERE admin_email =?";
            $querystmt= $sqlquery= $this->dbconnect->prepare($sqlquery); 
            
            $result = $querystmt->execute([$admin_email]);
            $record= $querystmt->fetch(PDO::FETCH_ASSOC);
        if($record){ //if username is correct
            $hashed  = $record["admin_password"];
            $chk = password_verify($admin_password, $hashed); //true or false
            
            if($chk){ #if login is correct
                $_SESSION['adminonline'] = $record['admin_id'];
                return 1;
            }
            if($chk){ #if login is correct
                $_SESSION['adminonline'] = $record['admin_id'];
                return 1;
            }
            else{
                $_SESSION['admin_errormessage'] = "Invalid credentials";
                return 0;
            }
        }
        else{ #if username is not correct
            $_SESSION['admin_errormessage'] = "Invalid credentials";
            return 0;
        }
        
        } catch(PDOException $error1){
            $_SESSION['admin_errormessage'] = $error1->getMessage();
            return 0;
        }catch(PDOException  $error2){
            $_SESSION['admin_errormessage'] = $error2->getMessage();
            return 0;
        }
    }


    

    #fetching User
    public function fetch_users(){
            
            $sql = "SELECT * FROM User";

            $sqlstmt = $this->dbconnect->prepare($sql);

            $sqlstmt->execute();
            $result=$sqlstmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }


    #Deleting a user data from DB
    public function deactivate_user($user_id)
{
        $sql = "UPDATE `User` SET `deactivate_status` = 'inactive' WHERE `User`.`user_id` = ?";

        $sqlstmt = $this->dbconnect->prepare($sql);
        $resulting=$sqlstmt->execute([$user_id]);
        return $resulting;
    
}

    public function activate_user($user_id)
{
        $sql = "UPDATE `User` SET `deactivate_status` = 'active' WHERE `User`.`user_id` = ?";

        $sqlstmt = $this->dbconnect->prepare($sql);
        $resulting=$sqlstmt->execute([$user_id]);
        return $resulting;
    
}


    #Logout 
    public function admin_logout(){
        session_unset();
        session_destroy();
    }



    #fetching User
    public function fetch_admin()
    {

        $sql = "SELECT * FROM admin";

        $sqlstmt = $this->dbconnect->prepare($sql);

        $sqlstmt->execute();
        $result = $sqlstmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function update_admin($fullname, $email, $phone, $gender, $age, $address, $file, $user_id)
    {
        $sql = "UPDATE admin SET admin_email=?, admin_password=? admin_gender=?, last_login=?, admin_address=?, admin_image=? WHERE admin_id=?";
        $stmt = $this->dbconnect->prepare($sql);
        $result = $stmt->execute([$fullname, $email, $phone, $gender, $age, $address, $file, $user_id]);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}



?>