<?php
// Start session
session_start();

// Include database configuration
require_once '../config/database.php';

// Clear remember me cookie if it exists
if (isset($_COOKIE['remember_token'])) {
    // Connect to database to clear token
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Clear token in database
        $stmt = $conn->prepare("UPDATE users SET remember_token = NULL, token_expires = NULL WHERE id = :id");
        $stmt->bindParam(':id', $_SESSION['user_id']);
        $stmt->execute();
        
        // Delete cookie
        setcookie('remember_token', '', time() - 3600, '/', '', false, true);
    } catch(PDOException $e) {
        // Just log the error, don't stop the logout process
        error_log("Database error during logout: " . $e->getMessage());
    }
}

// Destroy session
session_unset();
session_destroy();

// Redirect to login page
header("Location: ../index.php");
exit;
?>