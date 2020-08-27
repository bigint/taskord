# Installing Taskord

## Installing prerequisites

These prerequisites assume you're working on a Linux-based operating system.

### PHP

```sh
sudo add-apt-repository ppa:ondrej/php -y
sudo apt install php7.4 php7.4-curl php7.4-common php7.4-cli php7.4-mysql php7.4-mbstring php7.4-fpm php7.4-xml php7.4-zip php7.4-memcached -y
```

### Nginx

```sh
sudo apt install nginx -y
sudo systemctl start nginx
sudo systemctl enable nginx
sudo systemctl start php7.4-fpm
sudo systemctl enable php7.4-fpm
```

### Composer

```sh
sudo apt install composer -y
```

### Node.js and NPM

```sh
curl -sL https://deb.nodesource.com/setup_14.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### MySQL

```sh
sudo apt install mysql-server
```

### Memcached

```sh
sudo apt install memcached -y
```
