#!/bin/sh

# Install Composer dependencies
composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader

# cd /var/www/html/web/app/themes/evergreen

# composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader

# Start PHP-FPM
php-fpm
