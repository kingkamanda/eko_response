<?php
/**
 * Database configuration.
 *
 * Credentials are read from environment variables so they never have to be
 * hard-coded or committed. Sensible local-development defaults are used when
 * the variables are not set.
 */

define("DBHOST", getenv("DB_HOST") ?: "localhost");
define("DBNAME", getenv("DB_NAME") ?: "response");
define("DBUSER", getenv("DB_USER") ?: "root");
define("DBPASS", getenv("DB_PASS") ?: "root");
