FROM php:7.4.11-fpm-alpine
RUN apk add zip unzip libzip-dev libxml2-dev curl-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql xml curl zip
EXPOSE 9000
