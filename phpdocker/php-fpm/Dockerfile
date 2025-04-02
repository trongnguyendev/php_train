FROM php:8.2-fpm

# Cài đặt các extension và công cụ cần thiết
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl unzip git \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy file cấu hình PHP
COPY php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini
