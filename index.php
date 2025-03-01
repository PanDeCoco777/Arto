<?php
session_start();

// Check if user is logged in and redirect accordingly
if (isset($_SESSION['user_id'])) {
    // If already logged in, redirect to dashboard
    header("Location: dashboard.php");
    exit;
}

// Default tab setting
$defaultTab = isset($_GET['tab']) ? $_GET['tab'] : 'login';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArtiSell - Cebu Artisan Marketplace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="min-h-screen bg-amber-50">
    <div class="relative min-h-screen w-full overflow-hidden bg-amber-50">
        <!-- Decorative elements representing Cebuano cultural patterns -->
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-amber-200 opacity-30 blur-3xl"></div>
        <div class="absolute top-1/4 -left-24 h-96 w-96 rounded-full bg-orange-200 opacity-30 blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 h-96 w-96 rounded-full bg-red-200 opacity-20 blur-3xl"></div>

        <!-- Subtle pattern overlay -->
        <div class="absolute inset-0 bg-cover opacity-5" style="background-image: url('https://images.unsplash.com/photo-1601662528567-526cd06f6582?q=80&w=2070');"></div>

        <!-- Diagonal decorative lines -->
        <div class="absolute inset-0">
            <div class="absolute left-1/4 top-0 h-full w-px bg-gradient-to-b from-transparent via-amber-700/20 to-transparent"></div>
            <div class="absolute left-2/4 top-0 h-full w-px bg-gradient-to-b from-transparent via-amber-700/20 to-transparent"></div>
            <div class="absolute left-3/4 top-0 h-full w-px bg-gradient-to-b from-transparent via-amber-700/20 to-transparent"></div>

            <div class="absolute top-1/4 left-0 h-px w-full bg-gradient-to-r from-transparent via-amber-700/20 to-transparent"></div>
            <div class="absolute top-2/4 left-0 h-px w-full bg-gradient-to-r from-transparent via-amber-700/20 to-transparent"></div>
            <div class="absolute top-3/4 left-0 h-px w-full bg-gradient-to-r from-transparent via-amber-700/20 to-transparent"></div>
        </div>

        <!-- Traditional pattern elements -->
        <div class="absolute top-10 left-10 h-20 w-20 rounded-full border-2 border-amber-600/20 opacity-30"></div>
        <div class="absolute top-10 right-10 h-20 w-20 rounded-full border-2 border-amber-600/20 opacity-30"></div>
        <div class="absolute bottom-10 left-10 h-20 w-20 rounded-full border-2 border-amber-600/20 opacity-30"></div>
        <div class="absolute bottom-10 right-10 h-20 w-20 rounded-full border-2 border-amber-600/20 opacity-30"></div>

        <!-- Diamond patterns inspired by Cebuano textiles -->
        <div class="absolute top-1/3 left-1/4 h-32 w-32 rotate-45 border-2 border-amber-600/10 opacity-40"></div>
        <div class="absolute bottom-1/3 right-1/4 h-32 w-32 rotate-45 border-2 border-amber-600/10 opacity-40"></div>

        <!-- Content container -->
        <div class="relative z-10 flex min-h-screen items-center justify-center px-4">
            <div class="w-full max-w-4xl mx-auto">
                <div class="flex flex-col items-center">
                    <!-- Header -->
                    <div class="w-full mb-8">
                        <header class="w-full bg-gradient-to-r from-amber-500 to-amber-600 p-4 shadow-md">
                            <div class="container mx-auto flex items-center justify-center md:justify-start">
                                <div class="flex items-center">
                                    <div class="bg-white p-2 rounded-full mr-3">
                                        <i class="fas fa-palette h-8 w-8 text-amber-600"></i>
                                    </div>
                                    <div>
                                        <h1 class="text-2xl font-bold text-white">ArtiSell</h1>
                                        <p class="text-sm text-amber-100">Cebu Artisan Marketplace</p>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </div>

                    <div class="w-full max-w-md">
                        <div class="text-center mb-8">
                            <h1 class="text-3xl font-bold text-amber-800">Welcome to ArtiSell</h1>
                            <p class="text-amber-700 mt-2">Discover and shop authentic Cebuano arts, crafts, and traditional foods</p>
                        </div>

                        <!-- Auth Form -->
                        <div class="w-full max-w-md mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
                            <div class="p-6">
                                <!-- Tabs -->
                                <div class="w-full">
                                    <div class="grid w-full grid-cols-2 mb-6 bg-amber-50">
                                        <a href="?tab=login" class="py-3 text-center <?php echo $defaultTab === 'login' ? 'bg-amber-600 text-white' : ''; ?>">Login</a>
                                        <a href="?tab=signup" class="py-3 text-center <?php echo $defaultTab === 'signup' ? 'bg-amber-600 text-white' : ''; ?>">Sign Up</a>
                                    </div>

                                    <!-- Login Form -->
                                    <?php if ($defaultTab === 'login'): ?>
                                    <div class="space-y-4">
                                        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
                                            <form action="auth/login.php" method="post" class="space-y-4">
                                                <div class="space-y-2">
                                                    <label for="email" class="block">Email</label>
                                                    <div class="relative">
                                                        <i class="fas fa-envelope absolute left-3 top-2.5 h-4 w-4 text-gray-400"></i>
                                                        <input 
                                                            id="email" 
                                                            name="email" 
                                                            type="email" 
                                                            placeholder="Enter your email" 
                                                            class="w-full pl-10 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-500" 
                                                            required
                                                        >
                                                    </div>
                                                </div>

                                                <div class="space-y-2">
                                                    <div class="flex justify-between items-center">
                                                        <label for="password" class="block">Password</label>
                                                        <a href="forgot-password.php" class="text-xs text-amber-600 hover:underline">Forgot password?</a>
                                                    </div>
                                                    <div class="relative">
                                                        <i class="fas fa-lock absolute left-3 top-2.5 h-4 w-4 text-gray-400"></i>
                                                        <input 
                                                            id="password" 
                                                            name="password" 
                                                            type="password" 
                                                            placeholder="Enter your password" 
                                                            class="w-full pl-10 p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-amber-500" 
                                                            required
                                                        >
                                                        <button 
                                                            type="button" 
                                                            onclick="togglePassword('password')" 
                                                            class="absolute right-3 top-2.5 text-gray-400"
                                                        >
                                                            <i class="fas fa-eye h-4 w-4" id="password-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="flex items-center space-x-2">
                                                    <input 
                                                        type="checkbox" 
                                                        id="remember" 
                                                        name="remember" 
                                                        class="rounded border-gray-300 text-amber-600 focus:ring-amber-500"
                                                    >
                                                    <label for="remember" class="text-sm font-normal cursor-pointer">Remember me</label>
                                                </div>

                                                <button 
                                                    type="submit" 
                                                    class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded"
                                                >
                                                    Login
                                                </button>
                                            </form>
                                        </div>
                                        
                                        <!-- Social Auth -->
                                        <div class="w-full space-y-4 bg-white p-4 rounded-md">
                                            <div class="relative flex items-center py-2">
                                                <div class="flex-grow border-t border-gray-300"></div>
                                                <span class="mx-2 text-sm text-gray-500 font-medium">OR</span>
                                                <div class="flex-grow border-t border-gray-300"></div>
                                            </div>

                                            <div class="flex flex-col space-y-2">
                                                <a href="auth/social-login.php?provider=google" class="w-full border border-gray-300 hover:bg-gray-50 py-2 px-4 rounded flex items-center justify-center">
                                                    <i class="fas fa-envelope mr-2 h-4 w-4"></i>
                                                    Continue with Google
                                                </a>

                                                <a href="auth/social-login.php?provider=facebook" class="w-full border border-gray-300 hover:bg-blue-50 py-2 px-4 rounded flex items-center justify-center">
                                                    <i class="fab fa-facebook mr-2 h-4 w-4 text-blue-600"></i>
                                                    Continue with Facebook
                                                </a>

                                                <a href="auth/social-login.php?provider=github" class="w-full border border-gray-300 hover:bg-gray-50 py-2 px-4 rounded flex items-center justify-center">
                                                    <i class="fab fa-github mr-2 h-4 w-4"></i>
                                                    Continue with GitHub
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <!-- Signup Form -->
                                    <?php if ($defaultTab === 'signup'): ?>
                                    <div class="space-y-4">
                                        <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
                                            <h2 class="text-2xl font-bold text-center mb-6 text-amber-700">Create an Account</h2>

                                            <form action="auth/signup.php" method="post" class="space-y-4" id="signup-form">
                                                <div>
                                                    <label for="name" class="block text-amber-900">Full Name</label>
                                                    <input 
                                                        id="name" 
                                                        name="name" 
                                                        type="text" 
                                                        placeholder="Enter your full name" 
                                                        class="w-full p-2 border border-amber-200 rounded focus:outline-none focus:ring-2 focus:ring-amber-500" 
                                                        required
                                                    >
                                                    <p class="text-red-500 text-xs mt-1 hidden" id="name-error">Name must be at least 2 characters</p>
                                                </div>

                                                <div>
                                                    <label for="signup-email" class="block text-amber-900">Email</label>
                                                    <input 
                                                        id="signup-email" 
                                                        name="email" 
                                                        type="email" 
                                                        placeholder="Enter your email address" 
                                                        class="w-full p-2 border border-amber-200 rounded focus:outline-none focus:ring-2 focus:ring-amber-500" 
                                                        required
                                                    >
                                                    <p class="text-red-500 text-xs mt-1 hidden" id="email-error">Please enter a valid email address</p>
                                                </div>

                                                <div>
                                                    <label for="signup-password" class="block text-amber-900">Password</label>
                                                    <div class="relative">
                                                        <input 
                                                            id="signup-password" 
                                                            name="password" 
                                                            type="password" 
                                                            placeholder="Create a password" 
                                                            class="w-full p-2 pr-10 border border-amber-200 rounded focus:outline-none focus:ring-2 focus:ring-amber-500" 
                                                            required
                                                        >
                                                        <button 
                                                            type="button" 
                                                            onclick="togglePassword('signup-password')" 
                                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-amber-700"
                                                        >
                                                            <i class="fas fa-eye h-4 w-4" id="signup-password-icon"></i>
                                                        </button>
                                                    </div>
                                                    <p class="text-red-500 text-xs mt-1 hidden" id="password-error">Password must be at least 8 characters</p>
                                                </div>

                                                <div>
                                                    <label for="confirm-password" class="block text-amber-900">Confirm Password</label>
                                                    <div class="relative">
                                                        <input 
                                                            id="confirm-password" 
                                                            name="confirm_password" 
                                                            type="password" 
                                                            placeholder="Confirm your password" 
                                                            class="w-full p-2 pr-10 border border-amber-200 rounded focus:outline-none focus:ring-2 focus:ring-amber-500" 
                                                            required
                                                        >
                                                        <button 
                                                            type="button" 
                                                            onclick="togglePassword('confirm-password')" 
                                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-amber-700"
                                                        >
                                                            <i class="fas fa-eye h-4 w-4" id="confirm-password-icon"></i>
                                                        </button>
                                                    </div>
                                                    <p class="text-red-500 text-xs mt-1 hidden" id="confirm-password-error">Passwords do not match</p>
                                                </div>

                                                <div class="pt-2">
                                                    <button 
                                                        type="submit" 
                                                        class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded"
                                                    >
                                                        Sign Up
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <!-- Social Auth -->
                                        <div class="w-full space-y-4 bg-white p-4 rounded-md">
                                            <div class="relative flex items-center py-2">
                                                <div class="flex-grow border-t border-gray-300"></div>
                                                <span class="mx-2 text-sm text-gray-500 font-medium">OR</span>
                                                <div class="flex-grow border-t border-gray-300"></div>
                                            </div>

                                            <div class="flex flex-col space-y-2">
                                                <a href="auth/social-login.php?provider=google" class="w-full border border-gray-300 hover:bg-gray-50 py-2 px-4 rounded flex items-center justify-center">
                                                    <i class="fas fa-envelope mr-2 h-4 w-4"></i>
                                                    Continue with Google
                                                </a>

                                                <a href="auth/social-login.php?provider=facebook" class="w-full border border-gray-300 hover:bg-blue-50 py-2 px-4 rounded flex items-center justify-center">
                                                    <i class="fab fa-facebook mr-2 h-4 w-4 text-blue-600"></i>
                                                    Continue with Facebook
                                                </a>

                                                <a href="auth/social-login.php?provider=github" class="w-full border border-gray-300 hover:bg-gray-50 py-2 px-4 rounded flex items-center justify-center">
                                                    <i class="fab fa-github mr-2 h-4 w-4"></i>
                                                    Continue with GitHub
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="mt-6 text-center text-sm text-gray-600">
                                        <?php if ($defaultTab === 'login'): ?>
                                        <p>
                                            Don't have an account? 
                                            <a href="?tab=signup" class="text-amber-600 hover:text-amber-800 font-medium">Sign up</a>
                                        </p>
                                        <?php else: ?>
                                        <p>
                                            Already have an account? 
                                            <a href="?tab=login" class="text-amber-600 hover:text-amber-800 font-medium">Log in</a>
                                        </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 text-center text-sm text-amber-700">
                            <p>By continuing, you agree to ArtiSell's</p>
                            <div class="flex justify-center space-x-2 mt-1">
                                <a href="terms.php" class="text-amber-600 hover:text-amber-800 underline">Terms of Service</a>
                                <span>&</span>
                                <a href="privacy.php" class="text-amber-600 hover:text-amber-800 underline">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const signupForm = document.getElementById('signup-form');
            if (signupForm) {
                signupForm.addEventListener('submit', function(e) {
                    let isValid = true;
                    
                    // Name validation
                    const name = document.getElementById('name').value;
                    if (name.length < 2) {
                        document.getElementById('name-error').classList.remove('hidden');
                        isValid = false;
                    } else {
                        document.getElementById('name-error').classList.add('hidden');
                    }
                    
                    // Email validation
                    const email = document.getElementById('signup-email').value;
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        document.getElementById('email-error').classList.remove('hidden');
                        isValid = false;
                    } else {
                        document.getElementById('email-error').classList.add('hidden');
                    }
                    
                    // Password validation
                    const password = document.getElementById('signup-password').value;
                    if (password.length < 8) {
                        document.getElementById('password-error').classList.remove('hidden');
                        isValid = false;
                    } else {
                        document.getElementById('password-error').classList.add('hidden');
                    }
                    
                    // Confirm password validation
                    const confirmPassword = document.getElementById('confirm-password').value;
                    if (password !== confirmPassword) {
                        document.getElementById('confirm-password-error').classList.remove('hidden');
                        isValid = false;
                    } else {
                        document.getElementById('confirm-password-error').classList.add('hidden');
                    }
                    
                    if (!isValid) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</body>
</html>