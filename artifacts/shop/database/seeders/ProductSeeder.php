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
            // ── Electronics (14) ──────────────────────────────────────────
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
            [
                'category_id'    => $electronics->id,
                'name'           => 'Ergonomic Wireless Mouse',
                'description'    => 'Vertical ergonomic design reduces wrist strain by 57%. 4000 DPI precision sensor, 70-day battery life, and silent click buttons. Works on any surface.',
                'price'          => 49.99,
                'image_url'      => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=600&q=80',
                'stock_quantity' => 35,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => '27" 4K IPS Monitor',
                'description'    => '3840×2160 resolution, 99% sRGB coverage, 1ms response time, and dual USB-C ports with 90W power delivery. The display your work deserves.',
                'price'          => 449.00,
                'image_url'      => 'https://images.unsplash.com/photo-1547082299-de196ea013d6?w=600&q=80',
                'stock_quantity' => 10,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => 'USB-C 100W Charging Hub (7-in-1)',
                'description'    => 'Single cable docking: 4K HDMI, 100W pass-through charging, SD card, 3× USB-A, and Ethernet — all through one USB-C port. Works with any laptop.',
                'price'          => 59.99,
                'image_url'      => 'https://images.unsplash.com/photo-1625895197185-efcec01cffe0?w=600&q=80',
                'stock_quantity' => 50,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => 'True Wireless Earbuds Pro',
                'description'    => 'ANC earbuds with 32-hour total battery (8hr buds + 24hr case), IPX5 sweat resistance, and custom EQ via app. Crystal sound, zero wires.',
                'price'          => 129.99,
                'image_url'      => 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=600&q=80',
                'stock_quantity' => 28,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => 'Portable SSD 1TB',
                'description'    => '1,050 MB/s read speed, drop-proof up to 3m, and pocket-sized at 51g. Move a full-length 4K film in under 8 seconds. Works with USB-C and USB-A.',
                'price'          => 109.00,
                'image_url'      => 'https://images.unsplash.com/photo-1601737487795-dab272f52420?w=600&q=80',
                'stock_quantity' => 32,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => 'Smart Home Security Camera',
                'description'    => '2K HDR video, 160° wide-angle, colour night vision, two-way audio, and AI person detection. Keeps watch 24/7 — indoors or out.',
                'price'          => 64.99,
                'image_url'      => 'https://images.unsplash.com/photo-1557597774-9d273605dfa9?w=600&q=80',
                'stock_quantity' => 19,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => 'E-Reader 7" Paperwhite',
                'description'    => '300 PPI glare-free display, adjustable warm light, IPX8 waterproof, and 10-week battery. Holds 6,500 books in your pocket.',
                'price'          => 139.99,
                'image_url'      => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=600&q=80',
                'stock_quantity' => 27,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => 'Wireless Charging Pad Trio',
                'description'    => 'Simultaneously charges phone, earbuds, and smartwatch. 15W fast wireless, Qi universal, and a slim 5mm profile that fits any desk.',
                'price'          => 39.99,
                'image_url'      => 'https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=600&q=80',
                'stock_quantity' => 0,
            ],
            [
                'category_id'    => $electronics->id,
                'name'           => 'Noise-Cancelling Gaming Headset',
                'description'    => '7.1 surround sound, detachable cardioid mic, memory foam ear cups, and RGB lighting. Hear every footstep before it happens.',
                'price'          => 99.99,
                'image_url'      => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=600&q=80',
                'stock_quantity' => 14,
            ],

            // ── Clothing (9) ──────────────────────────────────────────────
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
                'name'           => 'Classic Slim-Fit Chinos',
                'description'    => 'Stretch-cotton twill with a slim-tapered leg. Wrinkle-resistant, machine washable, and sharp enough for the office — comfortable enough for the weekend.',
                'price'          => 64.99,
                'image_url'      => 'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?w=600&q=80',
                'stock_quantity' => 60,
            ],
            [
                'category_id'    => $clothing->id,
                'name'           => 'Lightweight Running Jacket',
                'description'    => 'Wind-resistant, water-repellent shell with laser-cut ventilation zones. Packs into its own chest pocket. Reflective details for low-light visibility.',
                'price'          => 74.95,
                'image_url'      => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80',
                'stock_quantity' => 31,
            ],
            [
                'category_id'    => $clothing->id,
                'name'           => 'Organic Cotton Crew T-Shirt',
                'description'    => 'GOTS-certified organic cotton, garment-dyed for a lived-in look that gets better with every wash. Boxy, relaxed fit. Available in 12 colours.',
                'price'          => 28.00,
                'image_url'      => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=600&q=80',
                'stock_quantity' => 120,
            ],
            [
                'category_id'    => $clothing->id,
                'name'           => 'Waterproof Hiking Boots',
                'description'    => 'Gore-Tex® lining, Vibram® outsole, and a supportive mid-cut ankle. Keeps feet dry on river crossings and comfortable on 20km trail days.',
                'price'          => 184.00,
                'image_url'      => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80',
                'stock_quantity' => 22,
            ],
            [
                'category_id'    => $clothing->id,
                'name'           => 'Cashmere Beanie Hat',
                'description'    => 'Pure Grade-A Mongolian cashmere. Lightweight yet warm at -10°C, pill-resistant, and hand-washable. A cold-weather essential you will reach for every day.',
                'price'          => 45.00,
                'image_url'      => 'https://images.unsplash.com/photo-1510598155-3c86e6a5e8c3?w=600&q=80',
                'stock_quantity' => 55,
            ],
            [
                'category_id'    => $clothing->id,
                'name'           => 'Performance Yoga Leggings',
                'description'    => '4-way stretch fabric with a high-rise waistband and hidden pocket. Squat-proof, moisture-wicking, and flattering from studio to street.',
                'price'          => 54.99,
                'image_url'      => 'https://images.unsplash.com/photo-1506629082955-511b1aa562c8?w=600&q=80',
                'stock_quantity' => 48,
            ],
            [
                'category_id'    => $clothing->id,
                'name'           => 'Oxford Button-Down Shirt',
                'description'    => 'Classic Oxford weave in a modern slim fit. Non-iron finish, reinforced collar stays, and mother-of-pearl buttons. The shirt that never lets you down.',
                'price'          => 69.00,
                'image_url'      => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=600&q=80',
                'stock_quantity' => 37,
            ],
            [
                'category_id'    => $clothing->id,
                'name'           => 'Puffer Down Jacket (700-Fill)',
                'description'    => '700-fill-power ethically sourced down, windproof shell, and a slim silhouette that doesn\'t add bulk. Warm to -20°C and light enough to forget you are wearing it.',
                'price'          => 229.00,
                'image_url'      => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=600&q=80',
                'stock_quantity' => 16,
            ],

            // ── Home & Kitchen (8) ─────────────────────────────────────────
            [
                'category_id'    => $home->id,
                'name'           => 'Pour-Over Coffee Maker Set',
                'description'    => 'Borosilicate glass dripper with a walnut-wood collar, gooseneck kettle, and 40 natural filters. Brews a clean, nuanced cup that any barista would be proud of.',
                'price'          => 59.99,
                'image_url'      => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&q=80',
                'stock_quantity' => 29,
            ],
            [
                'category_id'    => $home->id,
                'name'           => 'Cast Iron Dutch Oven 5.5 qt',
                'description'    => 'Enamelled cast iron distributes heat evenly and retains it for hours. Braise, bake bread, simmer soups — one pot that does it all. Lifetime guarantee.',
                'price'          => 169.00,
                'image_url'      => 'https://images.unsplash.com/photo-1585515320310-259814833e62?w=600&q=80',
                'stock_quantity' => 12,
            ],
            [
                'category_id'    => $home->id,
                'name'           => 'Bamboo Cutting Board Set (3-pc)',
                'description'    => 'FSC-certified bamboo, naturally antimicrobial and knife-friendly. Juice grooves on large and medium boards. Non-slip feet keep boards locked while you prep.',
                'price'          => 34.95,
                'image_url'      => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80',
                'stock_quantity' => 66,
            ],
            [
                'category_id'    => $home->id,
                'name'           => 'Robot Vacuum & Mop Combo',
                'description'    => '4000Pa suction, LiDAR room mapping, selective room cleaning, and automatic mopping with adjustable water flow. Cleans while you focus on everything else.',
                'price'          => 399.00,
                'image_url'      => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80',
                'stock_quantity' => 7,
            ],
            [
                'category_id'    => $home->id,
                'name'           => 'Air Purifier True HEPA H13',
                'description'    => 'Captures 99.97% of airborne particles including PM2.5, pollen, pet dander, and smoke. Covers 500 sq ft in under 30 minutes. Near-silent at 20dB.',
                'price'          => 199.00,
                'image_url'      => 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=600&q=80',
                'stock_quantity' => 18,
            ],
            [
                'category_id'    => $home->id,
                'name'           => 'Smart LED Strip Lights 10m',
                'description'    => 'App-controlled, music-sync, and voice assistant compatible. 16 million colours, cuttable at any 3-LED interval, and includes power supply and mounting clips.',
                'price'          => 29.99,
                'image_url'      => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=600&q=80',
                'stock_quantity' => 85,
            ],
            [
                'category_id'    => $home->id,
                'name'           => 'French Press Coffee Maker 1L',
                'description'    => 'Double-wall stainless steel keeps coffee hot for 2 hours. Four-layer filtration system delivers rich, full-bodied coffee with zero grounds in the cup.',
                'price'          => 42.00,
                'image_url'      => 'https://images.unsplash.com/photo-1520970014086-2208d157c9e2?w=600&q=80',
                'stock_quantity' => 44,
            ],
            [
                'category_id'    => $home->id,
                'name'           => 'Weighted Blanket 15 lb',
                'description'    => 'Evenly distributed glass bead filling provides deep-pressure stimulation for better sleep. Cooling cotton top, minky dot underside. Machine washable up to 60°C.',
                'price'          => 79.00,
                'image_url'      => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80',
                'stock_quantity' => 23,
            ],

            // ── Books (8) ─────────────────────────────────────────────────
            [
                'category_id'    => $books->id,
                'name'           => 'Atomic Habits — James Clear',
                'description'    => 'A proven framework for improving every day. James Clear reveals practical strategies for forming good habits, breaking bad ones, and mastering the tiny behaviours that lead to remarkable results.',
                'price'          => 16.99,
                'image_url'      => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=600&q=80',
                'stock_quantity' => 100,
            ],
            [
                'category_id'    => $books->id,
                'name'           => 'The Psychology of Money — Morgan Housel',
                'description'    => '19 short stories exploring the strange ways people think about money — and teaching you how to make better sense of the most important financial decisions of your life.',
                'price'          => 14.99,
                'image_url'      => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=600&q=80',
                'stock_quantity' => 75,
            ],
            [
                'category_id'    => $books->id,
                'name'           => 'Deep Work — Cal Newport',
                'description'    => 'Rules for focused success in a distracted world. Newport argues that the ability to perform deep work is becoming increasingly rare and valuable in our knowledge economy.',
                'price'          => 15.99,
                'image_url'      => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&q=80',
                'stock_quantity' => 60,
            ],
            [
                'category_id'    => $books->id,
                'name'           => 'Sapiens — Yuval Noah Harari',
                'description'    => 'A brief history of humankind — from the Stone Age to the Silicon Age. Harari surveys the whole of human history, exploring how biology and history have defined us.',
                'price'          => 17.99,
                'image_url'      => 'https://images.unsplash.com/photo-1589998059171-988d887df646?w=600&q=80',
                'stock_quantity' => 88,
            ],
            [
                'category_id'    => $books->id,
                'name'           => 'The Lean Startup — Eric Ries',
                'description'    => 'How today\'s entrepreneurs use continuous innovation to create radically successful businesses. The essential methodology for modern product development and validated learning.',
                'price'          => 15.00,
                'image_url'      => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&q=80',
                'stock_quantity' => 52,
            ],
            [
                'category_id'    => $books->id,
                'name'           => 'Zero to One — Peter Thiel',
                'description'    => 'Notes on startups, or how to build the future. Thiel shows how we can find singular ways to create new things that are 10× better — going from zero to one.',
                'price'          => 13.99,
                'image_url'      => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=600&q=80',
                'stock_quantity' => 43,
            ],
            [
                'category_id'    => $books->id,
                'name'           => 'Thinking, Fast and Slow — Daniel Kahneman',
                'description'    => 'A tour of the mind: the fast, intuitive System 1 and the deliberate, logical System 2. Kahneman reveals how these two systems shape our judgements and decisions.',
                'price'          => 14.00,
                'image_url'      => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600&q=80',
                'stock_quantity' => 67,
            ],
            [
                'category_id'    => $books->id,
                'name'           => 'The 4-Hour Workweek — Tim Ferriss',
                'description'    => 'Escape 9–5, live anywhere, and join the new rich. Ferriss\'s blueprint for designing your ideal lifestyle through outsourcing, automation, and mini-retirements.',
                'price'          => 13.50,
                'image_url'      => 'https://images.unsplash.com/photo-1553729459-efe14ef6055d?w=600&q=80',
                'stock_quantity' => 39,
            ],

            // ── Sports & Outdoors (7) ──────────────────────────────────────
            [
                'category_id'    => $sports->id,
                'name'           => 'Yoga Mat Premium Non-Slip 6mm',
                'description'    => 'Natural tree rubber base with microfibre top for grip that improves with sweat. Alignment guide lines, carrying strap included. Ideal for hot yoga and pilates.',
                'price'          => 78.00,
                'image_url'      => 'https://images.unsplash.com/photo-1599901860904-17e6ed7083a0?w=600&q=80',
                'stock_quantity' => 36,
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
            [
                'category_id'    => $sports->id,
                'name'           => 'Jump Rope Speed Cable',
                'description'    => 'Aircraft-grade aluminium handles with a sealed bearing system for zero drag. Steel cable, adjustable length, and a travel pouch. 300 skips a minute, no excuses.',
                'price'          => 22.99,
                'image_url'      => 'https://images.unsplash.com/photo-1601422407692-ec4eeec1d9b3?w=600&q=80',
                'stock_quantity' => 90,
            ],
            [
                'category_id'    => $sports->id,
                'name'           => 'Foam Roller 33cm Deep Tissue',
                'description'    => 'High-density EVA foam with multi-directional surface patterns. Targets muscle knots, improves circulation, and shortens recovery time. Supports up to 150kg.',
                'price'          => 34.00,
                'image_url'      => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?w=600&q=80',
                'stock_quantity' => 55,
            ],
            [
                'category_id'    => $sports->id,
                'name'           => 'Resistance Band Set (5 levels)',
                'description'    => 'Natural latex bands in five resistance levels (10–50 lb). Includes door anchor, ankle straps, and handles. Full-body workout, anywhere — no gym required.',
                'price'          => 27.99,
                'image_url'      => 'https://images.unsplash.com/photo-1598289431512-b97b0917affc?w=600&q=80',
                'stock_quantity' => 73,
            ],
            [
                'category_id'    => $sports->id,
                'name'           => 'Insulated Stainless Steel Water Bottle 40oz',
                'description'    => 'Triple-wall vacuum insulation keeps drinks cold 48hr / hot 24hr. Leak-proof lid, wide mouth for ice, and a powder-coated grip finish. BPA-free.',
                'price'          => 38.00,
                'image_url'      => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=600&q=80',
                'stock_quantity' => 0,
            ],

            // ── Beauty & Personal Care (7) ─────────────────────────────────
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
            [
                'category_id'    => $beauty->id,
                'name'           => 'Retinol Night Cream 2.5%',
                'description'    => 'Pharmaceutical-grade retinol with shea butter and ceramides. Visibly reduces fine lines and wrinkles in 4 weeks without the irritation of harsher formulas.',
                'price'          => 49.00,
                'image_url'      => 'https://images.unsplash.com/photo-1611080626919-7cf5a9dbab12?w=600&q=80',
                'stock_quantity' => 38,
            ],
            [
                'category_id'    => $beauty->id,
                'name'           => 'Ionic Hair Dryer Pro 2200W',
                'description'    => 'Negative ion technology seals the cuticle for 50% less frizz. Three heat and two speed settings, cool-shot button, and a magnetic diffuser and concentrator included.',
                'price'          => 94.99,
                'image_url'      => 'https://images.unsplash.com/photo-1522338242992-e1a54906a8da?w=600&q=80',
                'stock_quantity' => 21,
            ],
            [
                'category_id'    => $beauty->id,
                'name'           => 'SPF 50 Mineral Sunscreen',
                'description'    => 'Reef-safe, non-nano zinc oxide, invisible finish, and water-resistant for 80 minutes. Lightweight enough for daily use under makeup. Fragrance-free.',
                'price'          => 26.00,
                'image_url'      => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=600&q=80',
                'stock_quantity' => 62,
            ],
            [
                'category_id'    => $beauty->id,
                'name'           => 'Bamboo Charcoal Face Wash',
                'description'    => 'Activated charcoal and kaolin clay draw out impurities and excess oil without stripping moisture. Gentle enough for twice-daily use on combination and oily skin.',
                'price'          => 18.99,
                'image_url'      => 'https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?w=600&q=80',
                'stock_quantity' => 79,
            ],
        ];

        foreach ($products as $data) {
            $data['slug']      = Str::slug($data['name']) . '-' . Str::lower(Str::random(5));
            $data['is_active'] = true;
            Product::create($data);
        }
    }
}
