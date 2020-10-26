FROM php:7.4-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    # apt-get install supervisor -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-enable pdo_mysql
RUN pecl install redis && docker-php-ext-enable redis