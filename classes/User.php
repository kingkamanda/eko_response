<?php
require_once __DIR__ . '/Db.php';

class User extends Db
{
    private $dbconn;

    public function __construct()
    {
        $this->dbconn = $this->connect();
    }

    /**
     * Verify credentials. On success returns the user id and records it in the
     * session; on failure sets an error message and returns null.
     */
    public function login($email, $password)
    {
        try {
            $stmt = $this->dbconn->prepare(
                "SELECT * FROM User WHERE user_email = ? LIMIT 1"
            );
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result || !password_verify($password, $result["user_pwd"])) {
                $_SESSION['user_errormessage'] = "Invalid email or password.";
                return null;
            }

            if ($result['deactivate_status'] !== 'active') {
                $_SESSION['user_errormessage'] =
                    "Account is currently deactivated. Please contact support.";
                return null;
            }

            return $_SESSION['useronline'] = $result['user_id'];
        } catch (Exception $e) {
            error_log("User login failed: " . $e->getMessage());
            $_SESSION['user_errormessage'] = "An error occurred. Please try again.";
            return null;
        }
    }

    public function get_current_user($id)
    {
        try {
            $stmt = $this->dbconn->prepare("SELECT * FROM User WHERE user_id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("get_current_user failed: " . $e->getMessage());
            return null;
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Register a new user. Returns the new user id on success, 0 on failure.
     * Guards against duplicate email addresses.
     */
    public function insert_user($fullname, $email, $password, $state, $lga)
    {
        try {
            $check = $this->dbconn->prepare(
                "SELECT user_id FROM User WHERE user_email = ? LIMIT 1"
            );
            $check->execute([$email]);
            if ($check->fetch()) {
                $_SESSION['errormsg'] = "An account with this email already exists.";
                return 0;
            }

            $query = "INSERT INTO User(user_fullname, user_email, user_pwd, state_id, user_local_govtID)
                      VALUES(?, ?, ?, ?, ?)";
            $stmt = $this->dbconn->prepare($query);
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([$fullname, $email, $hashed, $state, $lga]);

            return $this->dbconn->lastInsertId();
        } catch (Exception $e) {
            error_log("insert_user failed: " . $e->getMessage());
            $_SESSION['errormsg'] = "An error occurred during registration.";
            return 0;
        }
    }

    /** Fetch every user (used by the admin area). */
    public function fetch_users()
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM User ORDER BY user_date_registered DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update_user($fullname, $email, $phone, $gender, $age, $address, $file, $user_id)
    {
        $sql = "UPDATE User
                SET user_fullname = ?, user_email = ?, user_phone = ?, user_gender = ?,
                    user_age = ?, user_address = ?, user_image = ?
                WHERE user_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        return $stmt->execute([$fullname, $email, $phone, $gender, $age, $address, $file, $user_id]);
    }
}
