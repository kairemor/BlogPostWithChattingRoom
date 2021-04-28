#!/usr/bin/env sh
set -e
service nginx start
php-fpm
#php-fpm -D
#nginx -g 'daemon off;'

