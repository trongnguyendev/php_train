FROM php:8.2-fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update && apt-get install -y \
    curl unzip git && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini