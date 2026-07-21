<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        $products = $query->latest()->paginate(24)->withQueryString();
        $categories = Category::withCount('products')->get();
        $selectedCategory = $request->category;
        $search = $request->search;

        // Wishlist product IDs for the current user (for heart icons)
        $wishlistIds = auth()->check()
            ? auth()->user()->wishlists()->pluck('product_id')->toArray()
            : [];

        return view('shop.index', compact('products', 'categories', 'selectedCategory', 'search', 'wishlistIds'));
    }

    public function show(Product $product)
    {
        $product->load('category');

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        // Reviews with user info
        $reviews = $product->reviews()->with('user')->get();
        $avgRating = $product->averageRating();

        // Current user's review (if any) and wishlist status
        $userReview   = auth()->check()
            ? $reviews->firstWhere('user_id', auth()->id())
            : null;
        $inWishlist   = auth()->check()
            ? auth()->user()->hasWishlisted($product->id)
            : false;

        return view('shop.show', compact('product', 'related', 'reviews', 'avgRating', 'userReview', 'inWishlist'));
    }
}
