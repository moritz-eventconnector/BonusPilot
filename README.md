# BonusPilot

BonusPilot is a self-hostable bonus listing MVP with an admin backend, built on Laravel 11, PostgreSQL 16, Docker Compose, Nginx, and Caddy.

## Prerequisites
- Ubuntu 24.04 server with a domain pointed at the server IP.
- Root or sudo access.

## Install
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

## Update
```bash
sudo ./scripts/update.sh
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

## Shared Hosting (e.g. Namecheap Stellar) – Not Supported
This project is designed for a VPS/server with Docker, Docker Compose, and open ports 80/443. Shared hosting plans (including cPanel-based plans like Namecheap Stellar) typically do not provide root/sudo access, Docker, or port binding, so the default install is not possible.

### Alternative (cPanel/Shared Hosting) — Manual & Unsupported
If you still want to run this on a cPanel-based shared host, you need a **manual deployment** that is maintained separately from the Docker setup. This is **not supported** and may break with updates.

**Concrete cPanel guide (Application Manager / PHP App)**
1. **Create a database** (cPanel → MySQL® Databases):
   - Create a database and user, then grant the user *All Privileges*.
2. **Upload the app** (cPanel → File Manager):
   - Upload the contents of the `app/` directory into a private folder such as `~/bonuspilot` (do **not** upload to `public_html`).
3. **Composer install** (cPanel → Terminal/SSH):
   - Run `cd ~/bonuspilot && composer install --no-dev --optimize-autoloader`.
4. **Set PHP version + extensions** (cPanel → Select PHP Version):
   - Choose a PHP version compatible with Laravel 11 and enable required extensions.
5. **Configure .env**:
   - Copy `~/bonuspilot/.env.example` to `~/bonuspilot/.env`.
   - Set:
     - `APP_URL=https://your-domain.tld`
     - `APP_ENV=production`
     - `APP_DEBUG=false`
     - `DB_CONNECTION=mysql` (most shared hosts use MySQL/MariaDB)
     - `DB_HOST=localhost`
     - `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` from cPanel database user.
6. **Generate app key**:
   - `cd ~/bonuspilot && php artisan key:generate`
7. **Migrate and seed**:
   - `php artisan migrate --force`
   - `php artisan db:seed --force`
8. **Storage permissions + symlink**:
   - Ensure `storage/` and `bootstrap/cache/` are writable.
   - Run `php artisan storage:link`.
9. **Serve from public/**:
   - In cPanel, set the domain’s document root to `~/bonuspilot/public`.
   - If using **Application Manager**, set:
     - **Application Path**: `bonuspilot`
     - **Document Root** (or equivalent): `bonuspilot/public`
10. **Cron job** (cPanel → Cron Jobs):
    - `* * * * * /usr/bin/php /home/<user>/bonuspilot/artisan schedule:run >> /dev/null 2>&1`

**Ways to make this easier in cPanel (if available on your plan)**
- **File Manager**: upload a zip, then extract it into `~/bonuspilot`.
- **Git Version Control**: connect the repo and pull updates via cPanel's Git UI.
- **Terminal/SSH**: run `composer install` and `php artisan` commands directly.
- **PHP version selector**: switch PHP versions and enable required extensions.
- **Cron Jobs UI**: add the scheduler command without needing root.

Because this alternative is outside the supported deployment model, a VPS is strongly recommended for reliability and updates.

## Troubleshooting
- If you see a 502 after rebuilding, run `docker compose up -d --build` again to ensure all containers are recreated and DNS is refreshed.
