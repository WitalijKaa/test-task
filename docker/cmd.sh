#!/bin/sh

php /var/www/app/artisan mysql:is-alive
php /var/www/app/artisan migrate --force

php-fpm
