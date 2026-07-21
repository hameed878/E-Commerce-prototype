<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronics = Category::where('slug', 'electronics')->first();
        $clothing    = Category::where('slug', 'clothing')->first();
        $home        = Category::where('slug', 'home-kitchen')->first();
        $books       = Category::where('slug', 'books')->first();
        $sports      = Category::where('slug', 'sports-outdoors')->first();
        $beauty      = Category::where('slug', 'beauty-personal-care')->first();

        $products = [
            // Electronics
            [
                'category_id'    => $electronics->id,
                'name'           => 'Wireless Noise-Cancelling Headphones',
                'description'    => 'Premium over-ear headphones with active noise cancellation, 30-hour battery life, and ultra-comfortable memory foam cushions. Perfect for travel and deep work sessions.',
                'price'          => 149.99,
                'image_url'      => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80',
                'stock_quantity' => 24,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => 'Smart Watch Pro 5',
                'description'    => 'GPS smartwatch with heart rate monitoring, 7-day battery, always-on AMOLED display, and 50m water resistance. Your health companion on every adventure.',
                'price'          => 299.99,
                'image_url'      => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&q=80',
                'stock_quantity' => 18,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => 'Portable Bluetooth Speaker',
                'description'    => '360° surround sound, 20-hour playtime, and IP67 waterproof rating. Drop it in the sand, take it in the rain — the music never stops.',
                'price'          => 79.99,
                'image_url'      => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=600&q=80',
                'stock_quantity' => 40,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => 'Mechanical Keyboard TKL',
                'description'    => 'Tenkeyless mechanical keyboard with tactile brown switches, per-key RGB backlighting, and aircraft-grade aluminium frame. Built for marathon typing sessions.',
                'price'          => 119.00,
                'image_url'      => 'https://images.unsplash.com/photo-1595225476474-87563907a212?w=600&q=80',
                'stock_quantity' => 15,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => '4K Ultra HD Webcam',
                'description'    => 'Crystal-clear 4K video, auto-focus, built-in dual microphones with noise reduction, and wide-angle lens. Look your best in every call and stream.',
                'price'          => 89.95,
                'image_url'      => 'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=600&q=80',
                'stock_quantity' => 22,
            ],

            // Clothing
            [
                'category_id'    => $clothing->id,
                'name'           => 'Premium Merino Wool Sweater',
                'description'    => '100% New Zealand merino wool. Naturally temperature-regulating, odour-resistant, and incredibly soft against skin. A relaxed fit that works from desk to dinner.',
                'price'          => 89.99,
                'image_url'      => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600&q=80',
                'stock_quantity' => 42,
            ],
            [
                'category_id'    => $clothing->id,
                'name'           => 'Classic Oxford Button-Down Shirt',
                'description'    => 'Woven from premium 100% cotton Oxford cloth. Timeless collar, box pleat, and a tailored slim fit. Goes effortlessly from boardroom to weekend brunch.',
                'price'          => 64.99,
                'image_url'      => 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?w=600&q=80',
                'stock_quantity' => 55,
            ],
            [
                'category_id'    => $clothing->id,
                'name'           => 'Slim-Fit Chino Trousers',
                'description'    => 'Stretch-cotton chinos with a modern slim silhouette. Wrinkle-resistant fabric that looks sharp at 8 am and still feels comfortable at 8 pm.',
                'price'          => 74.95,
                'image_url'      => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=600&q=80',
                'stock_quantity' => 38,
            ],

            // Home & Kitchen
            [
                'category_id'    => $home->id,
                'name'           => 'Espresso Machine Deluxe',
                'description'    => '15-bar pressure, built-in milk frother, programmable shot volumes, and 30-second heat-up. Café-quality espresso from the comfort of your kitchen.',
                'price'          => 199.00,
                'image_url'      => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=600&q=80',
                'stock_quantity' => 12,
            ],
            [
                'category_id'    => $home->id,
                'name'           => 'Cast Iron Dutch Oven 5.5 Qt',
                'description'    => 'Enamelled cast iron retains heat evenly for perfect braises, soups, and artisan bread. Oven-safe to 500°F and compatible with all cooktops including induction.',
                'price'          => 139.00,
                'image_url'      => 'https://images.unsplash.com/photo-1585515320310-259814833e62?w=600&q=80',
                'stock_quantity' => 20,
            ],
            [
                'category_id'    => $home->id,
                'name'           => 'Bamboo Cutting Board Set (3-piece)',
                'description'    => 'Sustainably sourced bamboo, naturally antimicrobial. Set includes small prep board, medium serving board, and large carving board — with juice groove on the large.',
                'price'          => 44.99,
                'image_url'      => 'https://images.unsplash.com/photo-1606760227091-3dd870d97f1d?w=600&q=80',
                'stock_quantity' => 60,
            ],

            // Books
            [
                'category_id'    => $books->id,
                'name'           => 'Atomic Habits — James Clear',
                'description'    => 'The no.1 bestseller on building good habits and breaking bad ones. Clear\'s practical framework has helped millions make tiny changes that deliver remarkable results.',
                'price'          => 18.99,
                'image_url'      => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=600&q=80',
                'stock_quantity' => 100,
            ],
            [
                'category_id'    => $books->id,
                'name'           => 'Deep Work — Cal Newport',
                'description'    => 'Rules for focused success in a distracted world. Newport argues that the ability to perform deep work is becoming rare and enormously valuable in the modern economy.',
                'price'          => 16.99,
                'image_url'      => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=600&q=80',
                'stock_quantity' => 80,
            ],
            [
                'category_id'    => $books->id,
                'name'           => 'The Lean Startup — Eric Ries',
                'description'    => 'How today\'s entrepreneurs use continuous innovation to create radically successful businesses. A must-read for anyone building a product or company from scratch.',
                'price'          => 17.50,
                'image_url'      => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600&q=80',
                'stock_quantity' => 75,
            ],
            [
                'category_id'    => $books->id,
                'name'           => 'Sapiens — Yuval Noah Harari',
                'description'    => 'A brief history of humankind — from the Stone Age through the 21st century. Harari explores how biology and history have defined us and challenges us to consider our future.',
                'price'          => 19.99,
                'image_url'      => 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=600&q=80',
                'stock_quantity' => 90,
            ],

            // Sports & Outdoors
            [
                'category_id'    => $sports->id,
                'name'           => 'Ultralight Trail Running Shoes',
                'description'    => 'Responsive cushioning, aggressive grip outsoles, and a breathable knit upper. Weighing just 220g per shoe — built for speed on any terrain.',
                'price'          => 124.95,
                'image_url'      => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80',
                'stock_quantity' => 35,
            ],
            [
                'category_id'    => $sports->id,
                'name'           => 'Adjustable Dumbbell Set (5–52.5 lbs)',
                'description'    => 'Replaces 15 individual dumbbells. Dial-select system adjusts in 2.5 lb increments — from a gentle warm-up to a heavy strength session — in seconds.',
                'price'          => 349.00,
                'image_url'      => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=600&q=80',
                'stock_quantity' => 8,
            ],
            [
                'category_id'    => $sports->id,
                'name'           => 'Insulated Hydration Backpack 20L',
                'description'    => '2L hydration bladder, insulated main compartment, trekking pole loops, and padded back panel with airflow channels. Ideal for hikes, bike rides, and day trips.',
                'price'          => 84.99,
                'image_url'      => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&q=80',
                'stock_quantity' => 28,
            ],

            // Beauty & Personal Care
            [
                'category_id'    => $beauty->id,
                'name'           => 'Vitamin C Brightening Serum',
                'description'    => '20% Vitamin C with hyaluronic acid and niacinamide. Fades dark spots, evens skin tone, and boosts collagen. Dermatologist tested for all skin types.',
                'price'          => 54.99,
                'image_url'      => 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=600&q=80',
                'stock_quantity' => 0,
            ],
            [
                'category_id'    => $beauty->id,
                'name'           => 'Electric Sonic Toothbrush',
                'description'    => '31,000 brush strokes per minute with five cleaning modes, built-in 2-minute timer, and USB travel case. Removes 10× more plaque than a manual brush.',
                'price'          => 69.99,
                'image_url'      => 'https://images.unsplash.com/photo-1559591937-abc7c9f0f350?w=600&q=80',
                'stock_quantity' => 33,
            ],
            [
                'category_id'    => $beauty->id,
                'name'           => 'Natural Argan Oil Hair Mask',
                'description'    => 'Deep-conditioning treatment with cold-pressed Moroccan argan oil, keratin, and coconut extract. Restores shine, tames frizz, and repairs damage in 10 minutes.',
                'price'          => 32.50,
                'image_url'      => 'https://images.unsplash.com/photo-1526045612212-70caf35c14df?w=600&q=80',
                'stock_quantity' => 47,
            ],
        ];

        foreach ($products as $data) {
            $data['slug']      = Str::slug($data['name']) . '-' . Str::lower(Str::random(5));
            $data['is_active'] = true;
            Product::create($data);
        }
    }
}
