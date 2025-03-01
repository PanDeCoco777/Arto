<?php
// Database import script for ArtiSell

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';

// Connect to MySQL server
try {
    $pdo = new PDO("mysql:host=$host", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "<h2>ArtiSell Database Import Tool</h2>";
    
    // Read SQL file
    $sql_file = file_get_contents('artisell.sql');
    
    if (!$sql_file) {
        die("<p>Error: Could not read the SQL file.</p>");
    }
    
    // Execute SQL commands
    $pdo->exec($sql_file);
    
    echo "<p>Database imported successfully!</p>";
    echo "<p>You can now <a href='index.php'>login to the application</a>.</p>";
    
} catch (PDOException $e) {
    die("<p>Database import failed: " . $e->getMessage() . "</p>");
}
