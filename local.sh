cp src/.env.example src/.env
docker-compose build
docker-compose run --rm --user `id -u`:`id -g` composer install
docker-compose up -d
docker-compose run --rm --user `id -u`:`id -g` artisan migrate
docker-compose run --rm --user `id -u`:`id -g` artisan migrate --env=testing
docker-compose run --rm --user `id -u`:`id -g` php ./vendor/bin/phpunit