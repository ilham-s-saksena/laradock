echo "______  _  _    _              "
echo "| ___ \(_)| |  (_)             "
echo "| |_/ / _ | |   _  _   _  _ __ "
echo "|  __/ | || |  | || | | || '__|"
echo "| |    | || |  | || |_| || |   "
echo "\_|    |_||_|  | | \__,_||_|   "
echo "              _/ |             "
echo "             |__/              "
echo "--------------------------------"
echo "--Start Instaling Dependencies--"
echo "--------------------------------"


docker run --rm \
  -v "$(dirname $(readlink -f $0))/src:/var/www/html" \
  -w /var/www/html \
  laravelsail/php82-composer:latest \
  bash -c '
    composer install

    php artisan env:decrypt --key=6UVsEgGVK36XN82KKeyLFMhvosbZN1aF

    chmod -R 777 storage

    php artisan key:generate
  '