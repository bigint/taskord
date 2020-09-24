#!/bin/bash

git pull origin main
composer install
npm install
npm run prod
php artisan config:cache
php artisan config:clear
php artisan cache:clear
