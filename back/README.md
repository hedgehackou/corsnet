## Установка

1. Устанавливаем nginx
   `sudo apt update && sudo apt install nginx`
Разрешаем трафик к 80 порту
    `sudo ufw allow 'Nginx HTTP'`
2. Устанавливаем mysql
    `sudo apt install mysql-server`
Устанавливаем защиту
    `sudo mysql_secure_installation` - в процессе установки выбираем medium password и вводим рутовый парль (остальные пункты опционально)
3. Меняем метод авторизации в mysql
    `sudo mysql` затем в консоли mysql пишем `ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';`, где password меняем на необходимый пароль
Затем пишем `FLUSH PRIVILEGES;` Дальше для входа в консоль mysql мы используем команду `mysql -u root -p` и затем вводим требуем пароль.
4. Дальше устанавливаем php. Добавляем apt репозиторий `sudo add-apt-repository universe`
5. `sudo apt-get install php7.4-cli php7.4-curl php7.4-mysql php7.4-fpm php7.4-gd php7.4-xml php7.4-mbstring php7.4-zip php7.4-soap php7.4-dev -y` - устанавливаем php-fpm и доп модули
6. Конфигурируем nginx `sudo nano /etc/nginx/sites-available/corsnet`
```
server {
    listen 80;
    index index.php index.html;
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    server_name demo.corsnet.xyz;
    root /var/www/corstnet/back/public;
    client_max_body_size 2048m;        

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }
}
```
7. `sudo ln -s /etc/nginx/sites-available/corsnet /etc/nginx/sites-enabled/` - делаем символическую ссылку
8. `sudo systemctl reload nginx` - перезапускаем nginx
9. `mkdir /var/www/corsnet`, `cd /var/www/corsnet`, `git clone git@github.com:hedgehackou/corsnet.git ./` - клонируем репозиторий
