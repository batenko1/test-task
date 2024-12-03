FROM php:8.3-fpm-alpine

RUN apk add --no-cache git vim zip

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN install-php-extensions sockets zip gmp pcntl ffi mysqli pdo_mysql opcache exif gd mongodb
RUN apk add --no-cache supervisor
# RUN install-php-extensions xdebug

WORKDIR /var/www
