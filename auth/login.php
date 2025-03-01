<?php
session_start();
require_once '../config/database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required";
        header("Location: ../index.php?tab=login");
        exit;
    }
    
    try {
        // Prepare SQL statement
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            
            // Set remember me cookie if checked
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $expires = time() + (86400 * 30); // 30 days
                
                // Store token in database
                $stmt = $pdo->prepare("INSERT INTO remember_tokens (user_id, token, expires) VALUES (?, ?, ?)");
                $stmt->execute([$user['id'], $token, date('Y-m-d H:i:s', $expires)]);
                
                // Set cookie
                setcookie('remember_token', $token, $expires, '/', '', false, true);
            }
            
            // Update last login time
            $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
            $stmt->execute([$user['id']]);
            
            // Redirect to dashboard
            header("Location: ../dashboard.php");
            exit;
        } else {
            // Invalid credentials
            $_SESSION['error'] = "Invalid email or password";
            header("Location: ../index.php?tab=login");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: ../index.php?tab=login");
        exit;
    }
} else {
    // If not POST request, redirect to login page
    header("Location: ../index.php?tab=login");
    exit;
}
