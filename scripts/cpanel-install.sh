#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
APP_DIR="${APP_DIR:-}"
SEED="${SEED:-false}"

if [[ -z "${APP_DIR}" ]]; then
  if [[ -d "${ROOT_DIR}/app" && -f "${ROOT_DIR}/app/artisan" ]]; then
    APP_DIR="${ROOT_DIR}/app"
  elif [[ -f "${ROOT_DIR}/artisan" ]]; then
    APP_DIR="${ROOT_DIR}"
  else
    echo "Could not locate Laravel app directory. Set APP_DIR to the app path." >&2
    exit 1
  fi
fi

cd "${APP_DIR}"

if command -v composer >/dev/null 2>&1; then
  COMPOSER_BIN="composer"
elif [[ -x "/opt/cpanel/composer/bin/composer" ]]; then
  COMPOSER_BIN="/opt/cpanel/composer/bin/composer"
elif [[ -x "/usr/local/bin/composer" ]]; then
  COMPOSER_BIN="/usr/local/bin/composer"
else
  echo "Composer not found. Enable Composer in cPanel or install it before running this script." >&2
  exit 1
fi

if ! command -v php >/dev/null 2>&1; then
  echo "PHP not found in PATH. Ensure the PHP version is enabled in cPanel." >&2
  exit 1
fi

if [[ ! -f ".env" ]]; then
  cp .env.example .env
fi

set_env() {
  local key="$1"
  local value="$2"
  if grep -q "^${key}=" .env; then
    sed -i "s|^${key}=.*|${key}=${value}|" .env
  else
    echo "${key}=${value}" >> .env
  fi
}

set_env "APP_ENV" "production"
set_env "APP_DEBUG" "false"

"${COMPOSER_BIN}" install --no-dev --optimize-autoloader

php artisan key:generate --force
php artisan migrate --force
if [[ "${SEED}" == "true" ]]; then
  php artisan db:seed --force
fi
php artisan storage:link

cat <<'EOF'
----------------------------------------
cPanel install complete.
Next steps:
1) Set APP_URL and DB_* values in .env.
2) Ensure storage/ and bootstrap/cache/ are writable.
3) Set the document root to app/public (or public if app root).
4) Add cron: * * * * * /usr/bin/php /home/<user>/bonuspilot/app/artisan schedule:run >> /dev/null 2>&1
5) Optional seed: rerun with SEED=true to import demo data.
----------------------------------------
EOF
