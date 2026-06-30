<?php
error_reporting(E_ALL);
ini_set("display_errors", "1");
require_once('Db.php');

class User extends Db
{
    private $dbconn;

    public function __construct()
    {
        $this->dbconn = $this->connect();
    }





public function login($email, $password)
{
    try {
        // Retrieve user information
        $query = "SELECT * FROM User WHERE user_email=? LIMIT 1";
        $stmt = $this->dbconn->prepare($query);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Verify the password
            $hashed = $result["user_pwd"];
            if (password_verify($password, $hashed)) {
                // Check if the account is active
                if ($result['deactivate_status'] === 'active') { 
                    return $_SESSION['useronline']=$result['user_id']; // Return the user data
                } else {
                    $_SESSION['user_errormessage'] = "Account is currently Deactivated. Contact Support <a href='support.php'>here.</a>";
                    return null; // Return null to indicate the account is deactivated
                }
            } else {
                $_SESSION['user_errormessage'] = "Invalid credentials";
                return null; // Return null to indicate invalid credentials
            }
        } else {
            $_SESSION['user_errormessage'] = "User not found";
            return null; // Return null to indicate the user is not found
        }
    } catch (Exception $e) {
        $_SESSION['user_errormessage'] = $e->getMessage();
        return null; // Return null to indicate an error
    }
}



    public function get_current_user($id)
    {
        try {
            $sql = "SELECT * FROM User WHERE user_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            $_SESSION['errormsg'] = $e->getMessage();
            return 0;
        } catch (Exception $f) {
            $_SESSION['errormsg'] = $f->getMessage();
            return 0;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

    public function insert_user($fullname, $email, $password, $state, $lga)
    {
        try {
            #WRITE SQL STATEMENT 
            $query = "INSERT INTO User(user_fullname, user_email, user_pwd, state_id, user_local_govtID ) VALUES(?, ?, ?, ?,?)";
            #PREPARE
            $stmt = $this->dbconn->prepare($query);

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            #execute
            $result = $stmt->execute([$fullname, $email, $hashed, $state, $lga]);
            #AFTER INSERTION, GET THE ID ON THE TABLE, SAVE IT IN A SESSION AND RETURN IT
            $id = $this->dbconn->lastInsertId();
            return $id;
        } catch (PDOException $e) {
            $_SESSION['errormsg'] = "An Error Occured";  //This is not appropiate to users $e->getMessage(); //echo $e->getMessage();
            return 0;
        } catch (Exception $e) {
            $_SESSION['errormsg'] = "An Error Occured"; //$e->getMessage(); //echo $e->getMessage();
            return 0;
        }
    }

    #fetching User
    public function fetch_users()
    {

        $sql = "SELECT * FROM User";

        $sqlstmt = $this->dbconn->prepare($sql);

        $sqlstmt->execute();
        $result = $sqlstmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function update_user($fullname, $email, $phone, $gender, $age, $address, $file, $user_id)
    {
        $sql = "UPDATE User SET user_fullname=?, user_email=?, user_phone=?, user_gender=?, user_age=?, user_address=?, user_image=? WHERE user_id=?";
        $stmt = $this->dbconn->prepare($sql);
        $result = $stmt->execute([$fullname, $email, $phone, $gender, $age, $address, $file, $user_id]);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}

//  $user=new User;
//      $cops = $user->emergency(517);
//      print_r($cops); 

// $user= new User();
//     $user11=$user->login("biolanene@hotmail.com", "12345");

//      print_r($user11); 
