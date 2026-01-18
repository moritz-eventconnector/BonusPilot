#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)
cd "$ROOT_DIR"

docker compose up -d --build

docker compose exec -T app composer install --no-dev --optimize-autoloader

docker compose exec -T app php artisan migrate --force

docker compose exec -T app php artisan config:cache

docker compose exec -T app php artisan route:cache

docker compose exec -T app php artisan view:cache

echo "Update done."
