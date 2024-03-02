docker run --rm \
  -v "$(dirname $(readlink -f $0))/src:/var/www/html" \
  -w /var/www/html \
  laravelsail/php82-composer:latest \
  bash -c '
    # Step 3: Run composer install
    composer install

    echo "----------------------------"

    php -m | grep dom

    echo "$(id -g)"
    echo "----------------------------"


    # Step 4: Change permissions
    chmod +w storage/logs/

    ls -l storage/logs

    # Step 5: Generate application key
    php artisan key:generate
  '
pwd