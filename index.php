<?php
/**
 * index.php
 *
 * @package Radio Contacts
 * @author Nitestryker
 * @copyright 2024-2025 Nitestryker Software
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @version 0.0.1
*/
// include configuration file once
include("include/config.php");

// start session 
session_start();
// error reporting 
error_reporting(1);
$action = (isset($_GET['action'])) ? $_GET['action'] : "null";

include 'templates/main.tpl.php';