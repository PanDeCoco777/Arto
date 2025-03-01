<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Get user information
$user_id = $_SESSION['user_id'];

try {
    // Get user profile
    $stmt = $pdo->prepare("SELECT u.*, up.* FROM users u LEFT JOIN user_profiles up ON u.id = up.user_id WHERE u.id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get recent orders
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
    $stmt->execute([$user_id]);
    $recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get favorite products
    $stmt = $pdo->prepare("SELECT p.* FROM products p JOIN favorites f ON p.id = f.product_id WHERE f.user_id = ? LIMIT 4");
    $stmt->execute([$user_id]);
    $favorite_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get favorite artisans
    $stmt = $pdo->prepare("SELECT u.id, u.name, COUNT(p.id) as product_count FROM users u JOIN favorite_artisans fa ON u.id = fa.artisan_id LEFT JOIN products p ON u.id = p.user_id WHERE fa.user_id = ? GROUP BY u.id LIMIT 4");
    $stmt->execute([$user_id]);
    $favorite_artisans = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
}

// Include header
include_once 'includes/header.php';
?>

<div class="bg-amber-50 min-h-screen">
    <!-- Header/Navigation -->
    <header class="bg-gradient-to-r from-amber-500 to-amber-600 shadow-md">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="bg-white p-2 rounded-full mr-3">
                        <i class="fas fa-palette text-amber-600 text-xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-white">ArtiSell</h1>
                </div>
                
                <nav class="hidden md:flex space-x-6">
                    <a href="dashboard.php" class="text-white hover:text-amber-200">Dashboard</a>
                    <a href="products.php" class="text-white hover:text-amber-200">Products</a>
                    <a href="orders.php" class="text-white hover:text-amber-200">Orders</a>
                    <a href="profile.php" class="text-white hover:text-amber-200">Profile</a>
                </nav>
                
                <div class="flex items-center space-x-4">
                    <a href="cart.php" class="text-white hover:text-amber-200">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <div class="relative group">
                        <button class="flex items-center text-white hover:text-amber-200">
                            <span class="mr-1"><?php echo htmlspecialchars($user['name']); ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                            <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-100">Your Profile</a>
                            <a href="orders.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-100">Your Orders</a>
                            <a href="favorites.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-100">Your Favorites</a>
                            <div class="border-t border-gray-100"></div>
                            <a href="auth/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-100">Sign out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation (Shown on small screens) -->
    <div class="md:hidden bg-amber-600 text-white">
        <div class="container mx-auto px-4 py-2">
            <div class="flex justify-between">
                <a href="dashboard.php" class="py-2 px-3 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-amber-700 rounded' : ''; ?>">Dashboard</a>
                <a href="products.php" class="py-2 px-3 <?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'bg-amber-700 rounded' : ''; ?>">Products</a>
                <a href="orders.php" class="py-2 px-3 <?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'bg-amber-700 rounded' : ''; ?>">Orders</a>
                <a href="profile.php" class="py-2 px-3 <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'bg-amber-700 rounded' : ''; ?>">Profile</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Main Dashboard Content -->
            <div class="md:w-2/3 space-y-6">
                <!-- Welcome Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-amber-800 mb-4">Welcome back, <?php echo htmlspecialchars($user['name']); ?>!</h2>
                    <p class="text-amber-700">Explore authentic Cebuano arts, crafts, and traditional foods from local artisans.</p>
                    
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="products.php" class="bg-amber-50 hover:bg-amber-100 p-4 rounded-lg text-center transition duration-200">
                            <i class="fas fa-store text-3xl text-amber-600 mb-2"></i>
                            <h3 class="font-semibold text-amber-800">Browse Products</h3>
                        </a>
                        <a href="orders.php" class="bg-amber-50 hover:bg-amber-100 p-4 rounded-lg text-center transition duration-200">
                            <i class="fas fa-box text-3xl text-amber-600 mb-2"></i>
                            <h3 class="font-semibold text-amber-800">Track Orders</h3>
                        </a>
                        <a href="favorites.php" class="bg-amber-50 hover:bg-amber-100 p-4 rounded-lg text-center transition duration-200">
                            <i class="fas fa-heart text-3xl text-amber-600 mb-2"></i>
                            <h3 class="font-semibold text-amber-800">Your Favorites</h3>
                        </a>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-amber-800">Recent Orders</h2>
                        <a href="orders.php" class="text-amber-600 hover:text-amber-800 text-sm">View All</a>
                    </div>
                    
                    <?php if (empty($recent_orders)): ?>
                        <p class="text-gray-500 italic">You haven't placed any orders yet.</p>
                    <?php else: ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-amber-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-amber-700 uppercase tracking-wider">Order #</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-amber-700 uppercase tracking-wider">Date</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-amber-700 uppercase tracking-wider">Total</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-amber-700 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-amber-700 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-amber-100">
                                    <?php foreach ($recent_orders as $order): ?>
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap"><?php echo htmlspecialchars($order['order_number']); ?></td>
                                            <td class="px-4 py-3 whitespace-nowrap"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                            <td class="px-4 py-3 whitespace-nowrap">₱<?php echo number_format($order['total_amount'], 2); ?></td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    <?php 
                                                    switch($order['status']) {
                                                        case 'pending': echo 'bg-yellow-100 text-yellow-800'; break;
                                                        case 'processing': echo 'bg-blue-100 text-blue-800'; break;
                                                        case 'shipped': echo 'bg-indigo-100 text-indigo-800'; break;
                                                        case 'delivered': echo 'bg-green-100 text-green-800'; break;
                                                        case 'cancelled': echo 'bg-red-100 text-red-800'; break;
                                                        default: echo 'bg-gray-100 text-gray-800';
                                                    }
                                                    ?>"
                                                >
                                                    <?php echo ucfirst(htmlspecialchars($order['status'])); ?>
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <a href="order-details.php?id=<?php echo $order['id']; ?>" class="text-amber-600 hover:text-amber-800">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Featured Products -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-amber-800">Featured Products</h2>
                        <a href="products.php" class="text-amber-600 hover:text-amber-800 text-sm">View All</a>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- This would be populated with actual featured products from the database -->
                        <div class="bg-amber-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-200">
                            <img src="https://images.unsplash.com/photo-1603105037880-880cd4edfb0d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Product" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-semibold text-amber-800">Handwoven Basket</h3>
                                <p class="text-amber-600 font-bold mt-1">₱450.00</p>
                                <p class="text-sm text-gray-600 mt-1">Minglanilla</p>
                                <a href="product-details.php?id=1" class="mt-2 inline-block text-sm text-amber-600 hover:text-amber-800">View Details</a>
                            </div>
                        </div>
                        
                        <div class="bg-amber-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-200">
                            <img src="https://images.unsplash.com/photo-1528825871115-3581a5387919?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Product" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-semibold text-amber-800">Cebu Dried Mangoes</h3>
                                <p class="text-amber-600 font-bold mt-1">₱180.00</p>
                                <p class="text-sm text-gray-600 mt-1">Cebu City</p>
                                <a href="product-details.php?id=2" class="mt-2 inline-block text-sm text-amber-600 hover:text-amber-800">View Details</a>
                            </div>
                        </div>
                        
                        <div class="bg-amber-50 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition duration-200">
                            <img src="https://images.unsplash.com/photo-1544967082-d9d25d867d66?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Product" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-semibold text-amber-800">Hand-painted Pottery</h3>
                                <p class="text-amber-600 font-bold mt-1">₱650.00</p>
                                <p class="text-sm text-gray-600 mt-1">Carcar</p>
                                <a href="product-details.php?id=3" class="mt-2 inline-block text-sm text-amber-600 hover:text-amber-800">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="md:w-1/3 space-y-6">
                <!-- User Profile Summary -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-amber-100 p-3 rounded-full mr-4">
                            <i class="fas fa-user text-amber-600 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-amber-800"><?php echo htmlspecialchars($user['name']); ?></h3>
                            <p class="text-sm text-gray-600"><?php echo htmlspecialchars($user['email']); ?></p>
                        </div>
                    </div>
                    <div class="border-t border-amber-100 pt-4 mt-4">
                        <a href="profile.php" class="text-amber-600 hover:text-amber-800 text-sm flex items-center">
                            <i class="fas fa-edit mr-2"></i> Edit Profile
                        </a>
                    </div>
                </div>
                
                <!-- Favorite Artisans -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-amber-800">Your Favorite Artisans</h3>
                        <a href="favorite-artisans.php" class="text-amber-600 hover:text-amber-800 text-sm">View All</a>
                    </div>
                    
                    <?php if (empty($favorite_artisans)): ?>
                        <p class="text-gray-500 italic">You haven't added any favorite artisans yet.</p>
                    <?php else: ?>
                        <div class="space-y-3">
                            <?php foreach ($favorite_artisans as $artisan): ?>
                                <div class="flex items-center">
                                    <div class="bg-amber-50 p-2 rounded-full mr-3">
                                        <i class="fas fa-user text-amber-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-amber-800"><?php echo htmlspecialchars($artisan['name']); ?></h4>
                                        <p class="text-xs text-gray-600"><?php echo $artisan['product_count']; ?> products</p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Quick Links -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-semibold text-amber-800 mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="products.php?category=arts" class="text-amber-600 hover:text-amber-800 flex items-center">
                                <i class="fas fa-palette mr-2"></i> Browse Arts
                            </a>
                        </li>
                        <li>
                            <a href="products.php?category=crafts" class="text-amber-600 hover:text-amber-800 flex items-center">
                                <i class="fas fa-hands mr-2"></i> Explore Crafts
                            </a>
                        </li>
                        <li>
                            <a href="products.php?category=foods" class="text-amber-600 hover:text-amber-800 flex items-center">
                                <i class="fas fa-utensils mr-2"></i> Discover Foods
                            </a>
                        </li>
                        <li>
                            <a href="products.php?location=minglanilla" class="text-amber-600 hover:text-amber-800 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i> Minglanilla Products
                            </a>
                        </li>
                        <li>
                            <a href="artisans.php" class="text-amber-600 hover:text-amber-800 flex items-center">
                                <i class="fas fa-users mr-2"></i> Meet the Artisans
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include_once 'includes/footer.php'; ?>
</div>
