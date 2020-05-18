# Run Database Migrations
php artisan config:clear
php artisan migrate:refresh --seed -n --force

# Run Seeds
php artisan db:seed

