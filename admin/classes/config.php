<?php
/**
 * Admin database configuration. Mirrors classes/config.php and reads the same
 * environment variables so both areas of the app share one set of credentials.
 */

define("DBHOST", getenv("DB_HOST") ?: "localhost");
define("DBNAME", getenv("DB_NAME") ?: "Response");
define("DBUSER", getenv("DB_USER") ?: "root");
define("DBPASS", getenv("DB_PASS") ?: "root");
