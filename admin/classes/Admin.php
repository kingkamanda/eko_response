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

    /* --------------------- Agencies & emergency types --------------------- */

    public function fetch_agencies()
    {
        $stmt = $this->dbconnect->query("SELECT * FROM agency ORDER BY agency_name");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Emergency types with their responsible agency and approval state. */
    public function fetch_categories()
    {
        $sql = "SELECT c.*, a.agency_name, a.agency_type, u.user_fullname AS requester
                FROM category c
                LEFT JOIN agency a ON a.agency_id = c.agency_id
                LEFT JOIN User u ON u.user_id = c.requested_by
                ORDER BY c.approval_status DESC, c.category_name";
        return $this->dbconnect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add_category($name, $agency_id, $status = 'approved', $requested_by = null)
    {
        $stmt = $this->dbconnect->prepare(
            "INSERT INTO category (category_name, agency_id, approval_status, requested_by)
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$name, $agency_id ?: null, $status, $requested_by]);
    }

    public function update_category($id, $name, $agency_id)
    {
        $stmt = $this->dbconnect->prepare(
            "UPDATE category SET category_name = ?, agency_id = ? WHERE category_id = ?"
        );
        return $stmt->execute([$name, $agency_id ?: null, $id]);
    }

    /** Approve or reject a (usually public-requested) emergency type. */
    public function set_category_status($id, $status)
    {
        $stmt = $this->dbconnect->prepare(
            "UPDATE category SET approval_status = ? WHERE category_id = ?"
        );
        return $stmt->execute([$status, $id]);
    }

    public function delete_category($id)
    {
        $stmt = $this->dbconnect->prepare("DELETE FROM category WHERE category_id = ?");
        return $stmt->execute([$id]);
    }

    public function count_pending_categories()
    {
        return (int) $this->dbconnect
            ->query("SELECT COUNT(*) FROM category WHERE approval_status = 'pending'")
            ->fetchColumn();
    }

    /* ------------------------------ Reports ------------------------------- */

    public function report_by_type()
    {
        $sql = "SELECT c.category_name, COUNT(e.alert_id) AS total
                FROM category c
                LEFT JOIN emergency_alert_table e ON e.emergency_type = c.category_id
                WHERE c.approval_status = 'approved'
                GROUP BY c.category_id, c.category_name
                ORDER BY total DESC";
        return $this->dbconnect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function report_by_status()
    {
        $sql = "SELECT COALESCE(NULLIF(alert_status,''),'pending') AS status, COUNT(*) AS total
                FROM emergency_alert_table
                GROUP BY status ORDER BY total DESC";
        return $this->dbconnect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function report_by_agency()
    {
        $sql = "SELECT a.agency_name, COUNT(e.alert_id) AS total
                FROM agency a
                LEFT JOIN category c ON c.agency_id = a.agency_id
                LEFT JOIN emergency_alert_table e ON e.emergency_type = c.category_id
                GROUP BY a.agency_id, a.agency_name
                ORDER BY total DESC";
        return $this->dbconnect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function report_by_lga($limit = 15)
    {
        $limit = (int) $limit;
        $sql = "SELECT l.lga_name, COUNT(e.alert_id) AS total
                FROM emergency_alert_table e
                JOIN lga l ON l.lga_id = e.lga_id
                GROUP BY e.lga_id, l.lga_name
                ORDER BY total DESC
                LIMIT $limit";
        return $this->dbconnect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ----------------------------- Hot zones ------------------------------ */

    /**
     * Hot zones: LGAs ranked by how many emergencies were reported there.
     * A zone is flagged "hot" when its count meets the threshold.
     */
    public function hot_zones($threshold = 3, $limit = 20)
    {
        $limit = (int) $limit;
        $sql = "SELECT l.lga_id, l.lga_name, s.state_name,
                       COUNT(e.alert_id) AS total,
                       AVG(e.latitude)  AS avg_lat,
                       AVG(e.longitude) AS avg_lng
                FROM emergency_alert_table e
                JOIN lga l   ON l.lga_id = e.lga_id
                LEFT JOIN state s ON s.state_id = l.state_id
                GROUP BY e.lga_id, l.lga_name, s.state_name
                HAVING total >= ?
                ORDER BY total DESC
                LIMIT $limit";
        $stmt = $this->dbconnect->prepare($sql);
        $stmt->execute([$threshold]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Individual reported points (those with coordinates) for plotting. */
    public function incident_points($limit = 500)
    {
        $limit = (int) $limit;
        $sql = "SELECT e.latitude, e.longitude, c.category_name, e.alert_status
                FROM emergency_alert_table e
                LEFT JOIN category c ON c.category_id = e.emergency_type
                WHERE e.latitude IS NOT NULL AND e.longitude IS NOT NULL
                ORDER BY e.alert_id DESC
                LIMIT $limit";
        return $this->dbconnect->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}
