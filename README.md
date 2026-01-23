# BonusPilot

BonusPilot is a self-hostable bonus listing MVP with an admin backend, built on Laravel 11, PostgreSQL 16, Docker Compose, Nginx, and Caddy.

## Prerequisites
Choose the install path that matches your environment.

### Docker/VPS
- Ubuntu 24.04 server with a domain pointed at the server IP.
- Root or sudo access.

### cPanel (Shared Hosting)
- cPanel with PHP 8.2+ and Composer available.
- Ability to set the document root for a domain/subdomain.
- MySQL/MariaDB database and user.

## Install

### Docker/VPS (scripted)
```bash
sudo ./scripts/install.sh
```

The installer will prompt for:
- Domain (without https://)
- Admin name
- Admin email
- Admin password

After install, access:
- Site: `https://<domain>/`
- Admin login: `https://<domain>/login`

### cPanel 1-click (Application Manager / Git deploy)
**Goal:** click “Deploy” and let cPanel run our script.

1) **Upload the repo** to `~/bonuspilot` (File Manager or Git Version Control).
2) **Create a database** (cPanel → MySQL® Databases) and grant *All Privileges*.
3) **Enable PHP + extensions** (cPanel → Select PHP Version):
   - `pdo_mysql`, `mbstring`, `intl`, `zip`, `openssl`, `bcmath`, `fileinfo`.
4) **Set the document root** to `~/bonuspilot/app/public`.
5) **Add the 1‑click install script** in cPanel Application Manager:
   ```bash
   /bin/bash /home/<user>/bonuspilot/scripts/cpanel-install.sh
   ```
6) **Set env values** in `app/.env`:
   - `APP_URL`, `DB_CONNECTION=mysql`, `DB_HOST=localhost`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
7) **Optional demo data** (run once):
   ```bash
   SEED=true /bin/bash /home/<user>/bonuspilot/scripts/cpanel-install.sh
   ```

## Update

### Docker/VPS (scripted)
```bash
sudo ./scripts/update.sh
```

### cPanel 1-click update
1) **Pull the latest code** via cPanel Git Version Control (or upload a new zip).
2) **Add the 1‑click update script** as a post‑deployment hook:
   ```bash
   /bin/bash /home/<user>/bonuspilot/scripts/cpanel-update.sh
   ```
3) **Optional cache rebuild**:
   ```bash
   CACHE=true /bin/bash /home/<user>/bonuspilot/scripts/cpanel-update.sh
   ```

## Admin usage
- Log in at `/login`.
- Manage bonuses, filters, pages, and settings from `/admin`.
- Create or restore backups from **Admin → Backups**.

## Branding
Update branding from **Admin → Settings**:
- Upload logo (PNG/JPG/SVG).
- Set primary/secondary/background colors.
- Configure social links.

## Notes
- Caddy handles HTTPS and proxies to Nginx.
- App is served by PHP-FPM in the `app` container.
- Weekly backups run automatically with a 4-week retention policy.

## cPanel Notes
- Ensure `storage/` and `bootstrap/cache/` are writable.
- Set a cron job:
  - `* * * * * /usr/bin/php /home/<user>/bonuspilot/app/artisan schedule:run >> /dev/null 2>&1`
- If your host does not provide Composer, enable it in cPanel or ask support to install it.
- If your app path differs, prefix scripts with `APP_DIR=/path/to/app`.

## Troubleshooting
- If you see a 502 after rebuilding, run `docker compose up -d --build` again to ensure all containers are recreated and DNS is refreshed.
