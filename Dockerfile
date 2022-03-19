FROM php:8.0-cli

WORKDIR /app

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

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

RUN groupadd --gid 1000 node && useradd --uid 1000 --gid 1000 --create-home --shell /bin/bash bodianskii
USER bodianskii
