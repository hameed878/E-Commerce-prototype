@extends('layouts.app')
@section('title', 'Order Confirmed')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Confirmed!</h1>
        <p class="text-gray-500 mb-2">Thank you for shopping with ShopWave.</p>

        @if($order)
        <p class="text-sm text-gray-400 mb-8">Order <span class="font-semibold text-gray-700">#{{ $order->id }}</span> · <span class="font-semibold text-indigo-600">${{ number_format($order->total, 2) }}</span></p>

        <div class="bg-gray-50 rounded-xl p-5 mb-8 text-left">
            <h3 class="font-semibold text-gray-900 mb-3 text-sm">Items Ordered</h3>
            <ul class="space-y-2">
                @foreach($order->items as $item)
                <li class="flex justify-between text-sm text-gray-700">
                    <span>{{ $item->product_name }} <span class="text-gray-400">× {{ $item->quantity }}</span></span>
                    <span class="font-medium">${{ number_format($item->price * $item->quantity, 2) }}</span>
                </li>
                @endforeach
                <li class="border-t border-gray-200 pt-2 flex justify-between text-sm font-bold text-gray-900">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </li>
            </ul>
        </div>
        @else
        <p class="text-sm text-gray-400 mb-8">Your payment was processed successfully.</p>
        @endif

        <div class="bg-indigo-50 rounded-xl p-4 mb-8 text-sm text-indigo-700">
            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            A confirmation email with your PDF invoice has been sent to <strong>{{ auth()->user()->email }}</strong>.
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('orders.index') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-colors">
                View My Orders
            </a>
            <a href="{{ route('shop.index') }}" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-colors">
                Continue Shopping
            </a>
        </div>
    </div>
</div>
@endsection
