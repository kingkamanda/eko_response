<?php
require_once __DIR__ . '/Db.php';

class Incident extends Db
{
    private $dbconn;

    /** Directory (relative to the site root) where incident media is stored. */
    const MEDIA_DIR = 'incident_media';

    public function __construct()
    {
        $this->dbconn = $this->connect();
    }

    /**
     * Store an emergency report.
     *
     * @param int   $user_id      id of the logged-in user filing the report
     * @param array $incident_img $_FILES entry for the image (may be empty)
     * @param array $incident_vid $_FILES entry for the video (may be empty)
     * @return int  the LGA id (used to look up nearby response units) on
     *              success, or 0 on failure.
     */
    public function addIncident(
        $user_id,
        $fullname,
        $phone,
        $location,
        $emergency,
        $status,
        $time,
        $incident_img,
        $incident_vid,
        $description,
        $lga,
        $latitude = null,
        $longitude = null
    ) {
        try {
            $imageName = $this->saveUpload($incident_img, ['jpg', 'jpeg', 'png', 'gif']);
            $videoName = $this->saveUpload($incident_vid, ['mp4', 'mov', 'avi', 'webm', 'mkv']);

            $query = "INSERT INTO emergency_alert_table
                        (user_id, user_fullname, user_phone, user_location, emergency_type,
                         alert_status, alert_time, emergency_alert_image, emergency_alert_video,
                         alert_desc, lga_id, latitude, longitude)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([
                $user_id, $fullname, $phone, $location, $emergency,
                $status, $time, $imageName, $videoName, $description, $lga,
                $latitude !== null && $latitude !== '' ? $latitude : null,
                $longitude !== null && $longitude !== '' ? $longitude : null
            ]);

            return $this->dbconn->lastInsertId() ? (int) $lga : 0;
        } catch (Exception $e) {
            error_log("addIncident failed: " . $e->getMessage());
            $_SESSION['errormsg'] = "We could not submit your report. Please try again.";
            return 0;
        }
    }

    /**
     * Move an uploaded file into the media directory under a unique, safe name.
     * Returns the stored file name, or null when no valid file was supplied.
     */
    private function saveUpload($file, array $allowedExt)
    {
        if (!is_array($file) || !isset($file['error']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
            return null;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt, true)) {
            return null;
        }

        $dir = __DIR__ . '/../' . self::MEDIA_DIR;
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $newName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $dir . '/' . $newName)) {
            return $newName;
        }
        return null;
    }

    /** Approved emergency categories, for the report-form dropdown. */
    public function fetch_category()
    {
        $stmt = $this->dbconn->prepare(
            "SELECT * FROM category WHERE approval_status = 'approved' ORDER BY category_name"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** All agencies (for the 'suggest agency' dropdown when requesting a type). */
    public function fetch_agencies()
    {
        return $this->dbconn->query("SELECT * FROM agency ORDER BY agency_name")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Service type (police/fire/medical/other) responsible for a category,
     * used to route a new report to the right response units.
     */
    public function category_service($category_id)
    {
        $stmt = $this->dbconn->prepare(
            "SELECT a.agency_type
             FROM category c LEFT JOIN agency a ON a.agency_id = c.agency_id
             WHERE c.category_id = ?"
        );
        $stmt->execute([$category_id]);
        return $stmt->fetchColumn() ?: null;
    }

    /** A logged-in user proposes a new emergency type for admin approval. */
    public function request_category($name, $agency_id, $user_id)
    {
        $stmt = $this->dbconn->prepare(
            "INSERT INTO category (category_name, agency_id, approval_status, requested_by)
             VALUES (?, ?, 'pending', ?)"
        );
        return $stmt->execute([$name, $agency_id ?: null, $user_id]);
    }

    /** The emergency-type requests a user has submitted, with their status. */
    public function fetch_user_category_requests($user_id)
    {
        $sql = "SELECT c.*, a.agency_name
                FROM category c LEFT JOIN agency a ON a.agency_id = c.agency_id
                WHERE c.requested_by = ?
                ORDER BY c.category_id DESC";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Hot zones (LGAs with many reports) for the public hot-zone view. */
    public function hot_zones($threshold = 3, $limit = 20)
    {
        $limit = (int) $limit;
        $sql = "SELECT l.lga_name, s.state_name, COUNT(e.alert_id) AS total,
                       AVG(e.latitude) AS avg_lat, AVG(e.longitude) AS avg_lng
                FROM emergency_alert_table e
                JOIN lga l ON l.lga_id = e.lga_id
                LEFT JOIN state s ON s.state_id = l.state_id
                GROUP BY e.lga_id, l.lga_name, s.state_name
                HAVING total >= ?
                ORDER BY total DESC
                LIMIT $limit";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$threshold]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Reported points with coordinates, for plotting the hot-zone map. */
    public function incident_points($limit = 500)
    {
        $limit = (int) $limit;
        $sql = "SELECT e.latitude, e.longitude, c.category_name, e.alert_status
                FROM emergency_alert_table e
                LEFT JOIN category c ON c.category_id = e.emergency_type
                WHERE e.latitude IS NOT NULL AND e.longitude IS NOT NULL
                ORDER BY e.alert_id DESC LIMIT $limit";
        return $this->dbconn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Reports filed by a single user, newest first. */
    public function fetch_user_incidents($user_id)
    {
        $sql = "SELECT e.*, c.category_name, l.lga_name
                FROM emergency_alert_table e
                LEFT JOIN category c ON c.category_id = e.emergency_type
                LEFT JOIN lga l ON l.lga_id = e.lga_id
                WHERE e.user_id = ?
                ORDER BY e.alert_id DESC";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Every report, with user and category details (admin view). */
    public function fetch_all_incidents()
    {
        $sql = "SELECT e.*, c.category_name, l.lga_name, u.user_fullname AS reporter
                FROM emergency_alert_table e
                LEFT JOIN category c ON c.category_id = e.emergency_type
                LEFT JOIN lga l ON l.lga_id = e.lga_id
                LEFT JOIN User u ON u.user_id = e.user_id
                ORDER BY e.alert_id DESC";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Update the status of a single report (admin action). */
    public function update_status($alert_id, $status)
    {
        $stmt = $this->dbconn->prepare(
            "UPDATE emergency_alert_table SET alert_status = ? WHERE alert_id = ?"
        );
        return $stmt->execute([$status, $alert_id]);
    }

    /** Count reports, optionally scoped to one user. */
    public function count_incidents($user_id = null)
    {
        if ($user_id === null) {
            $stmt = $this->dbconn->query("SELECT COUNT(*) FROM emergency_alert_table");
        } else {
            $stmt = $this->dbconn->prepare(
                "SELECT COUNT(*) FROM emergency_alert_table WHERE user_id = ?"
            );
            $stmt->execute([$user_id]);
        }
        return (int) $stmt->fetchColumn();
    }

    /** Count reports with a given status, optionally scoped to one user. */
    public function count_by_status($status, $user_id = null)
    {
        if ($user_id === null) {
            $stmt = $this->dbconn->prepare(
                "SELECT COUNT(*) FROM emergency_alert_table WHERE alert_status = ?"
            );
            $stmt->execute([$status]);
        } else {
            $stmt = $this->dbconn->prepare(
                "SELECT COUNT(*) FROM emergency_alert_table WHERE alert_status = ? AND user_id = ?"
            );
            $stmt->execute([$status, $user_id]);
        }
        return (int) $stmt->fetchColumn();
    }

    public function police_station($lga_id)
    {
        $sql = "SELECT * FROM police_unit
                JOIN lga ON lga.lga_id = police_unit.police_unit_location
                WHERE police_unit_location = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$lga_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function hospital($lga_id)
    {
        $sql = "SELECT * FROM medical_unit
                JOIN lga ON lga.lga_id = medical_unit.medical_unit_location
                WHERE medical_unit_location = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$lga_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fire_station($lga_id)
    {
        $sql = "SELECT * FROM fire_unit
                JOIN lga ON lga.lga_id = fire_unit.fire_unit_location
                WHERE fire_unit_location = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$lga_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ---------------- Cross-location resolution ---------------- */

    /**
     * Resolve an LGA id to its name and parent state. Returns null if unknown.
     */
    public function get_location($lga_id)
    {
        $sql = "SELECT l.lga_id, l.lga_name, s.state_id, s.state_name
                FROM lga l
                LEFT JOIN state s ON s.state_id = l.state_id
                WHERE l.lga_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$lga_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Find response units for an emergency, widening the search so reports are
     * useful across every location: first the exact LGA, then – if none are
     * registered there – every unit in the same state.
     *
     * @param string $type one of 'medical', 'fire', 'police'
     * @return array{units: array, scope: string} scope is 'lga', 'state' or 'none'
     */
    public function find_units($type, $lga_id)
    {
        $map = [
            'medical' => ['medical_unit', 'medical_unit_location'],
            'fire'    => ['fire_unit', 'fire_unit_location'],
            'police'  => ['police_unit', 'police_unit_location'],
        ];
        if (!isset($map[$type])) {
            return ['units' => [], 'scope' => 'none'];
        }
        [$table, $locCol] = $map[$type];

        // 1) Exact LGA match.
        $sql = "SELECT u.*, lga.lga_name
                FROM $table u
                JOIN lga ON lga.lga_id = u.$locCol
                WHERE u.$locCol = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$lga_id]);
        $units = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($units) {
            return ['units' => $units, 'scope' => 'lga'];
        }

        // 2) Fall back to any unit in the same state.
        $sql = "SELECT u.*, lga.lga_name
                FROM $table u
                JOIN lga ON lga.lga_id = u.$locCol
                WHERE lga.state_id = (SELECT state_id FROM lga WHERE lga_id = ?)
                ORDER BY lga.lga_name";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$lga_id]);
        $units = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return ['units' => $units, 'scope' => $units ? 'state' : 'none'];
    }
}
