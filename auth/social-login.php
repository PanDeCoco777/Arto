<?php
// Start session
session_start();

// Include database configuration
require_once '../config/database.php';

// Get provider from URL parameter
$provider = isset($_GET['provider']) ? $_GET['provider'] : '';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

// Validate provider
if (!in_array($provider, ['google', 'facebook', 'github'])) {
    $_SESSION['error'] = "Invalid authentication provider";
    header("Location: ../index.php");
    exit;
}

// In a real application, you would implement OAuth flow with the selected provider
// For demonstration purposes, we'll simulate a successful social login

// Generate a random user ID and email based on provider
$social_id = uniqid($provider . '_');
$name = ucfirst($provider) . ' User';
$email = $social_id . '@example.com';

try {
    // Connect to database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if user with this social ID exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE social_id = :social_id AND social_provider = :provider LIMIT 1");
    $stmt->bindParam(':social_id', $social_id);
    $stmt->bindParam(':provider', $provider);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        // User exists, log them in
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];
    } else {
        // User doesn't exist, create new account
        $stmt = $conn->prepare("INSERT INTO users (name, email, social_id, social_provider, role, created_at) 
                               VALUES (:name, :email, :social_id, :provider, 'user', NOW())");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':social_id', $social_id);
        $stmt->bindParam(':provider', $provider);
        $stmt->execute();
        
        $user_id = $conn->lastInsertId();
        
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = 'user';
    }
    
    // Redirect to dashboard
    header("Location: ../dashboard.php");
    exit;
    
} catch(PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    header("Location: ../index.php");
    exit;
}
?>