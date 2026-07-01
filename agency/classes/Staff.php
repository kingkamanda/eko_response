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
    public function add_response($alert_id, $staff_id, $status, $note)
    {
        try {
            $this->dbconn->beginTransaction();
            $stmt = $this->dbconn->prepare(
                "INSERT INTO emergency_response (alert_id, staff_id, status, note)
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$alert_id, $staff_id, $status, $note]);

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

    /** Tracking timeline for an emergency. */
    public function fetch_responses($alert_id)
    {
        $sql = "SELECT r.*, s.fullname AS staff_name
                FROM emergency_response r
                LEFT JOIN staff s ON s.staff_id = r.staff_id
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
}
