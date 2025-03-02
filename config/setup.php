<?php
// Include database configuration
require_once 'database.php';

// Function to create the database if it doesn't exist
function createDatabase() {
    global $host, $dbname, $username, $password_db;
    
    try {
        $conn = new PDO("mysql:host=$host", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create database if it doesn't exist
        $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        return true;
    } catch(PDOException $e) {
        return false;
    }
}

// Function to check if setup is complete
function isSetupComplete() {
    if (!checkDatabaseConnection()) {
        return false;
    }
    
    global $host, $dbname, $username, $password_db;
    
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check if users table exists and has at least one admin user
        $stmt = $conn->prepare("SHOW TABLES LIKE 'users'");
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE role = 'admin' LIMIT 1");
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        }
        
        return false;
    } catch(PDOException $e) {
        return false;
    }
}
?>