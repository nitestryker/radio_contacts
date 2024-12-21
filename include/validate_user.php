<?php
/**
 * validate_user.php
 *
 * @package Radio Contacts
 * @author Nitestryker
 * @copyright 2024 Nitestryker Software
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @version 0.0.1
 */


require_once '../include/config.php';

header('Content-Type: application/json');

$response = ["status" => "error", "message" => "Invalid request"];

if (isset($_POST['field']) && isset($_POST['value'])) {
    $field = $_POST['field'];
    $value = $_POST['value'];

    // Validate the field
    if (!in_array($field, ['username', 'email'])) {
        $response['message'] = "Invalid field.";
        echo json_encode($response);
        exit;
    }

    // Connect to the database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        $response['message'] = "Database connection failed.";
        echo json_encode($response);
        exit;
    }

    // Check if the username or email exists
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM users WHERE $field = ?");
    $stmt->bind_param("s", $value);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    if ($count > 0) {
        $response = ["status" => "taken", "message" => ucfirst($field) . " is already in use."];
    } else {
        $response = ["status" => "available", "message" => ucfirst($field) . " is available."];
    }

    $stmt->close();
    $conn->close();
}

echo json_encode($response);
?>
