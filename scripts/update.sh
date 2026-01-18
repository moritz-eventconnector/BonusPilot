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

docker compose up -d --build

docker compose exec -T app composer install --no-dev --optimize-autoloader

docker compose exec -T app php artisan migrate --force

docker compose exec -T app php artisan config:cache

docker compose exec -T app php artisan route:cache

docker compose exec -T app php artisan view:cache

echo "Update done."
