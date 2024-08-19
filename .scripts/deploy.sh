#!/bin/bash
set -e

echo "Deployment started..."

# Enter maintenance mode or return true
# If already is in maintanance mode
(php artisan down) || true

# Pull the latest version of the app
git pull origin main

# Install composer dependancies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache
php artisan clear-compiled

# Recreate cache
php artisan optimize

# Compile npm assets
npm run build

# Run databse migrations
php artisan migrate --force

# Exit maintenance mode
php artisan up

echo "Deployment finished!"