FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        mysqli \
        pdo_mysql \
        gd \
        zip \
        mbstring \
        exif \
        xml \
        soap \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

COPY ./docker/php.ini /usr/local/etc/php/conf.d/custom.ini

COPY ./docker/apache.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
