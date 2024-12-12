FROM php:8.3-fpm-alpine

# Установка необходимых пакетов
RUN apk add --no-cache git vim zip supervisor librdkafka librdkafka-dev

# Установка PHP-расширений
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN install-php-extensions sockets zip gmp pcntl ffi mysqli pdo_mysql opcache exif gd rdkafka

# Создаем папки и устанавливаем права
RUN mkdir -p /var/www/storage/framework/views \
       /var/www/storage/framework/cache \
       /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

WORKDIR /var/www
