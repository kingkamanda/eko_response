<?php
    ini_set("display_errors", "1");
    require_once('Db.php');

    class State extends Db
    {
        private $dbconn;

        public function __construct()
        {
            $this->dbconn = $this->connect();
        }

    public function get_state()
    {   #SQL query to retieve state names
        $sqlquery = "SELECT * FROM state";
        #prepare
        $stmt = $this->dbconn->prepare($sqlquery);
        #execute
        $stmt->execute();

        #fetch all state name
        $state = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $state;
    }

    // public function getLocalGovernment($state_id)
    // public function getLocalGovernment( )
    // {
    //     $sqlquery = "SELECT * FROM lga WHERE state_id = 24";

    //     $stmt = $this->dbconn->prepare($sqlquery);
        
    //     $stmt->execute();

    //     // $stmt->execute([$state_id]);

    //     $lga = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     return $lga;


    // }
     public function getLocalGovernment( )
    {
        $sqlquery = "SELECT * FROM lga";

        $stmt = $this->dbconn->prepare($sqlquery);
        
        $stmt->execute();

        // $stmt->execute([$state_id]);

        $lga = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $lga;


    }
}
?>