<?php
// Start session
session_start();

// Include database configuration
require_once '../config/database.php';

// Include header
include_once '../includes/header.php';

// Check if token is provided
$token = isset($_GET['token']) ? $_GET['token'] : '';
$valid_token = false;
$token_expired = false;
$user_id = null;

if (!empty($token)) {
    try {
        // Connect to database
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Check if token exists and is valid
        $stmt = $conn->prepare("SELECT id, reset_expires FROM users WHERE reset_token = :token LIMIT 1");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $user_id = $user['id'];
            
            // Check if token has expired
            $expires = strtotime($user['reset_expires']);
            if ($expires > time()) {
                $valid_token = true;
            } else {
                $token_expired = true;
            }
        }
    } catch(PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && $valid_token) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate passwords
    if (empty($password) || strlen($password) < 8) {
        $error = "Password must be at least 8 characters";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        try {
            // Hash new password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Update user password and clear reset token
            $stmt = $conn->prepare("UPDATE users SET password = :password, reset_token = NULL, reset_expires = NULL WHERE id = :id");
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();
            
            $success = "Your password has been reset successfully. You can now login with your new password.";
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
                    <h1 class="text-3xl font-bold text-amber-800">Reset Password</h1>
                    <p class="text-amber-700 mt-2">Create a new password for your account</p>
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
                        <div class="text-center mt-4">
                            <a href="../index.php" class="bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded-md inline-block">
                                Go to Login
                            </a>
                        </div>
                    <?php elseif ($valid_token): ?>
                        <form method="post" action="reset-password.php?token=<?php echo $token; ?>" class="space-y-4">
                            <div class="space-y-2">
                                <label for="password" class="block text-sm font-medium">New Password</label>
                                <div class="relative">
                                    <input id="password" name="password" type="password" placeholder="Enter new password" 
                                           class="w-full rounded-md border border-input px-3 py-2" required>
                                    <button type="button" onclick="togglePasswordVisibility('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-amber-700">
                                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        <svg id="eye-off-icon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                                            <line x1="2" x2="22" y1="2" y2="22"/>
                                        </svg>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500">Password must be at least 8 characters</p>
                            </div>
                            
                            <div class="space-y-2">
                                <label for="confirm-password" class="block text-sm font-medium">Confirm New Password</label>
                                <div class="relative">
                                    <input id="confirm-password" name="confirm_password" type="password" placeholder="Confirm new password" 
                                           class="w-full rounded-md border border-input px-3 py-2" required>
                                    <button type="button" onclick="togglePasswordVisibility('confirm-password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-amber-700">
                                        <svg id="confirm-eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        <svg id="confirm-eye-off-icon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                                            <line x1="2" x2="22" y1="2" y2="22"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="pt-2">
                                <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded-md">
                                    Reset Password
                                </button>
                            </div>
                        </form>
                    <?php elseif ($token_expired): ?>
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                            This password reset link has expired. Please request a new one.
                        </div>
                        <div class="text-center mt-4">
                            <a href="forgot-password.php" class="bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded-md inline-block">
                                Request New Link
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            Invalid password reset link. Please request a new one.
                        </div>
                        <div class="text-center mt-4">
                            <a href="forgot-password.php" class="bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded-md inline-block">
                                Request New Link
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(inputId === 'password' ? 'eye-icon' : 'confirm-eye-icon');
        const eyeOffIcon = document.getElementById(inputId === 'password' ? 'eye-off-icon' : 'confirm-eye-off-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeOffIcon.classList.add('hidden');
            eyeIcon.classList.remove('hidden');
        }
    }
</script>

<?php
// Include footer
include_once '../includes/footer.php';
?>