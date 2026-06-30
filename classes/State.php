<?php
require_once __DIR__ . '/Db.php';

class State extends Db
{
    private $dbconn;

    public function __construct()
    {
        $this->dbconn = $this->connect();
    }

    /** Return every state, ordered by name. */
    public function get_state()
    {
        $stmt = $this->dbconn->prepare("SELECT * FROM state ORDER BY state_name");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Return the local government areas that belong to a given state.
     * Used by the state -> LGA AJAX dropdown on the sign-up and report forms.
     */
    public function getLocalGovernment($state_id)
    {
        $stmt = $this->dbconn->prepare(
            "SELECT * FROM lga WHERE state_id = ? ORDER BY lga_name"
        );
        $stmt->execute([$state_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
