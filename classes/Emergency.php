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
        $lga
    ) {
        try {
            $imageName = $this->saveUpload($incident_img, ['jpg', 'jpeg', 'png', 'gif']);
            $videoName = $this->saveUpload($incident_vid, ['mp4', 'mov', 'avi', 'webm', 'mkv']);

            $query = "INSERT INTO emergency_alert_table
                        (user_id, user_fullname, user_phone, user_location, emergency_type,
                         alert_status, alert_time, emergency_alert_image, emergency_alert_video,
                         alert_desc, lga_id)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->dbconn->prepare($query);
            $stmt->execute([
                $user_id, $fullname, $phone, $location, $emergency,
                $status, $time, $imageName, $videoName, $description, $lga
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

    /** All emergency categories, for the report-form dropdown. */
    public function fetch_category()
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM category ORDER BY category_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}
