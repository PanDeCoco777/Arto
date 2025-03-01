<?php
// Configuration setup file

// Define application constants
define('APP_NAME', 'ArtiSell');
define('APP_DESCRIPTION', 'Cebu Artisan Marketplace');
define('APP_VERSION', '1.0.0');

// Set default timezone
date_default_timezone_set('Asia/Manila');

// Error reporting settings
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Set to 1 in production with HTTPS

// Include database configuration
require_once __DIR__ . '/database.php';

// Helper functions
function redirect($url) {
    header("Location: $url");
    exit;
}

function sanitize_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1;
}

function format_price($price) {
    return '₱' . number_format($price, 2);
}

function get_current_url() {
    return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
}

function get_base_url() {
    $base_dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    $base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$base_dir";
    return $base_url;
}
