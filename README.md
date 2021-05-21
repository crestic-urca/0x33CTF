## installation

avec un serveur web et mysql :

```
composer install
cp .env.default .env
php artisan key:generate
php artisan migrate:fresh
php artisan db:seed
```
