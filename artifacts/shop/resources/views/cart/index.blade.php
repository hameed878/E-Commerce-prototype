@extends('layouts.app')
@section('title', 'Your Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Your Shopping Cart</h1>

    @if(empty($cart))
    <div class="text-center py-24 bg-white rounded-2xl border border-gray-100 shadow-sm">
        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Your cart is empty</h2>
        <p class="text-gray-500 mb-6">Looks like you haven't added anything yet.</p>
        <a href="{{ route('shop.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-colors">
            Start Shopping
        </a>
    </div>
    @else
    <div class="flex flex-col lg:flex-row gap-8">
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
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex gap-5 items-center">
                {{-- Image --}}
                <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0">
                    @if($item['image_url'])
                    <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    @endif
                </div>

                {{-- Details --}}
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-gray-900 truncate">{{ $item['name'] }}</h3>
                    <p class="text-sm text-gray-500">${{ number_format($item['price'], 2) }} each</p>
                </div>

                {{-- Qty Controls --}}
                <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="flex items-center gap-1">
                    @csrf @method('PATCH')
                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                        <button type="button" onclick="changeQty(this, -1)" class="px-3 py-2 text-gray-500 hover:bg-gray-50 text-sm font-bold">−</button>
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock_quantity'] }}"
                               class="w-12 text-center text-sm font-semibold border-x border-gray-200 py-2 focus:outline-none" readonly>
                        <button type="button" onclick="changeQty(this, 1)" class="px-3 py-2 text-gray-500 hover:bg-gray-50 text-sm font-bold">+</button>
                    </div>
                    <button type="submit" class="ml-2 text-xs text-indigo-600 hover:underline">Update</button>
                </form>

                {{-- Subtotal --}}
                <div class="text-right w-24 flex-shrink-0">
                    <p class="font-bold text-gray-900">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                </div>

                {{-- Remove --}}
                <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
            @endforeach

            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 text-indigo-600 hover:underline text-sm mt-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Continue Shopping
            </a>
        </div>

        {{-- Order Summary --}}
        <div class="w-full lg:w-80 flex-shrink-0">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-20">
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
                <form action="{{ route('checkout.create') }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="w-full bg-indigo-600 text-white py-3.5 rounded-xl font-semibold hover:bg-indigo-700 active:scale-95 transition-all duration-150 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Checkout with Stripe
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="mt-6 w-full bg-indigo-600 text-white py-3.5 rounded-xl font-semibold hover:bg-indigo-700 transition-colors flex items-center justify-center gap-2">
                    Sign In to Checkout
                </a>
                @endauth

                <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Secured by Stripe
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
