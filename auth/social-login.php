<?php
require_once '../config/database.php';
session_start();

// This is a simplified mock implementation of social login
// In a real application, you would use OAuth libraries for each provider

$provider = isset($_GET['provider']) ? $_GET['provider'] : '';
$error = '';

if (empty($provider)) {
    $error = 'No provider specified';
} else {
    // Mock social login data
    $socialId = 'social_' . uniqid();
    $name = 'Social User';
    $email = 'social_' . uniqid() . '@example.com';
    
    try {
        // Check if user exists with this social ID
        $stmt = $pdo->prepare("SELECT * FROM users WHERE social_id = ? AND social_provider = ?");
        $stmt->execute([$socialId, $provider]);
        $user = $stmt->fetch();
        
        if (!$user) {
            // Check if email exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if (!$user) {
                // Create new user
                $stmt = $pdo->prepare("INSERT INTO users (name, email, social_id, social_provider, created_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt->execute([$name, $email, $socialId, $provider]);
                
                $userId = $pdo->lastInsertId();
                
                // Create user profile
                $profileStmt = $pdo->prepare("INSERT INTO user_profiles (user_id) VALUES (?)");
                $profileStmt->execute([$userId]);
                
                // Get the new user
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$userId]);
                $user = $stmt->fetch();
            } else {
                // Update existing user with social info
                $stmt = $pdo->prepare("UPDATE users SET social_id = ?, social_provider = ? WHERE id = ?");
                $stmt->execute([$socialId, $provider, $user['id']]);
            }
        }
        
        // Login the user
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['is_admin'] = $user['is_admin'];
        
        // Update last login time
        $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $updateStmt->execute([$user['id']]);
        
        header('Location: ../dashboard.php');
        exit;
        
    } catch (PDOException $e) {
        $error = 'Database error: ' . $e->getMessage();
    }
}

// Include header
include_once '../includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-center mb-6 text-amber-700">Social Login</h2>
            
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo $error; ?>
                </div>
                <p class="text-center mt-4">
                    <a href="login.php" class="text-amber-600 hover:text-amber-800 font-medium">
                        Back to login
                    </a>
                </p>
            <?php else: ?>
                <div class="text-center">
                    <p class="mb-4">Connecting to <?php echo ucfirst($provider); ?>...</p>
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-amber-700 mx-auto"></div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>
