#!/bin/bash

git pull origin main
composer install
yarn install
yarn prod
php artisan app:clean
