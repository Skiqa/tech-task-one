#!/bin/sh

# Set environment variables
export USER_ID=$(id -u)
export GROUP_ID=$(id -g)

# Install Composer dependencies
echo "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# Clear and cache configuration
echo "Clearing and caching config..."
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan view:clear

# Ensure proper permissions for storage and bootstrap/cache directories
echo "Setting permissions for storage and bootstrap/cache directories..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 777 /var/www/storage /var/www/bootstrap/cache

# Check if storage/logs/laravel.log exists and set permissions
if [ ! -f /var/www/storage/logs/laravel.log ]; then
    touch /var/www/storage/logs/laravel.log
    chown www-data:www-data /var/www/storage/logs/laravel.log
    chmod 777 /var/www/storage/logs/laravel.log
fi

# Function to check if a table exists
check_migration_status() {
    php artisan migrate:status > /dev/null 2>&1
    return $?
}

# Check the migration status, and if no migrations have been run, run migrations and seed the database
echo "Checking migration status..."
check_migration_status
if [ $? -eq 0 ]; then
    echo "Migrations table exists. Skipping migration."
else
    echo "Migrations table does not exist or there is an issue. Running migrations."
    php artisan migrate --force
    php artisan db:seed --force
fi

# Generate the application key (only if not already set)
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Start php-fpm
echo "Starting PHP-FPM..."
php-fpm

# Keep the container running by tailing the PHP-FPM log
tail -f /var/log/php*-fpm.log