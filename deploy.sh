#!/bin/bash

git pull origin main
composer install
npm install
npm run dev
php artisan config:cache
php artisan config:clear
php artisan cache:clear
