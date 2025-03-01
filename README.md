# ArtiSell - Cebu Artisan Marketplace

## Database Setup Instructions

1. Open your web browser and navigate to http://localhost/phpmyadmin/
2. Log in with your MySQL credentials (default: username 'root' with no password)
3. Create a new database named 'artisell' or import the provided SQL file:
   - Click on 'Import' in the top menu
   - Click 'Choose File' and select the 'artisell.sql' file from this project
   - Click 'Go' at the bottom of the page
4. The database and all required tables will be created automatically

## Application Setup

1. Place all project files in your web server's document root (e.g., htdocs for XAMPP)
2. Navigate to http://localhost/artisell/ in your web browser
3. If this is your first time running the application, visit http://localhost/artisell/setup.php to initialize the database
4. You can now use the application

## Default Login Credentials

- Admin User: admin@artisell.com / password
- Regular User: user@artisell.com / password

## Features

- User authentication (login, signup, password reset)
- Social media authentication
- Product browsing with category and location filters
- Shopping cart and checkout system
- Order tracking
- User profile management
- Favorite products and artisans
