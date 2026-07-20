# ShopWave — SaaS-Ready E-Commerce Platform

A production-ready Laravel e-commerce platform with Stripe checkout, PDF invoicing, role-based dashboards, and full inventory management.

## Run & Operate

- `cd artifacts/shop && php artisan serve --host=0.0.0.0 --port=3000` — run the Laravel app
- `cd artifacts/shop && php artisan migrate` — run database migrations
- `cd artifacts/shop && php artisan db:seed` — seed demo data
- `cd artifacts/shop && php artisan migrate:fresh --seed` — reset and re-seed DB

## Stack

- PHP 8.2 · Laravel 12
- Database: SQLite (file: `artifacts/shop/database/database.sqlite`)
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
