<?php
session_start();
require_once '../config/database.php';

// Get the provider from the URL
$provider = isset($_GET['provider']) ? $_GET['provider'] : '';

// This is a simplified version - in a real application, you would use OAuth libraries
// For demonstration purposes, we'll simulate the social login process

if ($provider) {
    // In a real application, you would redirect to the provider's OAuth endpoint
    // For demonstration, we'll simulate a successful authentication
    
    // Generate a fake user profile based on the provider
    $social_id = 'social_' . $provider . '_' . rand(10000, 99999);
    $name = 'Demo User';
    $email = 'demo.' . $provider . '.' . rand(100, 999) . '@example.com';
    
    try {
        // Check if user with this social ID exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE social_id = ? AND social_provider = ?");
        $stmt->execute([$social_id, $provider]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // User exists, log them in
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            
            // Update last login time
            $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $stmt->execute([$user['id']]);
        } else {
            // User doesn't exist, create a new account
            $stmt = $pdo->prepare("INSERT INTO users (name, email, social_id, social_provider, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $social_id, $provider]);
            $user_id = $pdo->lastInsertId();
            
            // Create user profile
            $stmt = $pdo->prepare("INSERT INTO user_profiles (user_id) VALUES (?)");
            $stmt->execute([$user_id]);
            
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
        }
        
        // Redirect to dashboard
        header("Location: ../dashboard.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Social login failed: " . $e->getMessage();
        header("Location: ../index.php");
        exit;
    }
} else {
    // No provider specified
    $_SESSION['error'] = "Invalid social login provider";
    header("Location: ../index.php");
    exit;
}
