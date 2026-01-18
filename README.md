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
<<<<<<< HEAD
- Create or restore backups from **Admin → Backups**.
=======
>>>>>>> origin/main

## Branding
Update branding from **Admin → Settings**:
- Upload logo (PNG/JPG/SVG).
- Set primary/secondary/background colors.
- Configure social links.

## Notes
- Caddy handles HTTPS and proxies to Nginx.
- App is served by PHP-FPM in the `app` container.
<<<<<<< HEAD
- Weekly backups run automatically with a 4-week retention policy.
=======
>>>>>>> origin/main
