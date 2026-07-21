@extends('layouts.app')
@section('title', 'Shop')

@section('content')
{{-- Hero Banner --}}
<div class="bg-gradient-to-br from-indigo-600 to-purple-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <h1 class="text-2xl sm:text-4xl font-bold mb-2 sm:mb-3">{{ __('shop.discover_products') }}</h1>
        <p class="text-indigo-100 text-sm sm:text-lg mb-5 sm:mb-6">{{ __('shop.hero_subtitle') }}</p>
        {{-- Mobile Search --}}
        <form action="{{ route('shop.index') }}" method="GET" class="flex md:hidden">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="{{ __('shop.search_placeholder') }}"
                   class="flex-1 px-4 py-3 rounded-s-full text-gray-900 text-sm focus:outline-none">
            <button type="submit" class="bg-white text-indigo-600 px-4 sm:px-5 rounded-e-full font-semibold text-sm hover:bg-indigo-50">Go</button>
        </form>
    </div>
</div>

{{-- Mobile Category Filter (horizontal scroll) --}}
<div class="lg:hidden bg-white border-b border-gray-100 sticky top-16 z-40">
    <div class="flex overflow-x-auto gap-2 px-4 py-3 scrollbar-hide">
        <a href="{{ route('shop.index', ['search' => $search]) }}"
           class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-medium transition-colors {{ !$selectedCategory ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            {{ __('shop.all_products') }}
        </a>
        @foreach($categories as $category)
        <a href="{{ route('shop.index', ['category' => $category->slug, 'search' => $search]) }}"
           class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-medium transition-colors {{ $selectedCategory === $category->slug ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            {{ $category->name }}
        </a>
        @endforeach
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="flex gap-8">
        {{-- Sidebar Filters (desktop) --}}
        <aside class="hidden lg:block w-56 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 sticky top-20">
                <h3 class="font-semibold text-gray-900 mb-4">{{ __('shop.categories') }}</h3>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('shop.index', ['search' => $search]) }}"
                           class="block px-3 py-2 rounded-lg text-sm transition-colors {{ !$selectedCategory ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            {{ __('shop.all_products') }}
                            <span class="float-end text-xs text-gray-400">{{ $products->total() }}</span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                    <li>
                        <a href="{{ route('shop.index', ['category' => $category->slug, 'search' => $search]) }}"
                           class="block px-3 py-2 rounded-lg text-sm transition-colors {{ $selectedCategory === $category->slug ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                            {{ $category->name }}
                            <span class="float-end text-xs text-gray-400">{{ $category->products_count }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- Product Grid --}}
        <div class="flex-1 min-w-0">
            {{-- Active Filters --}}
            @if($search || $selectedCategory)
            <div class="flex items-center gap-2 mb-5 flex-wrap">
                <span class="text-sm text-gray-500">Results for:</span>
                @if($search)
                <span class="inline-flex items-center gap-1 bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm">
                    "{{ $search }}"
                    <a href="{{ route('shop.index', ['category' => $selectedCategory]) }}" class="hover:text-indigo-900 font-bold">&times;</a>
                </span>
                @endif
                @if($selectedCategory)
                <span class="inline-flex items-center gap-1 bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm">
                    {{ $categories->firstWhere('slug', $selectedCategory)?->name }}
                    <a href="{{ route('shop.index', ['search' => $search]) }}" class="hover:text-purple-900 font-bold">&times;</a>
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
                <a href="{{ route('shop.index') }}" class="mt-4 inline-block text-indigo-600 hover:underline text-sm">{{ __('shop.browse_shop') }}</a>
            </div>
            @else
            <div class="grid grid-cols-2 sm:grid-cols-2 xl:grid-cols-3 gap-3 sm:gap-6">
                @foreach($products as $product)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-shadow duration-200 flex flex-col">
                    {{-- Product Image --}}
                    <div class="relative overflow-hidden h-40 sm:h-52 bg-gray-100 flex-shrink-0">
                        <a href="{{ route('shop.show', $product) }}" class="block w-full h-full">
                            @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 sm:w-16 sm:h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            @endif
                        </a>
                        @if(!$product->isInStock())
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center pointer-events-none">
                            <span class="bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">{{ __('shop.out_of_stock') }}</span>
                        </div>
                        @endif
                        @if($product->category)
                        <span class="absolute top-2 start-2 bg-white text-xs font-medium text-gray-600 px-2 py-0.5 rounded-full shadow-sm hidden sm:inline-block">
                            {{ $product->category->name }}
                        </span>
                        @endif
                        {{-- Wishlist heart --}}
                        @auth
                        <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="absolute top-2 end-2">
                            @csrf
                            <button type="submit"
                                    title="{{ in_array($product->id, $wishlistIds) ? __('shop.remove_from_wishlist') : __('shop.add_to_wishlist') }}"
                                    class="w-8 h-8 bg-white rounded-full shadow flex items-center justify-center transition-colors
                                           {{ in_array($product->id, $wishlistIds) ? 'text-red-500 hover:bg-red-50' : 'text-gray-400 hover:text-red-500 hover:bg-red-50' }}">
                                <svg class="w-4 h-4" fill="{{ in_array($product->id, $wishlistIds) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>
                        </form>
                        @endauth
                    </div>

                    {{-- Product Info --}}
                    <div class="p-3 sm:p-5 flex flex-col flex-1">
                        <a href="{{ route('shop.show', $product) }}" class="block flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors line-clamp-2 text-sm sm:text-base leading-tight">{{ $product->name }}</h3>
                            <p class="text-xs sm:text-sm text-gray-500 line-clamp-2 mb-2 sm:mb-3 hidden sm:block">{{ $product->description }}</p>
                        </a>
                        <div class="flex items-center justify-between gap-2 mt-auto">
                            <div>
                                <span class="text-base sm:text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                @if($product->isInStock())
                                <p class="text-xs text-green-600 font-medium hidden sm:block">{{ $product->stock_quantity }} {{ __('shop.in_stock_qty') }}</p>
                                @else
                                <p class="text-xs text-red-500 font-medium hidden sm:block">{{ __('shop.out_of_stock') }}</p>
                                @endif
                            </div>
                            @if($product->isInStock())
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit"
                                        class="bg-indigo-600 text-white px-2.5 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs sm:text-sm font-semibold hover:bg-indigo-700 active:scale-95 transition-all duration-150 whitespace-nowrap">
                                    <span class="hidden sm:inline">{{ __('shop.add_to_cart') }}</span>
                                    <span class="sm:hidden">{{ __('shop.added') }}</span>
                                </button>
                            </form>
                            @else
                            <button disabled class="bg-gray-100 text-gray-400 px-2.5 py-1.5 sm:px-4 sm:py-2 rounded-xl text-xs sm:text-sm font-semibold cursor-not-allowed whitespace-nowrap">
                                {{ __('shop.sold_out') }}
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
