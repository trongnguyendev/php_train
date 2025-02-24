FROM php:8.2-fpm

RUN apt-get update \
    && apt-get -y --no-install-recommends install \
        php8.4-mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini