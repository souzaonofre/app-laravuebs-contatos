# Set the base image for subsequent instructions
FROM php:7.4

WORKDIR /var/www

# Update packages

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash - \
    && apt-get update \
    && apt-get install -y nodejs netcat libmcrypt-dev libjpeg-dev libpng-dev libfreetype6-dev libbz2-dev nodejs git \
    && apt-get clean

# Install extensions

#RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

RUN apt-get update && \
    apt-get install -y autoconf pkg-config libssl-dev git libzip-dev zlib1g-dev libonig-dev && \
    pecl install mongodb && docker-php-ext-enable mongodb && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo_mysql mbstring zip exif pcntl


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .
COPY ./docker/docker.env .env

CMD ["bash", "./docker/entrypoint.sh"]

