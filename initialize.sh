#!/usr/bin/env bash

chmod -R 777 bootstrap/cache storage
composer install || composer.phar install
cp .env.example .env
php artisan key:generate
