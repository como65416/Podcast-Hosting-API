FROM php:7.4.11-fpm-alpine
RUN apk add git zip unzip libzip-dev composer
RUN docker-php-ext-install zip
EXPOSE 9000
