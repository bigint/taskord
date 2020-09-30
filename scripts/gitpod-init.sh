mysql -u root -e "create database taskord"
cp .env.gitpod .env
sed -i "s|APP_URL=|APP_URL=${GITPOD_WORKSPACE_URL}|g" .env
sed -i "s|APP_URL=https://|APP_URL=https://8000-|g" .env
composer install
npm install
php artisan key:generate
npm run dev
