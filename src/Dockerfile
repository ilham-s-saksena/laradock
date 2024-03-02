FROM php:8.1.5-fpm-alpine


RUN apk update && apk add --no-cache \
    git \
    curl \
    libpng-dev \
    zip \
    unzip \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*
    

# Install PHP extensions

# ARG uid="$(id -u)"

# # Create a group and user with specified UID and GID
# RUN addgroup -g $uid \
#     && adduser -u $uid



RUN docker-php-ext-install pdo_mysql

RUN mkdir -p /var/www/html

COPY ./src /var/www/html

WORKDIR /var/www/html

RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 777 /var/www/html/storage/



EXPOSE 9000
CMD ["php-fpm"]
