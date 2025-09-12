#!/bin/bash

# Exit immediately if a command exits with a non-zero status.
set -e

echo "--- Building and starting Docker containers ---"
docker-compose up --build -d

echo "--- Installing Composer dependencies ---"
docker-compose exec -T app composer install --no-interaction --prefer-dist

echo "--- Running database migrations and seeders ---"
docker-compose exec -T app php artisan migrate:fresh --seed

echo "--- Running Laravel tests ---"
docker-compose exec -T app php artisan test

echo "--- Tearing down Docker containers ---"
docker-compose down

echo "CI pipeline completed successfully!"
