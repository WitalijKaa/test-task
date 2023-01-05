#!/bin/sh

rm /var/www/storage/logs/laravel.log
cd /var/www

php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache

chmod 774 $(find /var/www/storage/ -type d)
chmod 664 $(find /var/www/storage/ -type f)
rm /var/www/storage/logs/laravel.log

/usr/bin/supervisord -c /etc/supervisord.conf

