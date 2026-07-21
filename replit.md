# ShopWave — SaaS-Ready E-Commerce Platform

A production-ready Laravel e-commerce platform with Stripe checkout, PDF invoicing, role-based dashboards, and full inventory management.

## Run & Operate

- The app runs via the **`artifacts/shopwave: web`** managed workflow: `cd artifacts/shop && bash start.sh`
- `start.sh` generates `.env` from Replit env vars, runs `php artisan migrate --force`, then starts the server
- `cd artifacts/shop && php artisan db:seed` — seed demo data
- `cd artifacts/shop && php artisan migrate:fresh --seed` — reset and re-seed DB

## Required Secrets & Env Vars

Set in Replit Secrets / Shared Env:

| Key | Value | Purpose |
|-----|-------|---------|
| `DB_CONNECTION` | `sqlite` | Database driver |
| `DB_DATABASE` | `/home/runner/workspace/artifacts/shop/database/database.sqlite` | SQLite file path |
| `SESSION_DRIVER` | `file` | File-based sessions |
| `CACHE_STORE` | `file` | File-based cache |
| `STRIPE_KEY` | your key | Stripe publishable key (optional) |
| `STRIPE_SECRET` | your key | Stripe secret key (optional, secret) |
| `STRIPE_WEBHOOK_SECRET` | your key | Stripe webhook secret (optional, secret) |

## Architecture Decisions (Setup)

- **SQLite over Neon PostgreSQL**: Neon's network latency (~1s/request) caused health checks to fail. SQLite is zero-latency and sufficient for development. To use PostgreSQL in production, set `DB_CONNECTION=pgsql` and the `DB_*` env vars in the production environment.
- **`start.sh` as entrypoint**: Generates `.env` from Replit env vars, runs migrations, then starts the server. Managed by the `artifacts/shopwave: web` workflow.

## Stack

- PHP 8.2 · Laravel 12
- Database: SQLite (`artifacts/shop/database/database.sqlite`) — switched from Neon PostgreSQL for zero-latency local dev
- Auth: Custom session-based (no Breeze dependency)
- CSS: Tailwind CSS via CDN
- Payments: Stripe PHP SDK (`stripe/stripe-php`)
- PDF: `barryvdh/laravel-dompdf`
- Mail: Log driver (configurable to SMTP/Mailgun)

## Where Things Live

- Routes: `artifacts/shop/routes/web.php`
- Controllers: `artifacts/shop/app/Http/Controllers/`
- Models: `artifacts/shop/app/Models/`
- Views: `artifacts/shop/resources/views/`
- Migrations: `artifacts/shop/database/migrations/`
- Seeders: `artifacts/shop/database/seeders/`
- Invoice PDF template: `artifacts/shop/resources/views/invoices/invoice.blade.php`
- Confirmation email: `artifacts/shop/resources/views/emails/order-confirmed.blade.php`

## Architecture Decisions

- **Session cart**: Cart stored in PHP session (no DB table needed). Cleared after successful webhook confirmation.
- **Webhook-driven fulfillment**: Stock decrement, invoice generation, and email sending all triggered by the `checkout.session.completed` Stripe webhook — not on the redirect URL.
- **SQLite**: Used for zero-config portability. Swap to MySQL/Postgres by updating `DB_CONNECTION` env vars.
- **Idempotent webhook**: Checks `order->isPaid()` before processing to prevent double-fulfillment.
- **Policy gate**: `OrderPolicy` ensures customers can only view/download their own orders.

## Product

- Public storefront with search + category filters
- Stock-aware "Add to Cart" / "Out of Stock" states
- Session cart with quantity controls, tax (10%), $5 shipping, grand total
- Stripe Checkout integration (test mode)
- Webhook listener at `/webhook/stripe`
- PDF invoice auto-generation on payment confirmation
- Order confirmation email with PDF attachment
- Customer dashboard: order history + invoice downloads
- Admin dashboard: revenue stats, product CRUD, order management

## Demo Credentials

| Role     | Email                     | Password   |
|----------|---------------------------|------------|
| Admin    | admin@shopwave.com        | password   |
| Customer | customer@shopwave.com     | password   |

## User Preferences

- Build: PHP 8.2 + Laravel 12, SQLite, Tailwind CSS via CDN
- Stripe keys must be added as Replit Secrets: `STRIPE_KEY`, `STRIPE_SECRET`, `STRIPE_WEBHOOK_SECRET`

## Gotchas

- Stripe webhook must bypass CSRF — already configured via `withoutMiddleware` in `routes/web.php`
- The webhook handles stock decrement and invoice generation; the `/checkout/success` redirect is display-only
- To test Stripe webhooks locally, use the Stripe CLI: `stripe listen --forward-to localhost:3000/webhook/stripe`
- Mail is set to `log` driver — check `artifacts/shop/storage/logs/laravel.log` to see emails

## Pointers

- Stripe test cards: `4242 4242 4242 4242` (success), `4000 0000 0000 0002` (decline)
