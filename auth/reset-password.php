<?php
session_start();
require_once '../config/database.php';

// Check if token is provided
if (!isset($_GET['token'])) {
    $_SESSION['error'] = "Invalid password reset link";
    header("Location: ../index.php");
    exit;
}

$token = $_GET['token'];

// Verify token
try {
    $stmt = $pdo->prepare("SELECT * FROM password_resets WHERE token = ? AND expires > NOW() AND used = 0");
    $stmt->execute([$token]);
    $reset = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$reset) {
        $_SESSION['error'] = "Invalid or expired password reset link";
        header("Location: ../index.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "An error occurred: " . $e->getMessage();
    header("Location: ../index.php");
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate passwords
    if (strlen($password) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters";
        header("Location: reset-password.php?token=$token");
        exit;
    }
    
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match";
        header("Location: reset-password.php?token=$token");
        exit;
    }
    
    try {
        // Begin transaction
        $pdo->beginTransaction();
        
        // Update user password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashed_password, $reset['email']]);
        
        // Mark token as used
        $stmt = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE token = ?");
        $stmt->execute([$token]);
        
        // Commit transaction
        $pdo->commit();
        
        $_SESSION['success'] = "Your password has been reset successfully. You can now login with your new password.";
        header("Location: ../index.php");
        exit;
    } catch (PDOException $e) {
        // Rollback transaction on error
        $pdo->rollBack();
        
        $_SESSION['error'] = "Password reset failed: " . $e->getMessage();
        header("Location: reset-password.php?token=$token");
        exit;
    }
} else {
    // Display the form
    include_once '../includes/header.php';
?>

<div class="min-h-screen bg-amber-50 flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full space-y-8 bg-white p-6 rounded-xl shadow-md">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-amber-800">Reset Password</h2>
            <p class="mt-2 text-center text-sm text-amber-600">Enter your new password below.</p>
        </div>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <form class="mt-8 space-y-6" action="reset-password.php?token=<?php echo $token; ?>" method="POST">
            <div>
                <label for="password" class="block text-sm font-medium text-amber-700">New Password</label>
                <input id="password" name="password" type="password" required class="mt-1 block w-full px-3 py-2 border border-amber-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
                <p class="text-xs text-gray-500 mt-1">Password must be at least 8 characters</p>
            </div>
            
            <div>
                <label for="confirm_password" class="block text-sm font-medium text-amber-700">Confirm New Password</label>
                <input id="confirm_password" name="confirm_password" type="password" required class="mt-1 block w-full px-3 py-2 border border-amber-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
            </div>
            
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
}
