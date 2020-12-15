#!/bin/bash

mysql -u root -e "CREATE DATABASE taskord"
cp .env.gitpod .env
sed -i "s|APP_URL=|APP_URL=${GITPOD_WORKSPACE_URL}|g" .env
sed -i "s|APP_URL=https://|APP_URL=https://8000-|g" .env
composer install
yarn install
php artisan key:generate
php artisan horizon:install
php artisan horizon:publish
php artisan migrate --seed --force
yarn development
