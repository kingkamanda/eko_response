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
                "</strong> database on <strong>" . htmlspecialchars(DBHOST) . "</strong>.</p>" .
                "<p>Check that MySQL is running and that the credentials are correct. " .
                "You can override them with the DB_HOST, DB_NAME, DB_USER and DB_PASS " .
                "environment variables (see the README).</p>"
            );
        }
    }
}
