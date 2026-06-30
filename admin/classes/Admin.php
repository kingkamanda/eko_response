<?php
require_once __DIR__ . '/Db.php';

class Admin extends Db
{
    private $dbconnect;

    public function __construct()
    {
        $this->dbconnect = $this->connect();
    }

    /** Verify admin credentials. Returns 1 on success, 0 otherwise. */
    public function admin_login($admin_email, $admin_password)
    {
        try {
            $stmt = $this->dbconnect->prepare("SELECT * FROM admin WHERE admin_email = ?");
            $stmt->execute([$admin_email]);
            $record = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($record && password_verify($admin_password, $record["admin_password"])) {
                $_SESSION['adminonline'] = $record['admin_id'];
                return 1;
            }

            $_SESSION['admin_errormessage'] = "Invalid credentials";
            return 0;
        } catch (PDOException $e) {
            error_log("admin_login failed: " . $e->getMessage());
            $_SESSION['admin_errormessage'] = "An error occurred. Please try again.";
            return 0;
        }
    }

    /* ----------------------------- Users ----------------------------- */

    public function fetch_users()
    {
        $stmt = $this->dbconnect->prepare("SELECT * FROM User ORDER BY user_date_registered DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count_users()
    {
        return (int) $this->dbconnect->query("SELECT COUNT(*) FROM User")->fetchColumn();
    }

    public function deactivate_user($user_id)
    {
        $stmt = $this->dbconnect->prepare(
            "UPDATE User SET deactivate_status = 'inactive' WHERE user_id = ?"
        );
        return $stmt->execute([$user_id]);
    }

    public function activate_user($user_id)
    {
        $stmt = $this->dbconnect->prepare(
            "UPDATE User SET deactivate_status = 'active' WHERE user_id = ?"
        );
        return $stmt->execute([$user_id]);
    }

    /* -------------------------- Emergencies -------------------------- */

    /** Every reported emergency, joined with reporter and category. */
    public function fetch_emergencies()
    {
        $sql = "SELECT e.*, c.category_name, l.lga_name, u.user_fullname AS reporter
                FROM emergency_alert_table e
                LEFT JOIN category c ON c.category_id = e.emergency_type
                LEFT JOIN lga l ON l.lga_id = e.lga_id
                LEFT JOIN User u ON u.user_id = e.user_id
                ORDER BY e.alert_id DESC";
        $stmt = $this->dbconnect->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update_emergency_status($alert_id, $status)
    {
        $stmt = $this->dbconnect->prepare(
            "UPDATE emergency_alert_table SET alert_status = ? WHERE alert_id = ?"
        );
        return $stmt->execute([$status, $alert_id]);
    }

    public function count_emergencies()
    {
        return (int) $this->dbconnect->query("SELECT COUNT(*) FROM emergency_alert_table")->fetchColumn();
    }

    public function count_emergencies_by_status($status)
    {
        $stmt = $this->dbconnect->prepare(
            "SELECT COUNT(*) FROM emergency_alert_table WHERE alert_status = ?"
        );
        $stmt->execute([$status]);
        return (int) $stmt->fetchColumn();
    }

    /* ----------------------------- Misc ------------------------------ */

    public function admin_logout()
    {
        session_unset();
        session_destroy();
    }

    public function fetch_admin()
    {
        $stmt = $this->dbconnect->prepare("SELECT * FROM admin");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
