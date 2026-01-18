FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    bash \
    git \
    curl \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    postgresql-dev \
<<<<<<< HEAD
    postgresql-client \
=======
>>>>>>> origin/main
    zip \
    unzip

RUN docker-php-ext-install pdo_pgsql mbstring intl zip opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY php.ini /usr/local/etc/php/conf.d/zz-bonuspilot.ini

WORKDIR /var/www/html
