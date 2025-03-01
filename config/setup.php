<?php
// This script sets up the database and tables for the ArtiSell application

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

try {
    // Connect to MySQL server without selecting a database
    $pdo = new PDO("mysql:host=$host;charset=$charset", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    
    // Create database if it doesn't exist
    $db_name = 'artisell';
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$db_name`");
    
    echo "<p>Database created successfully.</p>";
    
    // Create users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(255) NOT NULL,
        `email` VARCHAR(255) NOT NULL UNIQUE,
        `password` VARCHAR(255),
        `social_id` VARCHAR(255),
        `social_provider` VARCHAR(50),
        `is_admin` BOOLEAN DEFAULT 0,
        `status` ENUM('active', 'inactive', 'suspended') DEFAULT 'active',
        `created_at` DATETIME NOT NULL,
        `updated_at` DATETIME,
        `last_login` DATETIME
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Users table created successfully.</p>";
    
    // Create user_profiles table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `user_profiles` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `phone` VARCHAR(20),
        `address` TEXT,
        `city` VARCHAR(100),
        `region` VARCHAR(100),
        `postal_code` VARCHAR(20),
        `bio` TEXT,
        `profile_image` VARCHAR(255),
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>User profiles table created successfully.</p>";
    
    // Create remember_tokens table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `remember_tokens` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `token` VARCHAR(255) NOT NULL,
        `expires` DATETIME NOT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Remember tokens table created successfully.</p>";
    
    // Create password_resets table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `password_resets` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `email` VARCHAR(255) NOT NULL,
        `token` VARCHAR(255) NOT NULL,
        `expires` DATETIME NOT NULL,
        `used` BOOLEAN DEFAULT 0,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Password resets table created successfully.</p>";
    
    // Create product_categories table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `product_categories` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(100) NOT NULL,
        `slug` VARCHAR(100) NOT NULL UNIQUE,
        `description` TEXT,
        `parent_id` INT UNSIGNED,
        `image` VARCHAR(255),
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`parent_id`) REFERENCES `product_categories`(`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Product categories table created successfully.</p>";
    
    // Create products table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `products` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `category_id` INT UNSIGNED,
        `name` VARCHAR(255) NOT NULL,
        `slug` VARCHAR(255) NOT NULL UNIQUE,
        `description` TEXT,
        `price` DECIMAL(10,2) NOT NULL,
        `sale_price` DECIMAL(10,2),
        `stock` INT UNSIGNED DEFAULT 0,
        `location` VARCHAR(100),
        `is_featured` BOOLEAN DEFAULT 0,
        `status` ENUM('active', 'inactive', 'sold_out') DEFAULT 'active',
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`category_id`) REFERENCES `product_categories`(`id`) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Products table created successfully.</p>";
    
    // Create product_images table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `product_images` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `product_id` INT UNSIGNED NOT NULL,
        `image_path` VARCHAR(255) NOT NULL,
        `is_primary` BOOLEAN DEFAULT 0,
        `sort_order` INT UNSIGNED DEFAULT 0,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Product images table created successfully.</p>";
    
    // Create carts table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `carts` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED,
        `session_id` VARCHAR(255),
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Carts table created successfully.</p>";
    
    // Create cart_items table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `cart_items` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `cart_id` INT UNSIGNED NOT NULL,
        `product_id` INT UNSIGNED NOT NULL,
        `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`cart_id`) REFERENCES `carts`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Cart items table created successfully.</p>";
    
    // Create orders table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `orders` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `order_number` VARCHAR(50) NOT NULL UNIQUE,
        `status` ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
        `total_amount` DECIMAL(10,2) NOT NULL,
        `shipping_address` TEXT NOT NULL,
        `shipping_city` VARCHAR(100) NOT NULL,
        `shipping_region` VARCHAR(100) NOT NULL,
        `shipping_postal_code` VARCHAR(20) NOT NULL,
        `shipping_phone` VARCHAR(20) NOT NULL,
        `payment_method` VARCHAR(50) NOT NULL,
        `payment_status` ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
        `notes` TEXT,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Orders table created successfully.</p>";
    
    // Create order_items table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `order_items` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `order_id` INT UNSIGNED NOT NULL,
        `product_id` INT UNSIGNED NOT NULL,
        `quantity` INT UNSIGNED NOT NULL,
        `price` DECIMAL(10,2) NOT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Order items table created successfully.</p>";
    
    // Create favorites table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `favorites` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `product_id` INT UNSIGNED NOT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY `user_product` (`user_id`, `product_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Favorites table created successfully.</p>";
    
    // Create favorite_artisans table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `favorite_artisans` (
        `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `user_id` INT UNSIGNED NOT NULL,
        `artisan_id` INT UNSIGNED NOT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY `user_artisan` (`user_id`, `artisan_id`),
        FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
        FOREIGN KEY (`artisan_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    
    echo "<p>Favorite artisans table created successfully.</p>";
    
    // Insert default categories
    $categories = [
        ['name' => 'Arts', 'slug' => 'arts', 'description' => 'Handcrafted artworks from Cebu'],
        ['name' => 'Crafts', 'slug' => 'crafts', 'description' => 'Traditional Cebuano crafts and handmade items'],
        ['name' => 'Foods', 'slug' => 'foods', 'description' => 'Authentic Cebuano delicacies and food products']
    ];
    
    $stmt = $pdo->prepare("INSERT INTO product_categories (name, slug, description, created_at) VALUES (?, ?, ?, NOW())");
    
    foreach ($categories as $category) {
        try {
            $stmt->execute([$category['name'], $category['slug'], $category['description']]);
        } catch (PDOException $e) {
            // Skip if category already exists
            if ($e->getCode() != 23000) { // 23000 is the SQLSTATE for duplicate entry
                throw $e;
            }
        }
    }
    
    echo "<p>Default categories inserted successfully.</p>";
    
    echo "<p><strong>Database setup completed successfully!</strong></p>";
    echo "<p><a href='../index.php'>Go to homepage</a></p>";
    
} catch (PDOException $e) {
    die("<p>Database setup failed: " . $e->getMessage() . "</p>");
}
