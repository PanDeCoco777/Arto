<?php
// Database configuration
$host = 'localhost';
$dbname = 'artisell';
$username = 'root'; // Default XAMPP username
$password_db = ''; // Default XAMPP password (empty)

// Function to check database connection
function checkDatabaseConnection() {
    global $host, $dbname, $username, $password_db;
    
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return true;
    } catch(PDOException $e) {
        return false;
    }
}

// Function to create database tables if they don't exist
function createDatabaseTables() {
    global $host, $dbname, $username, $password_db;
    
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Create users table
        $conn->exec("CREATE TABLE IF NOT EXISTS users (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255),
            role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
            social_id VARCHAR(255),
            social_provider VARCHAR(50),
            remember_token VARCHAR(255),
            token_expires INT(11),
            reset_token VARCHAR(255),
            reset_expires DATETIME,
            created_at DATETIME NOT NULL,
            updated_at DATETIME
        )");
        
        // Create categories table
        $conn->exec("CREATE TABLE IF NOT EXISTS categories (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            description TEXT,
            parent_id INT(11) UNSIGNED,
            created_at DATETIME NOT NULL,
            updated_at DATETIME
        )");
        
        // Create locations table
        $conn->exec("CREATE TABLE IF NOT EXISTS locations (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            description TEXT,
            created_at DATETIME NOT NULL,
            updated_at DATETIME
        )");
        
        // Create artisans table
        $conn->exec("CREATE TABLE IF NOT EXISTS artisans (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) UNSIGNED,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            location_id INT(11) UNSIGNED,
            contact_email VARCHAR(255),
            contact_phone VARCHAR(50),
            profile_image VARCHAR(255),
            created_at DATETIME NOT NULL,
            updated_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
            FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE SET NULL
        )");
        
        // Create products table
        $conn->exec("CREATE TABLE IF NOT EXISTS products (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            artisan_id INT(11) UNSIGNED NOT NULL,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            sale_price DECIMAL(10,2),
            stock INT(11) NOT NULL DEFAULT 0,
            category_id INT(11) UNSIGNED,
            location_id INT(11) UNSIGNED,
            featured BOOLEAN DEFAULT FALSE,
            created_at DATETIME NOT NULL,
            updated_at DATETIME,
            FOREIGN KEY (artisan_id) REFERENCES artisans(id) ON DELETE CASCADE,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
            FOREIGN KEY (location_id) REFERENCES locations(id) ON DELETE SET NULL
        )");
        
        // Create product_images table
        $conn->exec("CREATE TABLE IF NOT EXISTS product_images (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            product_id INT(11) UNSIGNED NOT NULL,
            image_path VARCHAR(255) NOT NULL,
            is_primary BOOLEAN DEFAULT FALSE,
            created_at DATETIME NOT NULL,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        )");
        
        // Create orders table
        $conn->exec("CREATE TABLE IF NOT EXISTS orders (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) UNSIGNED NOT NULL,
            total_amount DECIMAL(10,2) NOT NULL,
            status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending',
            shipping_address TEXT NOT NULL,
            shipping_city VARCHAR(255) NOT NULL,
            shipping_postal_code VARCHAR(20) NOT NULL,
            shipping_phone VARCHAR(50) NOT NULL,
            payment_method VARCHAR(50) NOT NULL,
            payment_status ENUM('pending', 'paid', 'failed', 'refunded') NOT NULL DEFAULT 'pending',
            created_at DATETIME NOT NULL,
            updated_at DATETIME,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )");
        
        // Create order_items table
        $conn->exec("CREATE TABLE IF NOT EXISTS order_items (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            order_id INT(11) UNSIGNED NOT NULL,
            product_id INT(11) UNSIGNED NOT NULL,
            quantity INT(11) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            created_at DATETIME NOT NULL,
            FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
        )");
        
        // Create favorites table
        $conn->exec("CREATE TABLE IF NOT EXISTS favorites (
            id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id INT(11) UNSIGNED NOT NULL,
            product_id INT(11) UNSIGNED,
            artisan_id INT(11) UNSIGNED,
            created_at DATETIME NOT NULL,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
            FOREIGN KEY (artisan_id) REFERENCES artisans(id) ON DELETE CASCADE
        )");
        
        // Insert default admin user if not exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = 'admin@artisell.com' LIMIT 1");
        $stmt->execute();
        
        if ($stmt->rowCount() == 0) {
            $admin_password = password_hash('password', PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, created_at) VALUES ('Admin User', 'admin@artisell.com', :password, 'admin', NOW())");
            $stmt->bindParam(':password', $admin_password);
            $stmt->execute();
        }
        
        // Insert default regular user if not exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = 'user@artisell.com' LIMIT 1");
        $stmt->execute();
        
        if ($stmt->rowCount() == 0) {
            $user_password = password_hash('password', PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, created_at) VALUES ('Regular User', 'user@artisell.com', :password, 'user', NOW())");
            $stmt->bindParam(':password', $user_password);
            $stmt->execute();
        }
        
        // Insert default categories
        $categories = [
            ['Arts', 'arts', 'Paintings, sculptures, and other artistic creations'],
            ['Crafts', 'crafts', 'Handmade crafts and decorative items'],
            ['Foods', 'foods', 'Traditional Cebuano foods and delicacies']
        ];
        
        foreach ($categories as $category) {
            $stmt = $conn->prepare("SELECT * FROM categories WHERE slug = :slug LIMIT 1");
            $stmt->bindParam(':slug', $category[1]);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                $stmt = $conn->prepare("INSERT INTO categories (name, slug, description, created_at) VALUES (:name, :slug, :description, NOW())");
                $stmt->bindParam(':name', $category[0]);
                $stmt->bindParam(':slug', $category[1]);
                $stmt->bindParam(':description', $category[2]);
                $stmt->execute();
            }
        }
        
        // Insert default locations
        $locations = [
            ['Minglanilla', 'minglanilla', 'Minglanilla municipality in Cebu'],
            ['Cebu City', 'cebu-city', 'The capital city of Cebu province'],
            ['Mandaue', 'mandaue', 'Mandaue City in Cebu'],
            ['Lapu-Lapu', 'lapu-lapu', 'Lapu-Lapu City in Mactan Island']
        ];
        
        foreach ($locations as $location) {
            $stmt = $conn->prepare("SELECT * FROM locations WHERE slug = :slug LIMIT 1");
            $stmt->bindParam(':slug', $location[1]);
            $stmt->execute();
            
            if ($stmt->rowCount() == 0) {
                $stmt = $conn->prepare("INSERT INTO locations (name, slug, description, created_at) VALUES (:name, :slug, :description, NOW())");
                $stmt->bindParam(':name', $location[0]);
                $stmt->bindParam(':slug', $location[1]);
                $stmt->bindParam(':description', $location[2]);
                $stmt->execute();
            }
        }
        
        return true;
    } catch(PDOException $e) {
        return false;
    }
}
?>