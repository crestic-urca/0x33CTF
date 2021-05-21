#!/bin/bash


if [[ -z "${TIME_ZONE}"  ]]; then
  TIME_ZONE="Europe/Paris"
fi

sed -i "s|TZ_REPLACE|$TIME_ZONE|" .env

touch database/database.sqlite
chown www-data:www-data database/database.sqlite
php artisan key:generate
php artisan migrate

#TODO : enlever les fonctions dans les routes, probleme de closure
#php artisan route:cache

#TODO : a changer, probleme chmod ici, voir docker compose storage
#chown -R www-data:www-data /var/www/html/storage/
#chmod -R 750 /var/www/html/storage/

exec apache2-foreground
