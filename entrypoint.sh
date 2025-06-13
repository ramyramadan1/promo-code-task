#!/bin/sh

# Wait for MySQL to be ready
echo "Waiting for MySQL..."
until nc -z -v -w30 db 3306
do
  echo "Waiting for MySQL..."
  sleep 2
done

php artisan migrate --force
php artisan db:seed --force
php artisan passport:keys
php artisan vendor:publish --tag=passport-config
php artisan passport:client --password
exec "$@"
