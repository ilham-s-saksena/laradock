docker run --rm \
  -v "$(dirname $(readlink -f $0))/src:/var/www/html" \
  -w /var/www/html \
  laravelsail/php82-composer:latest \
  bash -c '
    composer install

    php artisan env:decrypt --key=6UVsEgGVK36XN82KKeyLFMhvosbZN1aF

    php -m | grep dom

    php -m | grep mysql

    chmod -R 777 storage

    php artisan key:generate
  '