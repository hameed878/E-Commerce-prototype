#!/usr/bin/env bash
set -e

cd "$(dirname "$0")"

# ── Generate .env from environment variables ────────────────────────────────
cat > .env <<EOF
APP_NAME=${SHOP_APP_NAME:-ShopWave}
APP_ENV=${SHOP_APP_ENV:-local}
APP_KEY=
APP_DEBUG=${SHOP_APP_DEBUG:-true}
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=${SHOP_LOG_LEVEL:-debug}

DB_CONNECTION=${DB_CONNECTION:-pgsql}
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}
DB_SSLMODE=${DB_SSLMODE:-require}

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@shopwave.com"
MAIL_FROM_NAME="\${APP_NAME}"

STRIPE_KEY=${STRIPE_KEY:-}
STRIPE_SECRET=${STRIPE_SECRET:-}
STRIPE_WEBHOOK_SECRET=${STRIPE_WEBHOOK_SECRET:-}

VITE_APP_NAME="\${APP_NAME}"
EOF

# ── Generate app key if missing ─────────────────────────────────────────────
php artisan key:generate --force --no-ansi

# ── Run migrations ──────────────────────────────────────────────────────────
php artisan migrate --force --no-ansi

# ── Start server ────────────────────────────────────────────────────────────
php artisan serve --host=0.0.0.0 --port="${PORT:-3000}"
