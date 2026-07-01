<?php
require_once __DIR__ . '/../../classes/Db.php';

/**
 * Agency staff accounts and operations. One table (`staff`), one login, routed
 * by role: agency_admin, employee, responder. Reuses the shared Db connection.
 */
class Staff extends Db
{
    private $dbconn;

    public function __construct()
    {
        $this->dbconn = $this->connect();
    }

    /* ------------------------------- Auth -------------------------------- */

    public function login($email, $password)
    {
        try {
            $stmt = $this->dbconn->prepare("SELECT * FROM staff WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $s = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$s || !password_verify($password, $s['password'])) {
                $_SESSION['staff_error'] = "Invalid email or password.";
                return null;
            }
            if ($s['status'] !== 'active') {
                $_SESSION['staff_error'] = "This account is deactivated.";
                return null;
            }
            $_SESSION['staffonline'] = $s['staff_id'];
            $_SESSION['staffrole']   = $s['role'];
            $_SESSION['staffagency'] = $s['agency_id'];
            return $s;
        } catch (Exception $e) {
            error_log("Staff login failed: " . $e->getMessage());
            $_SESSION['staff_error'] = "An error occurred. Please try again.";
            return null;
        }
    }

    public function current($staff_id)
    {
        $sql = "SELECT s.*, a.agency_name, a.agency_type
                FROM staff s LEFT JOIN agency a ON a.agency_id = s.agency_id
                WHERE s.staff_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$staff_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

    /* --------------------- Staff management (agency) --------------------- */

    public function fetch_staff($agency_id)
    {
        $stmt = $this->dbconn->prepare(
            "SELECT * FROM staff WHERE agency_id = ? ORDER BY role, fullname"
        );
        $stmt->execute([$agency_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetch_responders($agency_id)
    {
        $stmt = $this->dbconn->prepare(
            "SELECT * FROM staff WHERE agency_id = ? AND role = 'responder' AND status = 'active' ORDER BY fullname"
        );
        $stmt->execute([$agency_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Create an employee/responder within an agency. Returns [ok, message]. */
    public function add_staff($fullname, $email, $password, $role, $agency_id, $phone)
    {
        $role = in_array($role, ['employee', 'responder', 'agency_admin'], true) ? $role : 'employee';
        try {
            $check = $this->dbconn->prepare("SELECT staff_id FROM staff WHERE email = ?");
            $check->execute([$email]);
            if ($check->fetch()) {
                return [false, "A staff member with that email already exists."];
            }
            $stmt = $this->dbconn->prepare(
                "INSERT INTO staff (fullname, email, password, role, agency_id, phone)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $fullname, $email, password_hash($password, PASSWORD_DEFAULT),
                $role, $agency_id, $phone
            ]);
            return [true, "Staff member added."];
        } catch (Exception $e) {
            error_log("add_staff failed: " . $e->getMessage());
            return [false, "Could not add staff member."];
        }
    }

    public function set_staff_status($staff_id, $agency_id, $status)
    {
        $status = $status === 'inactive' ? 'inactive' : 'active';
        $stmt = $this->dbconn->prepare(
            "UPDATE staff SET status = ? WHERE staff_id = ? AND agency_id = ?"
        );
        return $stmt->execute([$status, $staff_id, $agency_id]);
    }

    /* --------------------------- Emergencies ----------------------------- */

    /** Emergencies whose type is handled by this agency. */
    public function fetch_agency_emergencies($agency_id)
    {
        $sql = "SELECT e.*, c.category_name, l.lga_name, u.user_fullname AS reporter,
                       st.fullname AS assigned_name
                FROM emergency_alert_table e
                JOIN category c ON c.category_id = e.emergency_type
                LEFT JOIN lga l ON l.lga_id = e.lga_id
                LEFT JOIN User u ON u.user_id = e.user_id
                LEFT JOIN staff st ON st.staff_id = e.assigned_staff_id
                WHERE c.agency_id = ?
                ORDER BY e.alert_id DESC";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$agency_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Emergencies assigned to a particular responder. */
    public function fetch_assigned($staff_id)
    {
        $sql = "SELECT e.*, c.category_name, l.lga_name, u.user_fullname AS reporter
                FROM emergency_alert_table e
                JOIN category c ON c.category_id = e.emergency_type
                LEFT JOIN lga l ON l.lga_id = e.lga_id
                LEFT JOIN User u ON u.user_id = e.user_id
                WHERE e.assigned_staff_id = ?
                ORDER BY e.alert_id DESC";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$staff_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_emergency($alert_id, $agency_id)
    {
        $sql = "SELECT e.*, c.category_name, c.agency_id, l.lga_name, s.state_name,
                       u.user_fullname AS reporter, st.fullname AS assigned_name
                FROM emergency_alert_table e
                JOIN category c ON c.category_id = e.emergency_type
                LEFT JOIN lga l ON l.lga_id = e.lga_id
                LEFT JOIN state s ON s.state_id = l.state_id
                LEFT JOIN User u ON u.user_id = e.user_id
                LEFT JOIN staff st ON st.staff_id = e.assigned_staff_id
                WHERE e.alert_id = ? AND c.agency_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$alert_id, $agency_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function assign_emergency($alert_id, $staff_id)
    {
        $stmt = $this->dbconn->prepare(
            "UPDATE emergency_alert_table SET assigned_staff_id = ? WHERE alert_id = ?"
        );
        return $stmt->execute([$staff_id ?: null, $alert_id]);
    }

    /**
     * Record a responder update: append to the tracking log and move the
     * emergency's current status forward.
     */
    public function add_response($alert_id, $staff_id, $status, $note, $imageFile = null)
    {
        try {
            $image = $this->saveUpload($imageFile);
            $this->dbconn->beginTransaction();
            $stmt = $this->dbconn->prepare(
                "INSERT INTO emergency_response (alert_id, staff_id, status, note, image)
                 VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([$alert_id, $staff_id, $status, $note, $image]);

            if ($status) {
                $this->dbconn->prepare(
                    "UPDATE emergency_alert_table SET alert_status = ? WHERE alert_id = ?"
                )->execute([$status, $alert_id]);
            }
            $this->dbconn->commit();
            return true;
        } catch (Exception $e) {
            $this->dbconn->rollBack();
            error_log("add_response failed: " . $e->getMessage());
            return false;
        }
    }

    /** Save an optional uploaded image into the shared media directory. */
    private function saveUpload($file)
    {
        if (!is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK
            || !is_uploaded_file($file['tmp_name'])) {
            return null;
        }
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'], true)) {
            return null;
        }
        $dir = __DIR__ . '/../../incident_media';
        if (!is_dir($dir)) { mkdir($dir, 0775, true); }
        $name = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
        return move_uploaded_file($file['tmp_name'], $dir . '/' . $name) ? $name : null;
    }

    /** Tracking timeline for an emergency (staff and reporter updates). */
    public function fetch_responses($alert_id)
    {
        $sql = "SELECT r.*, s.fullname AS staff_name, u.user_fullname AS reporter_name
                FROM emergency_response r
                LEFT JOIN staff s ON s.staff_id = r.staff_id
                LEFT JOIN User u ON u.user_id = r.user_id
                WHERE r.alert_id = ?
                ORDER BY r.response_id DESC";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$alert_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ------------------------------ Metrics ------------------------------ */

    public function agency_stats($agency_id)
    {
        $total = $this->dbconn->prepare(
            "SELECT COUNT(*) FROM emergency_alert_table e
             JOIN category c ON c.category_id = e.emergency_type WHERE c.agency_id = ?"
        );
        $total->execute([$agency_id]);

        $resolved = $this->dbconn->prepare(
            "SELECT COUNT(*) FROM emergency_alert_table e
             JOIN category c ON c.category_id = e.emergency_type
             WHERE c.agency_id = ? AND e.alert_status = 'resolved'"
        );
        $resolved->execute([$agency_id]);

        $staff = $this->dbconn->prepare("SELECT COUNT(*) FROM staff WHERE agency_id = ?");
        $staff->execute([$agency_id]);

        $t = (int) $total->fetchColumn();
        $r = (int) $resolved->fetchColumn();
        return ['total' => $t, 'resolved' => $r, 'pending' => $t - $r, 'staff' => (int) $staff->fetchColumn()];
    }

    /** Hot zones limited to this agency's emergencies. */
    public function hot_zones($agency_id, $threshold = 2, $limit = 20)
    {
        $limit = (int) $limit;
        $sql = "SELECT l.lga_name, s.state_name, COUNT(e.alert_id) AS total,
                       AVG(e.latitude) AS avg_lat, AVG(e.longitude) AS avg_lng
                FROM emergency_alert_table e
                JOIN category c ON c.category_id = e.emergency_type
                JOIN lga l ON l.lga_id = e.lga_id
                LEFT JOIN state s ON s.state_id = l.state_id
                WHERE c.agency_id = ?
                GROUP BY e.lga_id, l.lga_name, s.state_name
                HAVING total >= ?
                ORDER BY total DESC LIMIT $limit";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$agency_id, $threshold]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* --------------- Platform staff (managers/employees) ----------------- */

    public static function isPlatform($role)
    {
        return in_array($role, ['platform_manager', 'platform_employee'], true);
    }

    /** Every emergency across all agencies (platform-wide view). */
    public function fetch_all_emergencies()
    {
        $sql = "SELECT e.*, c.category_name, a.agency_name, l.lga_name,
                       u.user_fullname AS reporter, st.fullname AS assigned_name
                FROM emergency_alert_table e
                LEFT JOIN category c ON c.category_id = e.emergency_type
                LEFT JOIN agency a ON a.agency_id = c.agency_id
                LEFT JOIN lga l ON l.lga_id = e.lga_id
                LEFT JOIN User u ON u.user_id = e.user_id
                LEFT JOIN staff st ON st.staff_id = e.assigned_staff_id
                ORDER BY e.flagged DESC, e.alert_id DESC";
        return $this->dbconn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function platform_stats()
    {
        $total    = (int) $this->dbconn->query("SELECT COUNT(*) FROM emergency_alert_table")->fetchColumn();
        $resolved = (int) $this->dbconn->query("SELECT COUNT(*) FROM emergency_alert_table WHERE alert_status = 'resolved'")->fetchColumn();
        $flagged  = (int) $this->dbconn->query("SELECT COUNT(*) FROM emergency_alert_table WHERE flagged = 1")->fetchColumn();
        return ['total' => $total, 'resolved' => $resolved, 'pending' => $total - $resolved, 'flagged' => $flagged];
    }

    public function flag_incident($alert_id, $reason)
    {
        $stmt = $this->dbconn->prepare(
            "UPDATE emergency_alert_table SET flagged = 1, flag_reason = ? WHERE alert_id = ?"
        );
        return $stmt->execute([$reason, $alert_id]);
    }

    public function unflag_incident($alert_id)
    {
        $stmt = $this->dbconn->prepare(
            "UPDATE emergency_alert_table SET flagged = 0, flag_reason = NULL WHERE alert_id = ?"
        );
        return $stmt->execute([$alert_id]);
    }

    /** Platform-wide hot zones (all agencies). */
    public function global_hot_zones($threshold = 2, $limit = 20)
    {
        $limit = (int) $limit;
        $sql = "SELECT l.lga_name, s.state_name, COUNT(e.alert_id) AS total,
                       AVG(e.latitude) AS avg_lat, AVG(e.longitude) AS avg_lng
                FROM emergency_alert_table e
                JOIN lga l ON l.lga_id = e.lga_id
                LEFT JOIN state s ON s.state_id = l.state_id
                GROUP BY e.lga_id, l.lga_name, s.state_name
                HAVING total >= ?
                ORDER BY total DESC LIMIT $limit";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$threshold]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
