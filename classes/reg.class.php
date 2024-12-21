<?php
/**
 * reg.class.php
 *
 * @package Radio Contacts
 * @author Nitestryker
 * @copyright 2024 Nitestryker Software
 * @license GPL 2 (http://www.gnu.org/licenses/gpl.html)
 *
 * @version 0.0.1
 */

 session_start(); // Start a session to store messages
class reg
{
    public function regUser()
    {
        // Get form data
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prevent XSS attacks
        $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $hashedPassword = htmlspecialchars($hashedPassword, ENT_QUOTES, 'UTF-8');

        // Connect to the database
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Registration successful! You can now login.";
            header("Location: index.php");
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Error: ' . $stmt->error . '</div>';
        }

        $stmt->close();
        $conn->close();
    }
}
?>
