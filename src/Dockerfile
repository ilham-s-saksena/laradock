FROM php:8.1.5-fpm-alpine

RUN apk update && apk add --no-cache \
    libpq \
    libpng \
    libxml2 \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libxml2-dev \
    mysql-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli

RUN mkdir -p /var/www/html
COPY . /var/www/html
WORKDIR /var/www/html

RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 777 /var/www/html/storage/

EXPOSE 9000
CMD ["php-fpm"]
