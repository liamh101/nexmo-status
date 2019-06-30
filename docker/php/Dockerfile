FROM php:7.2-fpm
RUN pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo pdo_mysql

COPY ./ /var/www/symfony
WORKDIR /var/www/symfony

ENTRYPOINT ["/var/www/symfony/docker/php/entrypoint.sh"]