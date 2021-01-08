FROM php:7.4-fpm

WORKDIR /var/www/symfony

RUN apt-get update && apt-get install -y \
    libpq-dev \
    wget \
    zlib1g-dev \
    libmcrypt-dev \
    libzip-dev

RUN docker-php-ext-install pdo pdo_pgsql pgsql 

CMD php-fpm