FROM php:8.1.5-fpm-alpine

RUN apk update && apk add --no-cache \
    git \
    curl \
    libpng-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ARG uid=1000
ARG user=laravel

# Create a group and user with specified UID and GID
RUN addgroup -g $uid -S $user \
    && adduser -u $uid -S -G $user $user


RUN mkdir -p /var/www/html

COPY ./src /var/www/html

WORKDIR /var/www/html

# Copy the composer.json and composer.lock
COPY ./src/composer.json ./src/composer.lock ./

# Install Composer dependencies
RUN composer install --no-scripts --no-autoloader


# Generate Laravel application key
RUN php artisan key:generate

# Set permissions
RUN chown -R $user:$user /var/www/html/storage /var/www/html/bootstrap/cache

# Set correct permissions for Laravel log files
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

USER $user

EXPOSE 9000
CMD ["php-fpm"]
