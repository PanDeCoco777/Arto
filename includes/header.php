<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtiSell - Cebu Artisan Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/artisell/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-amber-50">
    <header class="bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="bg-white p-2 rounded-full mr-3">
                        <i class="fas fa-palette text-amber-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">ArtiSell</h1>
                        <p class="text-sm text-amber-100">Cebu Artisan Marketplace</p>
                    </div>
                </div>
                <nav class="hidden md:flex space-x-6">
                    <a href="/artisell/index.php" class="hover:text-amber-200 transition-colors">Home</a>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/artisell/dashboard.php" class="hover:text-amber-200 transition-colors">Dashboard</a>
                        <a href="/artisell/auth/logout.php" class="hover:text-amber-200 transition-colors">Logout</a>
                    <?php else: ?>
                        <a href="/artisell/auth/login.php" class="hover:text-amber-200 transition-colors">Login</a>
                        <a href="/artisell/auth/signup.php" class="hover:text-amber-200 transition-colors">Sign Up</a>
                    <?php endif; ?>
                </nav>
                <button class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="mobile-menu hidden md:hidden bg-amber-600 text-white">
        <div class="container mx-auto px-4 py-2">
            <nav class="flex flex-col space-y-2">
                <a href="/artisell/index.php" class="hover:text-amber-200 transition-colors py-2">Home</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/artisell/dashboard.php" class="hover:text-amber-200 transition-colors py-2">Dashboard</a>
                    <a href="/artisell/auth/logout.php" class="hover:text-amber-200 transition-colors py-2">Logout</a>
                <?php else: ?>
                    <a href="/artisell/auth/login.php" class="hover:text-amber-200 transition-colors py-2">Login</a>
                    <a href="/artisell/auth/signup.php" class="hover:text-amber-200 transition-colors py-2">Sign Up</a>
                <?php endif; ?>
            </nav>
        </div>
    </div>
