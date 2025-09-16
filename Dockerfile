FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl libpq-dev unzip libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader
