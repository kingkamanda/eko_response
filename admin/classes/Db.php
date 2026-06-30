<?php
require_once __DIR__ . '/config.php';

/**
 * Base data-access class for the admin area.
 */
class Db
{
    private $dbhost = DBHOST;
    private $dbname = DBNAME;
    private $dbuser = DBUSER;
    private $dbpass = DBPASS;

    protected $conn;

    protected function connect()
    {
        if ($this->conn instanceof PDO) {
            return $this->conn;
        }

        $dsn = "mysql:host={$this->dbhost};dbname={$this->dbname};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->conn = new PDO($dsn, $this->dbuser, $this->dbpass, $options);
            return $this->conn;
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            http_response_code(500);
            exit(
                "<h2>Database connection error</h2>" .
                "<p>The admin area could not connect to the <strong>" . htmlspecialchars(DBNAME) .
                "</strong> database as user <strong>" . htmlspecialchars(DBUSER) .
                "</strong> on <strong>" . htmlspecialchars(DBHOST) . "</strong>.</p>" .
                "<p><strong>Reason:</strong> " . htmlspecialchars($e->getMessage()) . "</p>" .
                "<ul>" .
                "<li><code>[1045] Access denied</code> &rarr; wrong password. Set it with " .
                "<code>DB_PASS</code> or edit <code>admin/classes/config.php</code> (see SETUP.md).</li>" .
                "<li><code>[1049] Unknown database</code> &rarr; import <code>Eko Response.sql</code> first.</li>" .
                "<li><code>[2002]</code> / connection refused &rarr; MySQL isn't running.</li>" .
                "</ul>"
            );
        }
    }
}
