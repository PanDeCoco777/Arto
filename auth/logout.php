<?php
session_start();
require_once '../config/database.php';

// Clear remember token if exists
if (isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    
    // Delete token from database
    try {
        $stmt = $pdo->prepare("DELETE FROM remember_tokens WHERE token = ?");
        $stmt->execute([$token]);
    } catch (PDOException $e) {
        // Log error but continue with logout
        error_log("Error deleting remember token: " . $e->getMessage());
    }
    
    // Delete cookie
    setcookie('remember_token', '', time() - 3600, '/', '', false, true);
}

// Destroy session
session_unset();
session_destroy();

// Redirect to login page
header("Location: ../index.php");
exit;
