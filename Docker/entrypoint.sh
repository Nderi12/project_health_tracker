#!/bin/bash

if [! -f "vendor/autoload.php" ]; then
    composer install --no-progress --no-interaction
fi

if [! -f ".env" ]; then
    echo "Creating .env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

# Install Node.js dependencies and run the Vite build
if [ ! -d "node_modules" ]; then
    npm install
fi

npm run build

php artisan migrate
php artisan key:generate
# php artisan cache:clear
# php artisan config:clear
# php artisan route:clear

php artisan serve --port=$PORT --host=0.0.0.0 --env=.env
exec docker-php-entrypoint "$@"