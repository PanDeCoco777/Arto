<?php
require_once '../config/database.php';
session_start();

$error = '';
$success = '';
$validToken = false;
$tokenEmail = '';

// Check if token is valid
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    try {
        $stmt = $pdo->prepare("SELECT email, expires, used FROM password_resets WHERE token = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$token]);
        $reset = $stmt->fetch();
        
        if ($reset && !$reset['used'] && strtotime($reset['expires']) > time()) {
            $validToken = true;
            $tokenEmail = $reset['email'];
        } else {
            $error = 'Invalid or expired token';
        }
    } catch (PDOException $e) {
        $error = 'Database error: ' . $e->getMessage();
    }
} else {
    $error = 'No token provided';
}

// Process password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $validToken) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    if (empty($password) || empty($confirmPassword)) {
        $error = 'All fields are required';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long';
    } else {
        try {
            // Update user password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
            $stmt->execute([$hashedPassword, $tokenEmail]);
            
            // Mark token as used
            $stmt = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE token = ?");
            $stmt->execute([$token]);
            
            $success = 'Password has been reset successfully. You can now log in with your new password.';
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: ../dashboard.php');
    exit;
}

// Include header
include_once '../includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-center mb-6 text-amber-700">Reset Password</h2>
            
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo $success; ?>
                    <p class="mt-2"><a href="login.php" class="text-green-700 underline">Go to login page</a></p>
                </div>
            <?php elseif ($validToken): ?>
                <form method="POST" action="reset-password.php?token=<?php echo $token; ?>" class="space-y-4">
                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <p class="text-xs text-gray-500">Password must be at least 8 characters long</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-amber-500">
                        Reset Password
                    </button>
                </form>
            <?php endif; ?>
            
            <p class="mt-6 text-center text-sm text-gray-600">
                <a href="login.php" class="text-amber-600 hover:text-amber-800 font-medium">
                    Back to login
                </a>
            </p>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>
