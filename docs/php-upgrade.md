# Upgrading PHP on Production

### Uninstall old PHP

```sh
sudo apt purge php7.4*
```

### Update config
```sh
sudo update-alternatives --config php
```

### Update Nginx Config

```sh
cd /etc/nginx/
sudo vim sites-available/taskord
```

Update this line

```
fastcgi_pass unix:/run/php/php8.0-fpm.sock;
```

Verify and test the conf

```sh
sudo ln -s /etc/nginx/sites-available/taskord /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### Refresh confs

```sh
sudo systemctl restart nginx
sudo systemctl restart php8.0-fpm
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all
```
