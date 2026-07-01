<?php
/**
 * Admin database configuration. Mirrors classes/config.php and reads the same
 * environment variables so both areas of the app share one set of credentials.
 */

define("DBHOST", getenv("DB_HOST") ?: "localhost");
define("DBPORT", getenv("DB_PORT") ?: "3306");
define("DBNAME", getenv("DB_NAME") ?: "response");
define("DBUSER", getenv("DB_USER") ?: "root");
define("DBPASS", getenv("DB_PASS") ?: "");
