<?php
// Start session for user authentication
session_start();

// Include database configuration
require_once 'config/database.php';

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to dashboard if already logged in
    header('Location: dashboard.php');
    exit;
}

// Include header
include_once 'includes/header.php';
?>

<div class="min-h-screen bg-amber-50">
    <div class="relative min-h-screen w-full overflow-hidden">
        <!-- Decorative elements representing Cebuano cultural patterns -->
        <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-amber-200 opacity-30 blur-3xl"></div>
        <div class="absolute top-1/4 -left-24 h-96 w-96 rounded-full bg-orange-200 opacity-30 blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 h-96 w-96 rounded-full bg-red-200 opacity-20 blur-3xl"></div>

        <!-- Subtle pattern overlay -->
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1601662528567-526cd06f6582?q=80&w=2070')] bg-cover opacity-5"></div>

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
                    <div class="w-full mb-8">
                        <!-- Header -->
                        <header class="w-full bg-gradient-to-r from-amber-500 to-amber-600 p-4 shadow-md">
                            <div class="container mx-auto flex items-center justify-center md:justify-start">
                                <div class="flex items-center">
                                    <div class="bg-white p-2 rounded-full mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-8 w-8 text-amber-600">
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
                                <div class="w-full" id="auth-tabs">
                                    <div class="grid w-full grid-cols-2 mb-6 bg-amber-50">
                                        <button id="login-tab" class="py-3 active-tab" onclick="switchTab('login')">Login</button>
                                        <button id="signup-tab" class="py-3" onclick="switchTab('signup')">Sign Up</button>
                                    </div>

                                    <!-- Login Form -->
                                    <div id="login-content" class="space-y-4">
                                        <form id="login-form" action="auth/login.php" method="post" class="space-y-4">
                                            <div class="space-y-2">
                                                <label for="email" class="block text-sm font-medium">Email</label>
                                                <div class="relative">
                                                    <span class="absolute left-3 top-2.5 text-muted-foreground">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                                        </svg>
                                                    </span>
                                                    <input id="email" name="email" type="email" placeholder="Enter your email" class="pl-10 w-full rounded-md border border-input px-3 py-2" required>
                                                </div>
                                            </div>

                                            <div class="space-y-2">
                                                <div class="flex justify-between items-center">
                                                    <label for="password" class="block text-sm font-medium">Password</label>
                                                    <a href="auth/forgot-password.php" class="text-xs text-amber-600 hover:underline">Forgot password?</a>
                                                </div>
                                                <div class="relative">
                                                    <span class="absolute left-3 top-2.5 text-muted-foreground">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                                        </svg>
                                                    </span>
                                                    <input id="password" name="password" type="password" placeholder="Enter your password" class="pl-10 w-full rounded-md border border-input px-3 py-2" required>
                                                    <button type="button" onclick="togglePasswordVisibility('password')" class="absolute right-3 top-2.5 text-muted-foreground">
                                                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                                            <circle cx="12" cy="12" r="3"/>
                                                        </svg>
                                                        <svg id="eye-off-icon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                                                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                                                            <line x1="2" x2="22" y1="2" y2="22"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox" id="remember" name="remember" class="rounded border-gray-300">
                                                <label for="remember" class="text-sm font-normal cursor-pointer">Remember me</label>
                                            </div>

                                            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded-md">Login</button>
                                        </form>

                                        <!-- Social Auth -->
                                        <div class="w-full space-y-4 bg-white p-4 rounded-md">
                                            <div class="relative flex items-center py-2">
                                                <div class="flex-grow border-t border-gray-300"></div>
                                                <span class="mx-2 text-sm text-gray-500 font-medium">OR</span>
                                                <div class="flex-grow border-t border-gray-300"></div>
                                            </div>

                                            <div class="flex flex-col space-y-2">
                                                <a href="auth/social-login.php?provider=google" class="w-full border border-gray-300 hover:bg-gray-50 py-2 px-4 rounded-md flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                                                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                                    </svg>
                                                    Continue with Google
                                                </a>

                                                <a href="auth/social-login.php?provider=facebook" class="w-full border border-gray-300 hover:bg-blue-50 py-2 px-4 rounded-md flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4 text-blue-600">
                                                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                                                    </svg>
                                                    Continue with Facebook
                                                </a>

                                                <a href="auth/social-login.php?provider=github" class="w-full border border-gray-300 hover:bg-gray-50 py-2 px-4 rounded-md flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                                                        <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/>
                                                        <path d="M9 18c-4.51 2-5-2-7-2"/>
                                                    </svg>
                                                    Continue with GitHub
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Signup Form -->
                                    <div id="signup-content" class="space-y-4 hidden">
                                        <form id="signup-form" action="auth/signup.php" method="post" class="space-y-4">
                                            <div class="space-y-2">
                                                <label for="name" class="block text-sm font-medium text-amber-900">Full Name</label>
                                                <input id="name" name="name" type="text" placeholder="Enter your full name" class="w-full rounded-md border border-amber-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                                                <div id="name-error" class="text-red-500 text-xs hidden"></div>
                                            </div>

                                            <div class="space-y-2">
                                                <label for="signup-email" class="block text-sm font-medium text-amber-900">Email</label>
                                                <input id="signup-email" name="email" type="email" placeholder="Enter your email address" class="w-full rounded-md border border-amber-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                                                <div id="email-error" class="text-red-500 text-xs hidden"></div>
                                            </div>

                                            <div class="space-y-2">
                                                <label for="signup-password" class="block text-sm font-medium text-amber-900">Password</label>
                                                <div class="relative">
                                                    <input id="signup-password" name="password" type="password" placeholder="Create a password" class="w-full rounded-md border border-amber-200 px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                                                    <button type="button" onclick="togglePasswordVisibility('signup-password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-amber-700">
                                                        <svg id="signup-eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                                            <circle cx="12" cy="12" r="3"/>
                                                        </svg>
                                                        <svg id="signup-eye-off-icon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                                                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                                                            <line x1="2" x2="22" y1="2" y2="22"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div id="password-error" class="text-red-500 text-xs hidden"></div>
                                            </div>

                                            <div class="space-y-2">
                                                <label for="confirm-password" class="block text-sm font-medium text-amber-900">Confirm Password</label>
                                                <div class="relative">
                                                    <input id="confirm-password" name="confirm_password" type="password" placeholder="Confirm your password" class="w-full rounded-md border border-amber-200 px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                                                    <button type="button" onclick="togglePasswordVisibility('confirm-password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-amber-700">
                                                        <svg id="confirm-eye-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
                                                            <circle cx="12" cy="12" r="3"/>
                                                        </svg>
                                                        <svg id="confirm-eye-off-icon" class="hidden" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
                                                            <path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
                                                            <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
                                                            <line x1="2" x2="22" y1="2" y2="22"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div id="confirm-password-error" class="text-red-500 text-xs hidden"></div>
                                            </div>

                                            <div class="pt-2">
                                                <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white py-2 px-4 rounded-md">Sign Up</button>
                                            </div>
                                        </form>

                                        <!-- Social Auth for Signup -->
                                        <div class="w-full space-y-4 bg-white p-4 rounded-md">
                                            <div class="relative flex items-center py-2">
                                                <div class="flex-grow border-t border-gray-300"></div>
                                                <span class="mx-2 text-sm text-gray-500 font-medium">OR</span>
                                                <div class="flex-grow border-t border-gray-300"></div>
                                            </div>

                                            <div class="flex flex-col space-y-2">
                                                <a href="auth/social-login.php?provider=google&action=signup" class="w-full border border-gray-300 hover:bg-gray-50 py-2 px-4 rounded-md flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                                                        <rect width="20" height="16" x="2" y="4" rx="2"/>
                                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                                    </svg>
                                                    Continue with Google
                                                </a>

                                                <a href="auth/social-login.php?provider=facebook&action=signup" class="w-full border border-gray-300 hover:bg-blue-50 py-2 px-4 rounded-md flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4 text-blue-600">
                                                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                                                    </svg>
                                                    Continue with Facebook
                                                </a>

                                                <a href="auth/social-login.php?provider=github&action=signup" class="w-full border border-gray-300 hover:bg-gray-50 py-2 px-4 rounded-md flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                                                        <path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/>
                                                        <path d="M9 18c-4.51 2-5-2-7-2"/>
                                                    </svg>
                                                    Continue with GitHub
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6 text-center text-sm text-gray-600" id="tab-toggle-text">
                                    <p id="login-toggle-text">
                                        Don't have an account?
                                        <button onclick="switchTab('signup')" class="text-amber-600 hover:text-amber-800 font-medium">Sign up</button>
                                    </p>
                                    <p id="signup-toggle-text" class="hidden">
                                        Already have an account?
                                        <button onclick="switchTab('login')" class="text-amber-600 hover:text-amber-800 font-medium">Log in</button>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 text-center text-sm text-amber-700">
                            <p>By continuing, you agree to ArtiSell's</p>
                            <div class="flex justify-center space-x-2 mt-1">
                                <a href="#" class="text-amber-600 hover:text-amber-800 underline">Terms of Service</a>
                                <span>&</span>
                                <a href="#" class="text-amber-600 hover:text-amber-800 underline">Privacy Policy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to switch between login and signup tabs
    function switchTab(tab) {
        // Get tab elements
        const loginTab = document.getElementById('login-tab');
        const signupTab = document.getElementById('signup-tab');
        const loginContent = document.getElementById('login-content');
        const signupContent = document.getElementById('signup-content');
        const loginToggleText = document.getElementById('login-toggle-text');
        const signupToggleText = document.getElementById('signup-toggle-text');
        
        // Update active tab styling
        if (tab === 'login') {
            loginTab.classList.add('active-tab');
            signupTab.classList.remove('active-tab');
            loginContent.classList.remove('hidden');
            signupContent.classList.add('hidden');
            loginToggleText.classList.remove('hidden');
            signupToggleText.classList.add('hidden');
        } else {
            signupTab.classList.add('active-tab');
            loginTab.classList.remove('active-tab');
            signupContent.classList.remove('hidden');
            loginContent.classList.add('hidden');
            signupToggleText.classList.remove('hidden');
            loginToggleText.classList.add('hidden');
        }
    }
    
    // Function to toggle password visibility
    function togglePasswordVisibility(inputId) {
        const passwordInput = document.getElementById(inputId);
        const eyeIcon = document.getElementById(inputId === 'password' ? 'eye-icon' : 
                                              inputId === 'signup-password' ? 'signup-eye-icon' : 'confirm-eye-icon');
        const eyeOffIcon = document.getElementById(inputId === 'password' ? 'eye-off-icon' : 
                                                inputId === 'signup-password' ? 'signup-eye-off-icon' : 'confirm-eye-off-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeOffIcon.classList.add('hidden');
            eyeIcon.classList.remove('hidden');
        }
    }
    
    // Form validation for signup
    document.getElementById('signup-form').addEventListener('submit', function(e) {
        let isValid = true;
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('signup-email');
        const passwordInput = document.getElementById('signup-password');
        const confirmPasswordInput = document.getElementById('confirm-password');
        
        // Reset error messages
        document.getElementById('name-error').classList.add('hidden');
        document.getElementById('email-error').classList.add('hidden');
        document.getElementById('password-error').classList.add('hidden');
        document.getElementById('confirm-password-error').classList.add('hidden');
        
        // Validate name
        if (nameInput.value.length < 2) {
            document.getElementById('name-error').textContent = 'Name must be at least 2 characters';
            document.getElementById('name-error').classList.remove('hidden');
            isValid = false;
        }
        
        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailInput.value)) {
            document.getElementById('email-error').textContent = 'Please enter a valid email address';
            document.getElementById('email-error').classList.remove('hidden');
            isValid = false;
        }
        
        // Validate password
        if (passwordInput.value.length < 8) {
            document.getElementById('password-error').textContent = 'Password must be at least 8 characters';
            document.getElementById('password-error').classList.remove('hidden');
            isValid = false;
        }
        
        // Validate password confirmation
        if (passwordInput.value !== confirmPasswordInput.value) {
            document.getElementById('confirm-password-error').textContent = 'Passwords do not match';
            document.getElementById('confirm-password-error').classList.remove('hidden');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
</script>

<style>
    /* Custom styles for active tab */
    .active-tab {
        background-color: rgb(217, 119, 6);
        color: white;
    }
    
    /* Add transition effects */
    #login-tab, #signup-tab {
        transition: background-color 0.3s, color 0.3s;
    }
    
    /* Form input focus styles */
    input:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(217, 119, 6, 0.3);
    }
</style>

<?php
// Include footer
include_once 'includes/footer.php';
?>