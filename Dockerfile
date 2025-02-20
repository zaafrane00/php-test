from php:8.3-fpm-alpine

RUN apt-get update

RUN apk add --no-cache \
    bash \
    git \
    openssh \
    icu-dev \
    libzip-dev \
    zip \
    unzip && docker-php-ext-install \
    intl \
    opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
COPY . .

RUN mkdir -p /var/cache && chmod -R 777 /var/cache

RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm"]