#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
APP_DIR="${APP_DIR:-}"
CACHE="${CACHE:-false}"

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

"${COMPOSER_BIN}" install --no-dev --optimize-autoloader

php artisan migrate --force
if [[ "${CACHE}" == "true" ]]; then
  php artisan cache:clear
  php artisan config:cache
  php artisan route:cache
fi

cat <<'EOF'
----------------------------------------
cPanel update complete.
If you encounter issues, clear caches and verify your .env settings.
Optional cache rebuild: rerun with CACHE=true.
----------------------------------------
EOF
