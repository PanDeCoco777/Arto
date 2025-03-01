<?php
// Setup script for ArtiSell

$error = '';
$success = '';

// Check if database configuration file exists
if (!file_exists('config/database.php')) {
    $error = 'Database configuration file not found. Please create config/database.php first.';
} else {
    // Try to connect to database
    try {
        require_once 'config/database.php';
        
        // Check if tables exist
        $tables = ['users', 'user_profiles', 'remember_tokens', 'password_resets', 'product_categories', 'products', 'product_images', 'carts', 'cart_items', 'orders', 'order_items', 'favorites', 'favorite_artisans'];
        $missing_tables = [];
        
        foreach ($tables as $table) {
            $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
            $stmt->execute([$table]);
            if ($stmt->rowCount() === 0) {
                $missing_tables[] = $table;
            }
        }
        
        if (!empty($missing_tables)) {
            // Tables are missing, import database
            if (file_exists('artisell.sql')) {
                // Read SQL file
                $sql = file_get_contents('artisell.sql');
                
                // Split SQL commands by semicolon
                $commands = explode(';', $sql);
                
                // Execute each command
                foreach ($commands as $command) {
                    $command = trim($command);
                    if (!empty($command)) {
                        $pdo->exec($command);
                    }
                }
                
                $success = 'Database setup completed successfully!';
            } else {
                $error = 'SQL file not found. Please make sure artisell.sql exists in the root directory.';
            }
        } else {
            $success = 'Database is already set up and ready to use!';
        }
    } catch (PDOException $e) {
        $error = 'Database connection failed: ' . $e->getMessage();
    }
}

// Include header
include_once 'includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-6">
            <h1 class="text-2xl font-bold text-white">ArtiSell Setup</h1>
            <p class="text-amber-100">Initialize your Cebu Artisan Marketplace</p>
        </div>
        
        <div class="p-6">
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <h3 class="font-bold">Error</h3>
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <h3 class="font-bold">Success</h3>
                    <p><?php echo $success; ?></p>
                </div>
                
                <div class="mt-6">
                    <h3 class="font-bold text-lg text-amber-800 mb-4">Next Steps</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                            <span>Database setup complete</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-arrow-right text-amber-500 mt-1 mr-2"></i>
                            <span>You can now <a href="index.php" class="text-amber-600 hover:text-amber-800 font-medium">visit the homepage</a> or <a href="auth/login.php" class="text-amber-600 hover:text-amber-800 font-medium">log in</a> to your account</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-1 mr-2"></i>
                            <span>Default admin login: admin@artisell.com / password</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mt-1 mr-2"></i>
                            <span>Default user login: user@artisell.com / password</span>
                        </li>
                    </ul>
                </div>
                
                <div class="mt-6 flex justify-center">
                    <a href="index.php" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded transition-colors">
                        Go to Homepage
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-cog fa-spin text-4xl text-amber-500 mb-4"></i>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Setting up ArtiSell</h2>
                    <p class="text-gray-600">Please wait while we configure your database...</p>
                    <div class="mt-6">
                        <form method="POST" action="setup.php">
                            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded transition-colors">
                                Run Setup
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
