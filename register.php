<?php
/**
 * register.php -  Register a new user
 *
 * @package Radio Contacts
 * @author Nitestryker
 * @copyright 2024 Nitestryker Software
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @version 0.0.1
*/
// include configuration file once
include_once("include/config.php");
//include reg.class.php
include_once("classes/reg.class.php");
// Include the class file
require_once 'classes/reg.class.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create an object of the reg class
    $registration = new reg();

    // Call the regUser method
    $registration->regUser();
}

?>

