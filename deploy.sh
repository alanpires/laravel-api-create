#!/usr/bin/env bash

echo "Running composer"
composer install --no-dev --optimize-autoloader

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

# Inicie o PHP-FPM e garanta que o contêiner permaneça em execução
exec php-fpm
