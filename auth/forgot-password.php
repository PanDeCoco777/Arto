<?php
require_once '../config/database.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    if (empty($email)) {
        $error = 'Please enter your email address';
    } else {
        try {
            // Check if email exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() === 0) {
                $error = 'No account found with that email address';
            } else {
                // Generate token
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                // Store token in database
                $stmt = $pdo->prepare("INSERT INTO password_resets (email, token, expires, created_at) VALUES (?, ?, ?, NOW())");
                $stmt->execute([$email, $token, $expires]);
                
                // In a real application, you would send an email with the reset link
                // For this demo, we'll just show the link
                $resetLink = "http://localhost/artisell/auth/reset-password.php?token=$token";
                
                $success = 'Password reset instructions have been sent to your email address.';
            }
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
            <h2 class="text-2xl font-bold text-center mb-6 text-amber-700">Forgot Password</h2>
            
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo $success; ?>
                    <?php if (isset($resetLink)): ?>
                        <p class="mt-2">Demo reset link: <a href="<?php echo $resetLink; ?>" class="text-green-700 underline"><?php echo $resetLink; ?></a></p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p class="mb-4 text-gray-600">Enter your email address and we'll send you a link to reset your password.</p>
                
                <form method="POST" action="forgot-password.php" class="space-y-4">
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-amber-500">
                        Send Reset Link
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
