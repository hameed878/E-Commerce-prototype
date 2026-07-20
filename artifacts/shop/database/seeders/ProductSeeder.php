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
        $clothing = Category::where('slug', 'clothing')->first();
        $homeKitchen = Category::where('slug', 'home-kitchen')->first();
        $books = Category::where('slug', 'books')->first();
        $sports = Category::where('slug', 'sports-outdoors')->first();
        $beauty = Category::where('slug', 'beauty-personal-care')->first();

        $products = [
            [
                'category_id' => $electronics->id,
                'name' => 'Wireless Noise-Cancelling Headphones',
                'description' => 'Experience crystal-clear audio with our premium wireless headphones featuring active noise cancellation, 30-hour battery life, and ultra-comfortable memory foam ear cushions. Perfect for work, travel, or immersive listening sessions.',
                'price' => 149.99,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&q=80',
                'stock_quantity' => 24,
            ],
            [
                'category_id' => $electronics->id,
                'name' => 'Smart Watch Pro 5',
                'description' => 'Track your fitness, stay connected, and look great with our Smart Watch Pro 5. Features heart rate monitoring, GPS, 7-day battery life, and a stunning always-on AMOLED display. Water-resistant up to 50 meters.',
                'price' => 299.99,
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&q=80',
                'stock_quantity' => 18,
            ],
            [
                'category_id' => $clothing->id,
                'name' => 'Premium Merino Wool Sweater',
                'description' => 'Crafted from 100% New Zealand merino wool, this sweater is naturally temperature-regulating, odor-resistant, and incredibly soft. Available in a classic relaxed fit that pairs perfectly with any casual outfit.',
                'price' => 89.99,
                'image_url' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600&q=80',
                'stock_quantity' => 42,
            ],
            [
                'category_id' => $homeKitchen->id,
                'name' => 'Espresso Machine Deluxe',
                'description' => 'Bring the café experience home with our 15-bar pressure espresso machine. Features a built-in milk frother, programmable shot volumes, and a rapid heat-up system that\'s ready in under 30 seconds. Stainless steel construction for lasting quality.',
                'price' => 199.00,
                'image_url' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=600&q=80',
                'stock_quantity' => 12,
            ],
            [
                'category_id' => $sports->id,
                'name' => 'Ultralight Trail Running Shoes',
                'description' => 'Built for speed and endurance on any terrain. Our trail running shoes feature responsive cushioning, aggressive grip outsoles, and a breathable knit upper that adapts to your foot shape. Weighing in at just 220g per shoe.',
                'price' => 124.95,
                'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80',
                'stock_quantity' => 35,
            ],
            [
                'category_id' => $beauty->id,
                'name' => 'Vitamin C Brightening Serum',
                'description' => 'Reveal your most radiant skin with our potent 20% Vitamin C serum. Formulated with hyaluronic acid and niacinamide to brighten dark spots, even skin tone, and boost collagen production. Dermatologist tested and suitable for all skin types.',
                'price' => 54.99,
                'image_url' => 'https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=600&q=80',
                'stock_quantity' => 0,
            ],
        ];

        foreach ($products as $data) {
            $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(5));
            $data['is_active'] = true;
            Product::create($data);
        }
    }
}
