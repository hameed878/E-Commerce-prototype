@extends('layouts.app')
@section('title', __('shop.your_wishlist'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="flex items-center justify-between mb-6 sm:mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">{{ __('shop.your_wishlist') }}</h1>
            @if($wishlists->isNotEmpty())
            <p class="text-sm text-gray-500 mt-1">{{ $wishlists->count() }} {{ $wishlists->count() === 1 ? __('shop.item') : __('shop.items') }} {{ __('shop.saved') }}</p>
            @endif
        </div>
        <a href="{{ route('shop.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            {{ __('shop.browse_shop') }}
        </a>
    </div>

    @if($wishlists->isEmpty())
    <div class="text-center py-24 bg-white rounded-2xl border border-gray-100 shadow-sm">
        <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
        </svg>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('shop.wishlist_empty') }}</h3>
        <p class="text-gray-500 text-sm mb-6">{{ __('shop.wishlist_empty_desc') }}</p>
        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-colors">
            {{ __('shop.browse_shop') }}
        </a>
    </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
        @foreach($wishlists as $wl)
        @php $product = $wl->product; @endphp
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-shadow flex flex-col">
            {{-- Image --}}
            <a href="{{ route('shop.show', $product) }}" class="block relative overflow-hidden h-40 sm:h-52 bg-gray-100 flex-shrink-0">
                @if($product->image_url)
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                @endif
                @if(!$product->isInStock())
                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
                    <span class="bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full">{{ __('shop.out_of_stock') }}</span>
                </div>
                @endif
                {{-- Remove from wishlist --}}
                <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="absolute top-2 end-2">
                    @csrf
                    <button type="submit" title="{{ __('shop.remove_from_wishlist') }}"
                            class="w-8 h-8 bg-white rounded-full shadow flex items-center justify-center text-red-500 hover:bg-red-50 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </form>
            </a>

            {{-- Info --}}
            <div class="p-3 sm:p-4 flex flex-col flex-1">
                <a href="{{ route('shop.show', $product) }}" class="block flex-1">
                    <h3 class="font-semibold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors line-clamp-2 text-sm sm:text-base leading-tight">
                        {{ $product->name }}
                    </h3>
                    @if($product->category)
                    <span class="text-xs text-gray-400">{{ $product->category->name }}</span>
                    @endif
                </a>
                <div class="flex items-center justify-between gap-2 mt-3">
                    <span class="text-base sm:text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @if($product->isInStock())
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                                class="bg-indigo-600 text-white px-3 py-1.5 rounded-xl text-xs sm:text-sm font-semibold hover:bg-indigo-700 active:scale-95 transition-all whitespace-nowrap">
                            {{ __('shop.add_to_cart') }}
                        </button>
                    </form>
                    @else
                    <span class="text-xs text-gray-400 font-medium">{{ __('shop.sold_out') }}</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
