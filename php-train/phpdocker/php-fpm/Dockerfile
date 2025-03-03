FROM php:8.2-fpm

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini