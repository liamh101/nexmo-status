#!/bin/bash

./docker/php/wait-for-it.sh mysql:3306

php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate --no-interaction

php-fpm