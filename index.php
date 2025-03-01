<?php
session_start();
include_once 'includes/header.php';
?>

<div class="relative bg-amber-50">
    <!-- Hero section with background image -->
    <div class="relative h-96 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1601662528567-526cd06f6582?q=80&w=2070')">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative container mx-auto px-4 h-full flex items-center">
            <div class="text-white max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Discover Authentic Cebuano Artistry</h1>
                <p class="text-xl mb-6">Shop handcrafted arts, traditional crafts, and delicious local foods from Cebu's finest artisans.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="#featured" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                        Explore Products
                    </a>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <a href="auth/signup.php" class="bg-transparent hover:bg-white hover:text-amber-700 text-white font-bold py-3 px-6 rounded-lg border-2 border-white transition-colors">
                        Join Now
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories section -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center mb-12 text-amber-800">Browse by Category</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-105">
                <img src="https://images.unsplash.com/photo-1579762715118-a6f1d4b934f1?q=80&w=2071" alt="Arts" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-amber-700 mb-2">Arts</h3>
                    <p class="text-gray-600 mb-4">Discover beautiful paintings, sculptures, and visual arts from talented Cebuano artists.</p>
                    <a href="#" class="text-amber-600 hover:text-amber-800 font-medium">Browse Arts &rarr;</a>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-105">
                <img src="https://images.unsplash.com/photo-1606722590583-6951b5ea92ad?q=80&w=2070" alt="Crafts" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-amber-700 mb-2">Crafts</h3>
                    <p class="text-gray-600 mb-4">Explore handmade crafts, textiles, and traditional Cebuano handicrafts.</p>
                    <a href="#" class="text-amber-600 hover:text-amber-800 font-medium">Browse Crafts &rarr;</a>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-transform hover:scale-105">
                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=2070" alt="Foods" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-bold text-amber-700 mb-2">Foods</h3>
                    <p class="text-gray-600 mb-4">Taste authentic Cebuano delicacies, preserves, and traditional food products.</p>
                    <a href="#" class="text-amber-600 hover:text-amber-800 font-medium">Browse Foods &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured products section -->
    <div id="featured" class="bg-amber-100 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-amber-800">Featured Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Sample product cards -->
                <?php for ($i = 1; $i <= 4; $i++): ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=2070" alt="Product" class="w-full h-48 object-cover">
                        <div class="absolute top-2 right-2 bg-amber-500 text-white text-xs font-bold px-2 py-1 rounded">Featured</div>
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Handcrafted Item #<?php echo $i; ?></h3>
                        <p class="text-gray-600 text-sm mb-2">By Artisan Name</p>
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-amber-600 font-bold">₱1,200.00</span>
                            <span class="text-xs text-gray-500">Minglanilla, Cebu</span>
                        </div>
                        <button class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-4 rounded transition-colors">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
            <div class="text-center mt-10">
                <a href="#" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                    View All Products
                </a>
            </div>
        </div>
    </div>

    <!-- Testimonials section -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-center mb-12 text-amber-800">What Our Customers Say</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php for ($i = 1; $i <= 3; $i++): ?>
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-amber-200 flex items-center justify-center mr-4">
                        <span class="text-amber-700 font-bold">JD</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">John Doe</h3>
                        <div class="flex text-amber-500">
                            <?php for ($j = 0; $j < 5; $j++): ?>
                            <i class="fas fa-star text-sm"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600">"The craftsmanship is exceptional! I purchased a handwoven basket and it's absolutely beautiful. The attention to detail shows the artisan's dedication to their craft."</p>
            </div>
            <?php endfor; ?>
        </div>
    </div>

    <!-- Call to action -->
    <div class="bg-amber-600 py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Ready to Discover Cebuano Artistry?</h2>
            <p class="text-xl text-amber-100 mb-8 max-w-2xl mx-auto">Join our community of artisans and customers celebrating the rich cultural heritage of Cebu.</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="auth/signup.php" class="bg-white hover:bg-amber-100 text-amber-700 font-bold py-3 px-6 rounded-lg transition-colors">
                    Create an Account
                </a>
                <a href="auth/login.php" class="bg-transparent hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg border-2 border-white transition-colors">
                    Log In
                </a>
            </div>
            <?php else: ?>
            <a href="dashboard.php" class="bg-white hover:bg-amber-100 text-amber-700 font-bold py-3 px-6 rounded-lg transition-colors">
                Go to Dashboard
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'; ?>
