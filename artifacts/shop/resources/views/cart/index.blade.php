@extends('layouts.app')
@section('title', 'Your Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6 sm:mb-8">Your Shopping Cart</h1>

    @if(empty($cart))
    <div class="text-center py-20 bg-white rounded-2xl border border-gray-100 shadow-sm">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h2>
        <p class="text-gray-500 mb-6">Looks like you haven't added anything yet.</p>
        <a href="{{ route('shop.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-colors">
            Start Shopping
        </a>
    </div>
    @else
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">

        {{-- Cart Items --}}
        <div class="flex-1 space-y-3">
            <div class="flex justify-between items-center mb-2">
                <p class="text-sm text-gray-500">{{ count($cart) }} {{ Str::plural('item', count($cart)) }} in your cart</p>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-sm text-red-500 hover:text-red-700 hover:underline">Clear cart</button>
                </form>
            </div>

            @foreach($cart as $item)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5">
                {{-- Mobile: image + name + price + remove on one row --}}
                <div class="flex gap-4 items-start">
                    {{-- Image --}}
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                        @if($item['image_url'])
                        <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        @endif
                    </div>

                    {{-- Details + Controls --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <h3 class="font-semibold text-gray-900 text-sm sm:text-base leading-tight">{{ $item['name'] }}</h3>
                                <p class="text-sm text-gray-500 mt-0.5">${{ number_format($item['price'], 2) }} each</p>
                            </div>
                            {{-- Remove button --}}
                            <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="flex-shrink-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1 -mt-1 -mr-1">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>

                        {{-- Qty + Subtotal row --}}
                        <div class="flex items-center justify-between mt-3 gap-3">
                            <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                    <button type="button" onclick="changeQty(this, -1)" class="px-2.5 py-1.5 text-gray-500 hover:bg-gray-50 text-base font-bold leading-none">−</button>
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock_quantity'] }}"
                                           class="w-10 text-center text-sm font-semibold border-x border-gray-200 py-1.5 focus:outline-none" readonly>
                                    <button type="button" onclick="changeQty(this, 1)" class="px-2.5 py-1.5 text-gray-500 hover:bg-gray-50 text-base font-bold leading-none">+</button>
                                </div>
                                <button type="submit" class="text-xs text-indigo-600 hover:underline font-medium">Update</button>
                            </form>
                            <p class="font-bold text-gray-900 text-sm sm:text-base">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:underline text-sm mt-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Continue Shopping
            </a>
        </div>

        {{-- Order Summary --}}
        <div class="w-full lg:w-80 flex-shrink-0">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-6 lg:sticky lg:top-20">
                <h2 class="text-lg font-bold text-gray-900 mb-5">Order Summary</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Tax (10%)</span>
                        <span>${{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping</span>
                        <span>${{ number_format($shipping, 2) }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between font-bold text-gray-900 text-base">
                        <span>Grand Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                @auth
                <form action="{{ route('checkout.create') }}" method="POST" class="mt-5">
                    @csrf
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-semibold hover:bg-indigo-700 active:scale-95 transition-all duration-150 flex items-center justify-center gap-2 text-sm sm:text-base">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Checkout with Stripe
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="mt-5 w-full bg-indigo-600 text-white py-3.5 rounded-xl font-semibold hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2 text-sm sm:text-base">
                    Sign In to Checkout
                </a>
                @endauth

                <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Secured by Stripe
                </div>

                {{-- Trust badges --}}
                <div class="mt-4 grid grid-cols-3 gap-2 border-t border-gray-100 pt-4">
                    <div class="text-center">
                        <svg class="w-5 h-5 text-green-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <p class="text-xs text-gray-400">Secure</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-5 h-5 text-blue-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        <p class="text-xs text-gray-400">Returns</p>
                    </div>
                    <div class="text-center">
                        <svg class="w-5 h-5 text-purple-500 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <p class="text-xs text-gray-400">Invoice</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function changeQty(btn, delta) {
    const input = btn.closest('.flex').querySelector('input[type="number"]');
    const max = parseInt(input.max);
    const newVal = Math.min(Math.max(1, parseInt(input.value) + delta), max);
    input.value = newVal;
}
</script>
@endpush
