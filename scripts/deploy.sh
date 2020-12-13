#!/bin/bash

git pull origin main
composer install
npm install
npm run prod
php artisan app:clean
