<?php
session_start();
require_once '../config/database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    if (empty($email)) {
        $_SESSION['error'] = "Email is required";
        header("Location: ../forgot-password.php");
        exit;
    }
    
    try {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Generate reset token
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiry
            
            // Store token in database
            $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)");
            $stmt->execute([$email, $token, $expires]);
            
            // In a real application, you would send an email with the reset link
            // For demonstration, we'll just show a success message
            $_SESSION['success'] = "Password reset link has been sent to your email";
            
            // For demo purposes, create a link that would normally be in the email
            $_SESSION['reset_link'] = "reset-password.php?token=$token";
        } else {
            // Don't reveal that the user doesn't exist for security reasons
            $_SESSION['success'] = "If your email is registered, you will receive a password reset link";
        }
        
        header("Location: ../forgot-password.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header("Location: ../forgot-password.php");
        exit;
    }
} else {
    // Display the form
    include_once '../includes/header.php';
?>

<div class="min-h-screen bg-amber-50 flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full space-y-8 bg-white p-6 rounded-xl shadow-md">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-amber-800">Forgot Password</h2>
            <p class="mt-2 text-center text-sm text-amber-600">Enter your email address and we'll send you a link to reset your password.</p>
        </div>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
                
                <?php if (isset($_SESSION['reset_link'])): ?>
                    <div class="mt-2">
                        <p class="text-sm">Demo reset link (this would normally be sent via email):</p>
                        <a href="<?php echo $_SESSION['reset_link']; ?>" class="text-blue-500 underline"><?php echo $_SESSION['reset_link']; ?></a>
                    </div>
                    <?php unset($_SESSION['reset_link']); ?>
                <?php endif; ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <form class="mt-8 space-y-6" action="forgot-password.php" method="POST">
            <div>
                <label for="email" class="block text-sm font-medium text-amber-700">Email address</label>
                <input id="email" name="email" type="email" required class="mt-1 block w-full px-3 py-2 border border-amber-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-amber-500 focus:border-amber-500">
            </div>
            
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                    Send Reset Link
                </button>
            </div>
            
            <div class="text-center">
                <a href="../index.php" class="font-medium text-amber-600 hover:text-amber-500">Back to login</a>
            </div>
        </form>
    </div>
</div>

<?php
    include_once '../includes/footer.php';
}
