<?php
// Start session
session_start();

// Include database configuration
require_once '../config/database.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields";
        header("Location: ../index.php");
        exit;
    }
    
    try {
        // Connect to database
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare SQL statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Check if user exists
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // Set remember me cookie if checked
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    $expires = time() + (86400 * 30); // 30 days
                    
                    // Store token in database
                    $stmt = $conn->prepare("UPDATE users SET remember_token = :token, token_expires = :expires WHERE id = :id");
                    $stmt->bindParam(':token', $token);
                    $stmt->bindParam(':expires', $expires);
                    $stmt->bindParam(':id', $user['id']);
                    $stmt->execute();
                    
                    // Set cookie
                    setcookie('remember_token', $token, $expires, '/', '', false, true);
                }
                
                // Redirect to dashboard
                header("Location: ../dashboard.php");
                exit;
            } else {
                $_SESSION['error'] = "Invalid email or password";
            }
        } else {
            $_SESSION['error'] = "Invalid email or password";
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }
    
    // Redirect back to login page with error
    header("Location: ../index.php");
    exit;
}

// If not POST request, redirect to login page
header("Location: ../index.php");
exit;
?>