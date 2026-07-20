@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-xs sm:text-sm text-gray-500 mb-6 sm:mb-8 flex-wrap">
        <a href="{{ route('shop.index') }}" class="hover:text-indigo-600">Shop</a>
        <span>/</span>
        @if($product->category)
        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-indigo-600">{{ $product->category->name }}</a>
        <span>/</span>
        @endif
        <span class="text-gray-900 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-12">
        {{-- Product Image --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-64 sm:h-80 lg:h-96 object-cover">
            @else
            <div class="w-full h-64 sm:h-80 lg:h-96 bg-gray-100 flex items-center justify-center">
                <svg class="w-16 h-16 sm:w-24 sm:h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            @endif
        </div>

        {{-- Product Details --}}
        <div class="flex flex-col">
            @if($product->category)
            <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full mb-3 w-fit">{{ $product->category->name }}</span>
            @endif

            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 sm:mb-3">{{ $product->name }}</h1>
            <p class="text-3xl sm:text-4xl font-extrabold text-indigo-600 mb-3 sm:mb-4">${{ number_format($product->price, 2) }}</p>

            {{-- Stock Indicator --}}
            @if($product->isInStock())
            <div class="flex items-center gap-2 mb-4 sm:mb-6">
                <span class="w-2.5 h-2.5 bg-green-400 rounded-full animate-pulse flex-shrink-0"></span>
                <span class="text-sm text-green-700 font-medium">In Stock — {{ $product->stock_quantity }} units available</span>
            </div>
            @else
            <div class="flex items-center gap-2 mb-4 sm:mb-6">
                <span class="w-2.5 h-2.5 bg-red-400 rounded-full flex-shrink-0"></span>
                <span class="text-sm text-red-600 font-medium">Out of Stock</span>
            </div>
            @endif

            <p class="text-gray-600 leading-relaxed mb-6 sm:mb-8 text-sm sm:text-base">{{ $product->description }}</p>

            {{-- Add to Cart --}}
            @if($product->isInStock())
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <div class="flex gap-3 items-center">
                    <div class="flex items-center border border-gray-300 rounded-xl overflow-hidden flex-shrink-0">
                        <button type="button" onclick="adjustQty(-1)" class="px-3 sm:px-4 py-3 text-gray-600 hover:bg-gray-50 font-semibold text-base">−</button>
                        <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock_quantity }}"
                               class="w-12 sm:w-16 text-center py-3 border-x border-gray-300 text-sm font-semibold focus:outline-none">
                        <button type="button" onclick="adjustQty(1)" class="px-3 sm:px-4 py-3 text-gray-600 hover:bg-gray-50 font-semibold text-base">+</button>
                    </div>
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-3 px-4 sm:px-6 rounded-xl font-semibold hover:bg-indigo-700 active:scale-95 transition-all duration-150 flex items-center justify-center gap-2 text-sm sm:text-base">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Add to Cart
                    </button>
                </div>
            </form>
            @else
            <button disabled class="w-full bg-gray-200 text-gray-500 py-3 px-6 rounded-xl font-semibold cursor-not-allowed text-sm sm:text-base">
                Out of Stock — Check Back Soon
            </button>
            @endif

            {{-- Trust Badges --}}
            <div class="mt-6 sm:mt-8 grid grid-cols-3 gap-3 sm:gap-4 border-t border-gray-100 pt-5 sm:pt-6">
                <div class="text-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <p class="text-xs text-gray-500 font-medium">Secure</p>
                </div>
                <div class="text-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    <p class="text-xs text-gray-500 font-medium">Free Returns</p>
                </div>
                <div class="text-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <p class="text-xs text-gray-500 font-medium">Invoice</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Related Products --}}
    @if($related->isNotEmpty())
    <div class="mt-12 sm:mt-16">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-5 sm:mb-6">You Might Also Like</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @foreach($related as $rp)
            <a href="{{ route('shop.show', $rp) }}" class="bg-white rounded-xl border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                <div class="h-32 sm:h-40 bg-gray-100 overflow-hidden">
                    @if($rp->image_url)
                    <img src="{{ $rp->image_url }}" alt="{{ $rp->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @endif
                </div>
                <div class="p-3 sm:p-4">
                    <p class="text-xs sm:text-sm font-semibold text-gray-900 line-clamp-2 leading-tight">{{ $rp->name }}</p>
                    <p class="text-sm font-bold text-indigo-600 mt-1">${{ number_format($rp->price, 2) }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function adjustQty(delta) {
    const el = document.getElementById('qty');
    const max = parseInt(el.max);
    const newVal = Math.min(Math.max(1, parseInt(el.value) + delta), max);
    el.value = newVal;
}
</script>
@endpush
