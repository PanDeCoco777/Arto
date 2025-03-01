<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}

require_once 'config/database.php';

// Get user information
try {
    $stmt = $pdo->prepare("SELECT u.*, p.* FROM users u LEFT JOIN user_profiles p ON u.id = p.user_id WHERE u.id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    
    if (!$user) {
        // User not found in database
        session_destroy();
        header('Location: auth/login.php');
        exit;
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Include header
include_once 'includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-6">
            <h1 class="text-2xl font-bold text-white">Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
            <p class="text-amber-100">Manage your account and explore Cebuano artisan products</p>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- User Profile Card -->
                <div class="bg-amber-50 rounded-lg p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="h-16 w-16 rounded-full bg-amber-200 flex items-center justify-center mr-4">
                            <?php if (!empty($user['profile_image'])): ?>
                                <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile" class="h-16 w-16 rounded-full object-cover">
                            <?php else: ?>
                                <span class="text-2xl text-amber-700 font-bold"><?php echo strtoupper(substr($user['name'], 0, 1)); ?></span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-amber-800"><?php echo htmlspecialchars($user['name']); ?></h2>
                            <p class="text-gray-600"><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>
                    <div class="border-t border-amber-200 pt-4 mt-4">
                        <h3 class="font-semibold text-amber-700 mb-2">Account Details</h3>
                        <ul class="space-y-2 text-sm">
                            <li class="flex justify-between">
                                <span class="text-gray-600">Member Since:</span>
                                <span class="font-medium"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-600">Last Login:</span>
                                <span class="font-medium"><?php echo $user['last_login'] ? date('M d, Y H:i', strtotime($user['last_login'])) : 'N/A'; ?></span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-600">Account Type:</span>
                                <span class="font-medium"><?php echo $user['is_admin'] ? 'Administrator' : 'Customer'; ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-6">
                        <a href="#" class="block text-center bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded transition-colors">
                            Edit Profile
                        </a>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h3 class="font-bold text-lg text-amber-800 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                            <i class="fas fa-shopping-cart text-2xl text-amber-600 mb-2"></i>
                            <span class="text-sm font-medium text-gray-800">My Cart</span>
                        </a>
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                            <i class="fas fa-box text-2xl text-amber-600 mb-2"></i>
                            <span class="text-sm font-medium text-gray-800">My Orders</span>
                        </a>
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                            <i class="fas fa-heart text-2xl text-amber-600 mb-2"></i>
                            <span class="text-sm font-medium text-gray-800">Favorites</span>
                        </a>
                        <a href="#" class="flex flex-col items-center justify-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors">
                            <i class="fas fa-user-friends text-2xl text-amber-600 mb-2"></i>
                            <span class="text-sm font-medium text-gray-800">My Artisans</span>
                        </a>
                    </div>
                    <div class="mt-6">
                        <a href="#" class="block text-center bg-amber-100 hover:bg-amber-200 text-amber-800 font-bold py-2 px-4 rounded transition-colors">
                            Browse All Products
                        </a>
                    </div>
                </div>
                
                <!-- Recent Activity -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h3 class="font-bold text-lg text-amber-800 mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                                <i class="fas fa-sign-in-alt text-amber-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-800">You logged in to your account</p>
                                <p class="text-xs text-gray-500"><?php echo $user['last_login'] ? date('M d, Y H:i', strtotime($user['last_login'])) : 'N/A'; ?></p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                                <i class="fas fa-user text-amber-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-800">You created your account</p>
                                <p class="text-xs text-gray-500"><?php echo date('M d, Y', strtotime($user['created_at'])); ?></p>
                            </div>
                        </div>
                        <!-- Placeholder for more activity items -->
                        <div class="flex items-start opacity-50">
                            <div class="h-8 w-8 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-bag text-amber-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-800">You placed an order</p>
                                <p class="text-xs text-gray-500">No recent orders</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Orders -->
            <div class="mt-8">
                <h3 class="font-bold text-xl text-amber-800 mb-4">Recent Orders</h3>
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 text-center text-gray-500">
                        <i class="fas fa-shopping-bag text-4xl text-amber-300 mb-3"></i>
                        <p>You haven't placed any orders yet.</p>
                        <a href="#" class="inline-block mt-4 text-amber-600 hover:text-amber-800 font-medium">Start Shopping</a>
                    </div>
                </div>
            </div>
            
            <!-- Recommended Products -->
            <div class="mt-8">
                <h3 class="font-bold text-xl text-amber-800 mb-4">Recommended For You</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=2070" alt="Product" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h4 class="font-bold text-gray-800 mb-1">Handcrafted Item #<?php echo $i; ?></h4>
                            <p class="text-gray-600 text-sm mb-2">By Artisan Name</p>
                            <div class="flex justify-between items-center">
                                <span class="text-amber-600 font-bold">₱1,200.00</span>
                                <button class="bg-amber-100 hover:bg-amber-200 text-amber-800 px-3 py-1 rounded-full text-sm transition-colors">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
