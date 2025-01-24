FROM php:8.0-apache

RUN apt update

RUN apt-get install -y \
    libxml2-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libcurl4-openssl-dev \
    libsqlite3-dev \
    libicu-dev \
    libxslt-dev \
    unzip

RUN docker-php-ext-install pdo pdo_mysql mysqli gd zip intl mbstring bcmath exif opcache

RUN cd /etc/apache2 && rm apache2.conf

ADD apache2.conf /etc/apache2/

RUN a2enmod rewrite
