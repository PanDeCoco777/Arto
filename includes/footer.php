    <footer class="bg-amber-800 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">ArtiSell</h3>
                    <p class="text-amber-200">Connecting you to authentic Cebuano arts, crafts, and traditional foods.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/artisell/index.php" class="text-amber-200 hover:text-white transition-colors">Home</a></li>
                        <li><a href="#" class="text-amber-200 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="text-amber-200 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="text-amber-200 hover:text-white transition-colors">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Categories</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-amber-200 hover:text-white transition-colors">Arts</a></li>
                        <li><a href="#" class="text-amber-200 hover:text-white transition-colors">Crafts</a></li>
                        <li><a href="#" class="text-amber-200 hover:text-white transition-colors">Foods</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect With Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-amber-200 hover:text-white transition-colors"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-amber-200 hover:text-white transition-colors"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-amber-200 hover:text-white transition-colors"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-amber-200 hover:text-white transition-colors"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-amber-700 mt-8 pt-6 text-center text-amber-300">
                <p>&copy; <?php echo date('Y'); ?> ArtiSell. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.querySelector('button.md\\:hidden').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>