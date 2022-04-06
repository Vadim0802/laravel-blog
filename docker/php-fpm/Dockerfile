FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    libsqlite3-dev

RUN docker-php-ext-install \
    zip \
    bcmath \
    pgsql \
    pdo \
    pdo_sqlite \
    pdo_pgsql

WORKDIR /app
