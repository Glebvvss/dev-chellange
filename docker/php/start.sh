#!/bin/bash

/var/www/html/composer.phar install -d /var/www/html/application
php /var/www/html/application/artisan migrate
service supervisor start
/usr/local/sbin/php-fpm