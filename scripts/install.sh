#!/usr/bin/env bash
set -euo pipefail

if [[ $EUID -ne 0 ]]; then
  echo "Please run as root or with sudo."
  exit 1
fi

install_docker() {
  if command -v docker >/dev/null 2>&1; then
    return
  fi

  apt-get update -y
  apt-get install -y ca-certificates curl gnupg
  install -m 0755 -d /etc/apt/keyrings
  curl -fsSL https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
  chmod a+r /etc/apt/keyrings/docker.gpg
  echo \
    "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \"$(. /etc/os-release && echo $VERSION_CODENAME)\" stable" \
    > /etc/apt/sources.list.d/docker.list
  apt-get update -y
  apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
}

install_docker

read -rp "Domain (without https://): " APP_DOMAIN
read -rp "Admin name: " ADMIN_NAME
read -rp "Admin email: " ADMIN_EMAIL
read -rsp "Admin password: " ADMIN_PASSWORD
echo ""

ROOT_DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)
cd "$ROOT_DIR"

mkdir -p app/bootstrap/cache \
  app/storage/app/public \
  app/storage/framework/cache \
  app/storage/framework/sessions \
  app/storage/framework/views \
  app/storage/logs

chmod -R 775 app/bootstrap/cache app/storage

set_env_value() {
  local key="$1"
  local value="$2"
  local file="$3"

  if grep -q "^${key}=" "$file"; then
    sed -i "s|^${key}=.*|${key}=${value}|" "$file"
  else
    echo "${key}=${value}" >> "$file"
  fi
}

if [[ ! -f .env ]]; then
  cp .env.example .env
fi

if [[ -f .env ]]; then
  EXISTING_DB_PASSWORD=$(grep -E '^DB_PASSWORD=' .env | cut -d '=' -f2- || true)
fi

DB_PASSWORD=${EXISTING_DB_PASSWORD:-$(openssl rand -base64 32 | tr -d '\n')}

set_env_value "APP_URL" "https://${APP_DOMAIN}" .env
set_env_value "APP_DOMAIN" "${APP_DOMAIN}" .env
set_env_value "DB_PASSWORD" "${DB_PASSWORD}" .env

set -a
# shellcheck disable=SC1091
source .env
set +a

DB_USERNAME=${DB_USERNAME:-bonuspilot}
DB_DATABASE=${DB_DATABASE:-bonuspilot}

if [[ ! -f app/.env.example ]]; then
  echo "app/.env.example missing."
  exit 1
fi

if [[ ! -f app/.env ]]; then
  cp app/.env.example app/.env
fi

set_env_value "APP_URL" "https://${APP_DOMAIN}" app/.env
set_env_value "APP_DOMAIN" "${APP_DOMAIN}" app/.env
set_env_value "DB_PASSWORD" "${DB_PASSWORD}" app/.env

docker compose up -d --build

docker compose exec -T db psql -U postgres -d postgres -v ON_ERROR_STOP=1 <<SQL
DO \$\$
BEGIN
  IF NOT EXISTS (SELECT FROM pg_roles WHERE rolname = '${DB_USERNAME}') THEN
    CREATE ROLE ${DB_USERNAME} LOGIN PASSWORD '${DB_PASSWORD}';
  END IF;
END
\$\$;
ALTER ROLE ${DB_USERNAME} WITH PASSWORD '${DB_PASSWORD}';
DO \$\$
BEGIN
  IF NOT EXISTS (SELECT FROM pg_database WHERE datname = '${DB_DATABASE}') THEN
    CREATE DATABASE ${DB_DATABASE} OWNER ${DB_USERNAME};
  END IF;
END
\$\$;
SQL

docker compose exec -T app composer install --no-dev --optimize-autoloader

docker compose exec -T app php artisan key:generate --force

docker compose exec -T app php artisan migrate --force

docker compose exec -T app php artisan db:seed --force

docker compose exec -T app php artisan app:create-admin \
  --name="${ADMIN_NAME}" \
  --email="${ADMIN_EMAIL}" \
  --password="${ADMIN_PASSWORD}"

docker compose exec -T app php artisan storage:link

cat <<EOM

Install complete.
Visit:
https://${APP_DOMAIN}/
https://${APP_DOMAIN}/login
EOM
