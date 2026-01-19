#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)
cd "$ROOT_DIR"

mkdir -p app/bootstrap/cache \
  app/storage/app/public \
  app/storage/framework/cache \
  app/storage/framework/sessions \
  app/storage/framework/views \
  app/storage/logs

chmod -R 775 app/bootstrap/cache app/storage
chmod -R a+rX app/public app/storage/app/public

docker compose up -d --build

docker compose exec -T app sh -c "mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache && touch storage/logs/laravel.log && chown -R www-data:www-data storage bootstrap/cache && chmod -R 775 storage bootstrap/cache"

docker compose exec -T app composer install --no-dev --optimize-autoloader

docker compose exec -T app php artisan migrate --force

docker compose exec -T app php artisan optimize:clear

docker compose exec -T app php artisan config:cache

docker compose exec -T app php artisan route:cache

docker compose exec -T app php artisan view:cache

docker compose restart app web

echo "Update done."
