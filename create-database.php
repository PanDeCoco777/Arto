<?php
// Create a new database using SQL script

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "<h2>ArtiSell Database Creation Tool</h2>";
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `artisell` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `artisell`");
    
    echo "<p>Database 'artisell' created successfully.</p>";
    
    // Read SQL file
    $sql_file = file_get_contents('artisell.sql');
    
    if (!$sql_file) {
        die("<p>Error: Could not read the SQL file.</p>");
    }
    
    // Split SQL commands by semicolon
    $commands = explode(';', $sql_file);
    
    // Execute each command
    foreach ($commands as $command) {
        $command = trim($command);
        if (!empty($command)) {
            $pdo->exec($command);
        }
    }
    
    echo "<p>Database tables created successfully!</p>";
    echo "<p>You can now <a href='index.php'>login to the application</a>.</p>";
    
} catch (PDOException $e) {
    die("<p>Database creation failed: " . $e->getMessage() . "</p>");
}
