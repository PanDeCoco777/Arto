<?php
// Start session
session_start();

// Include database configuration
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: index.php');
    exit;
}

// Get user information
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$user_role = $_SESSION['user_role'];

// Include header
include_once 'includes/header.php';
?>

<div class="bg-amber-50 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-amber-600 to-amber-700 text-white shadow-md">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="bg-white p-1 rounded-full mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6 text-amber-600">
                            <circle cx="13.5" cy="6.5" r="2.5"/>
                            <path d="M17 4c0 1-1 2-2 2s-2-1-2-2 1-2 2-2 2 1 2 2z"/>
                            <path d="M19 8c0 1-1 2-2 2s-2-1-2-2 1-2 2-2 2 1 2 2z"/>
                            <path d="M9 20c0 1-1 2-2 2s-2-1-2-2 1-2 2-2 2 1 2 2z"/>
                            <path d="M11 16c0 1-1 2-2 2s-2-1-2-2 1-2 2-2 2 1 2 2z"/>
                            <path d="M13 12c0 1-1 2-2 2s-2-1-2-2 1-2 2-2 2 1 2 2z"/>
                            <path d="M7 12c0 1-1 2-2 2s-2-1-2-2 1-2 2-2 2 1 2 2z"/>
                            <path d="M17 12c0 1-1 2-2 2s-2-1-2-2 1-2 2-2 2 1 2 2z"/>
                            <path d="M9 8c0 1-1 2-2 2S5 9 5 8s1-2 2-2 2 1 2 2z"/>
                        </svg>
                    </div>
                    <a href="dashboard.php" class="text-xl font-bold">ArtiSell</a>
                </div>
                
                <div class="hidden md:flex space-x-6">
                    <a href="dashboard.php" class="hover:text-amber-200">Home</a>
                    <a href="#" class="hover:text-amber-200">Products</a>
                    <a href="#" class="hover:text-amber-200">Artisans</a>
                    <a href="#" class="hover:text-amber-200">Orders</a>
                    <?php if ($user_role === 'admin'): ?>
                        <a href="#" class="hover:text-amber-200">Admin</a>
                    <?php endif; ?>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="#" class="hover:text-amber-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                            <path d="M3 6h18"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                    </a>
                    <div class="relative group">
                        <button class="flex items-center hover:text-amber-200">
                            <span class="mr-1"><?php echo htmlspecialchars($user_name); ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden group-hover:block">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-100">My Orders</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-100">Favorites</a>
                            <div class="border-t border-gray-200"></div>
                            <a href="auth/logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-100">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <div class="bg-gradient-to-b from-amber-100 to-amber-50 py-12">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h1 class="text-4xl font-bold text-amber-800 mb-4">Welcome to ArtiSell, <?php echo htmlspecialchars($user_name); ?>!</h1>
                    <p class="text-lg text-amber-700 mb-6">Discover authentic Cebuano arts, crafts, and traditional foods from local artisans.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-md font-medium">Browse Products</a>
                        <a href="#" class="border border-amber-600 text-amber-600 hover:bg-amber-50 px-6 py-3 rounded-md font-medium">Meet Artisans</a>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <img src="https://images.unsplash.com/photo-1604848698030-c434ba08ece1?q=80&w=1974&auto=format&fit=crop" alt="Cebu Artisan Crafts" class="rounded-lg shadow-xl w-full">
                </div>
            </div>
        </div>
    </div>
    
    <!-- Featured Categories -->
    <div class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-amber-800 mb-8 text-center">Explore Categories</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-amber-50 rounded-lg overflow-hidden shadow-md transition-transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?q=80&w=2145&auto=format&fit=crop" alt="Arts" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-amber-700 mb-2">Arts</h3>
                        <p class="text-amber-600 mb-4">Discover beautiful paintings, sculptures, and artistic creations from Cebuano artists.</p>
                        <a href="#" class="text-amber-600 font-medium hover:text-amber-800 flex items-center">
                            Explore Arts
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2">
                                <path d="M5 12h14"/>
                                <path d="m12 5 7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="bg-amber-50 rounded-lg overflow-hidden shadow-md transition-transform hover:scale-105">
                    <img src="https://images.unsplash.com/photo-1606722590583-6951b5ea92ad?q=80&w=2070&auto=format&fit=crop" alt="Crafts" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-amber-700 mb-2">Crafts</h3>
                        <p class="text-amber-600 mb-4">Explore handmade crafts, woven products, and decorative items made by local artisans.</p>
                        <a href="#" class="text-amber-600 font-medium hover:text-amber-800 flex items-center">
                            Explore Crafts
                            <svg xmlns="http://www.w3.org/2000/svg