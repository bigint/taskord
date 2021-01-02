# Installing Taskord on Production

## Installing prerequisites

These prerequisites assume you're working on a Linux-based operating system.

### PHP

```sh
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update -y
sudo apt install php8.0 php8.0-curl php8.0-common php8.0-cli php8.0-mysql php8.0-mbstring php8.0-fpm php8.0-xml php8.0-zip php8.0-memcached php8.0-redis php8.0-gd php8.0-bcmath php8.0-sqlite -y
```

### Nginx

```sh
sudo apt install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx
sudo systemctl start php8.0-fpm
sudo systemctl enable php8.0-fpm
```

### Composer

```sh
sudo apt install composer -y
```

### Node.js and Yarn

```sh
curl -sL https://deb.nodesource.com/setup_14.x | sudo -E bash -
sudo apt-get install -y nodejs
npm install -g yarn
```

### MySQL

```sh
sudo apt install mysql-server
```

### Memcached

```sh
sudo apt install memcached -y
```

### Supervisor

```sh
sudo apt-get install supervisor
```

## Installing Taskord

### Fork the Repo

Fork Taskord's repository, https://gitlab.com/taskord/taskord/-/forks/new

### Clone the Repo

```sh
mkdir -p /var/www/
cd /var/www/
git clone https://gitlab.com/<your-username>/taskord.git
```

### Composer Install

```sh
cd /var/www/taskord
composer install
```


### Generate App Key

```sh
cp .env.example .env
php artisan key:generate
```

## Yarn Install

```sh
yarn install
yarn production
```

### Setup MySQL

```sh
sudo mysql
create database taskord;
CREATE USER 'taskord'@'localhost' IDENTIFIED BY 'taskord';
GRANT ALL PRIVILEGES ON *.* TO 'taskord'@'localhost';
FLUSH PRIVILEGES;
exit
```

### Update Permission

```sh
sudo chown -R www-data:root /var/www/taskord
sudo chmod 755 /var/www/taskord/storage
```

### Run some Artisans

```sh
php artisan config:cache
php artisan config:clear
php artisan cache:clear
```

### Database Migration

```sh
php artisan migrate
php artisan db:seed --class=ProdAdminSeeder
```

### Setup Nginx

```sh
cd /etc/nginx/
sudo vim sites-available/taskord
```

Copy and paste the conf file

```
server {
    listen 80;
    listen [::]:80 ipv6only=on;

    # Log files for Debugging
    access_log /var/log/nginx/laravel-access.log;
    error_log /var/log/nginx/laravel-error.log;

    # Webroot Directory for Taskord project
    root /var/www/taskord/public;
    index index.php index.html index.htm;

    # Your Domain Name
    server_name localhost;

    large_client_header_buffers 4 32k;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM Configuration Nginx
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

Verify and test the conf

```sh
sudo ln -s /etc/nginx/sites-available/taskord /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### Supervisor

```sh
sudo vim /etc/supervisor/conf.d/taskord-worker.conf
```

Copy and paste the conf file

```
[program:taskord-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/taskord/artisan horizon
autostart=true
autorestart=true
redirect_stderr=true
user=ubuntu
stdout_logfile=/var/www/taskord/storage/logs/horizon.log
stopwaitsecs=3600
```
Refresh conf

```sh
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all
```

Visit https://localhost
