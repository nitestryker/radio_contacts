<?php
/**
 * /include/config.php
 *
 * @package Radio Contacts
 */

// Time Zone Configuration
date_default_timezone_set('America/Los_Angeles');

// Configuration constants
define('DB_HOST', 'localhost');
define('DB_USER', 'dev');
define('DB_PASS', '1234');
define('DB_NAME', 'cb');
define('BASE_URL', "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']));
define('SITE_ADMIN_EMAIL', 'nitestryker@bajj.org');
define('APP_NAME', 'Radio Contacts');
define('APP_VERSION', '1.0.8');
define('SITE_NAME', 'BAJJ');

?>