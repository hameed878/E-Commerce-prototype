#!/usr/bin/env bash
set -e

cd "$(dirname "$0")"

# ── Generate .env from environment variables ────────────────────────────────
cat > .env <<EOF
APP_NAME=${SHOP_APP_NAME:-ShopWave}
APP_ENV=${SHOP_APP_ENV:-local}
APP_KEY=${APP_KEY}
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

SESSION_DRIVER=${SESSION_DRIVER:-file}
SESSION_LIFETIME=${SESSION_LIFETIME:-120}
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}

CACHE_STORE=${CACHE_STORE:-file}

MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@shopwave.com"
MAIL_FROM_NAME="\${APP_NAME}"

STRIPE_KEY=${STRIPE_KEY:-}
STRIPE_SECRET=${STRIPE_SECRET:-}
STRIPE_WEBHOOK_SECRET=${STRIPE_WEBHOOK_SECRET:-}

VITE_APP_NAME="\${APP_NAME}"
EOF

# ── Run migrations ──────────────────────────────────────────────────────────
# Use direct (non-pooler) host for DDL migrations — PgBouncer transaction mode
# doesn't support DDL transactions. Falls back gracefully for SQLite.
MIGRATE_HOST="${DB_HOST//-pooler./\.}"
DB_HOST="$MIGRATE_HOST" php artisan migrate --force --no-ansi

# ── Ensure storage symlink exists (needed for uploaded product images) ───────
php artisan storage:link --force 2>/dev/null || true

# ── Seed demo data if the products table is empty ───────────────────────────
PRODUCT_COUNT=$(php artisan tinker --execute="echo App\Models\Product::count();" 2>/dev/null | tail -1 || echo "0")
if [ "$PRODUCT_COUNT" = "0" ]; then
    echo "No products found — seeding demo data..."
    DB_HOST="$MIGRATE_HOST" php artisan db:seed --force --no-ansi
fi

# ── Start server ────────────────────────────────────────────────────────────
php artisan serve --host=0.0.0.0 --port="${PORT:-3000}"
