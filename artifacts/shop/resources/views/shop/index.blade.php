@extends('layouts.app')
@section('title', 'Shop')

@section('content')
{{-- Hero Banner --}}
<div class="bg-gradient-to-br from-indigo-600 to-purple-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="text-4xl font-bold mb-3">Discover Amazing Products</h1>
        <p class="text-indigo-100 text-lg mb-6">Free shipping on all orders over $50 · Secure Stripe checkout</p>
        {{-- Mobile Search --}}
        <form action="{{ route('shop.index') }}" method="GET" class="flex md:hidden">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search products..."
                   class="flex-1 px-4 py-3 rounded-l-full text-gray-900 text-sm focus:outline-none">
            <button type="submit" class="bg-white text-indigo-600 px-5 rounded-r-full font-semibold text-sm hover:bg-indigo-50">Search</button>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex gap-8">
        {{-- Sidebar Filters --}}
        <aside class="hidden lg:block w-56 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-20">
                <h3 class="font-semibold text-gray-900 mb-4">Categories</h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('shop.index', ['search' => $search]) }}"
                           class="block px-3 py-2 rounded-lg text-sm transition-colors {{ !$selectedCategory ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            All Products
                            <span class="float-right text-xs text-gray-400">{{ $products->total() }}</span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('shop.index', ['category' => $category->slug, 'search' => $search]) }}"
                           class="block px-3 py-2 rounded-lg text-sm transition-colors {{ $selectedCategory === $category->slug ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            {{ $category->name }}
                            <span class="float-right text-xs text-gray-400">{{ $category->products_count }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- Product Grid --}}
        <div class="flex-1">
            {{-- Active Filters --}}
            @if($search || $selectedCategory)
            <div class="flex items-center gap-2 mb-5 flex-wrap">
                <span class="text-sm text-gray-500">Showing results for:</span>
                @if($search)
                <span class="inline-flex items-center gap-1 bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm">
                    "{{ $search }}"
                    <a href="{{ route('shop.index', ['category' => $selectedCategory]) }}" class="hover:text-indigo-900">&times;</a>
                </span>
                @endif
                @if($selectedCategory)
                <span class="inline-flex items-center gap-1 bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm">
                    {{ $categories->firstWhere('slug', $selectedCategory)?->name }}
                    <a href="{{ route('shop.index', ['search' => $search]) }}" class="hover:text-purple-900">&times;</a>
                </span>
                @endif
                <a href="{{ route('shop.index') }}" class="text-xs text-gray-400 hover:text-red-500">Clear all</a>
            </div>
            @endif

            @if($products->isEmpty())
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No products found</h3>
                <p class="text-gray-500 text-sm">Try adjusting your search or filter.</p>
                <a href="{{ route('shop.index') }}" class="mt-4 inline-block text-indigo-600 hover:underline text-sm">Browse all products</a>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-shadow duration-200">
                    {{-- Product Image --}}
                    <a href="{{ route('shop.show', $product) }}" class="block relative overflow-hidden h-52 bg-gray-100">
                        @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        @endif
                        @if(!$product->isInStock())
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                            <span class="bg-red-500 text-white text-sm font-semibold px-3 py-1 rounded-full">Out of Stock</span>
                        </div>
                        @endif
                        @if($product->category)
                        <span class="absolute top-3 left-3 bg-white text-xs font-medium text-gray-600 px-2 py-1 rounded-full shadow-sm">
                            {{ $product->category->name }}
                        </span>
                        @endif
                    </a>

                    {{-- Product Info --}}
                    <div class="p-5">
                        <a href="{{ route('shop.show', $product) }}" class="block">
                            <h3 class="font-semibold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors line-clamp-1">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $product->description }}</p>
                        </a>
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                @if($product->isInStock())
                                <p class="text-xs text-green-600 font-medium">{{ $product->stock_quantity }} in stock</p>
                                @else
                                <p class="text-xs text-red-500 font-medium">Out of stock</p>
                                @endif
                            </div>
                            @if($product->isInStock())
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-indigo-700 active:scale-95 transition-all duration-150">
                                    Add to Cart
                                </button>
                            </form>
                            @else
                            <button disabled class="bg-gray-100 text-gray-400 px-4 py-2 rounded-xl text-sm font-semibold cursor-not-allowed">
                                Out of Stock
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
            @endif
            @endif
        </div>
    </div>
</div>
@endsection
