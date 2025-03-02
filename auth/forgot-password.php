<?php
// Start session
session_start();

// Include database configuration
require_once '../config/database.php';

// Include header
include_once '../includes/header.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address";
    } else {
        try {
            // Connect to database
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Check if email exists
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Generate reset token
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                
                // Store token in database
                $stmt = $conn->prepare("UPDATE users SET reset_token = :token, reset_expires = :expires WHERE id = :id");
                $stmt->bindParam(':token', $token);
                $stmt->bindParam(':expires', $expires);
                $stmt->bindParam(':id', $user['id']);
                $stmt->execute();
                
                // Send email with reset link (in a real application)
                $reset_link = "http://{$_SERVER['HTTP_HOST']}/artisell/auth/reset-password.php?token=$token";
                
                // For demonstration purposes, we'll just show the link
                $success = "A password reset link has been sent to your email. <br>For demonstration: <a href='$reset_link' class='text-amber-600 hover:underline'>Reset Password Link</a>";
            } else {
                // Don't reveal if email exists or not for security
                $success = "If your email exists in our system, you will receive a password reset link shortly.";
            }
        } catch(PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<div class="min-h-screen bg-amber-50">
    <div class="relative min-h-screen w-full overflow-hidden">
        <!-- Background elements (same as index.php) -->
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-amber-200 opacity-30 blur-3xl"></div>
        <div class="absolute top-1/4 -left-24 h-96 w-96 rounded-full bg-orange-200 opacity-30 blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 h-96 w-96 rounded-full bg-red-200 opacity-20 blur-3xl"></div>
        
        <!-- Content container -->
        <div class="relative z-10 flex min-h-screen items-center justify-center px-4">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center">
                    <h1 class="text-3xl font-bold text-amber-800">Forgot Password</h1>
                    <p class="text-amber-700 mt-2">Enter your email to receive a password reset link</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6">
                    <?php if (isset($error)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($success)): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            <?php echo $success; ?>
                        </div>
                    <?php else: ?>
                        <form method="post" action="forgot-password.php" class="space-y-4">
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium">Email</label>
                                <input id="email" name="email" type="email" placeholder="Enter your email" 
                                       class="w-full rounded-md border border-input px-3 py-2" required>
                            </div>
                            
                            <div class="pt-2">
                                <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded-md">
                                    Send Reset Link
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                    
                    <div class="mt-4 text-center">
                        <a href="../index.php" class="text-amber-600 hover:text-amber-800 text-sm">
                            Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
include_once '../includes/footer.php';
?>