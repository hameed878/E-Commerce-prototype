@extends('layouts.app')
@section('title', 'Order #' . $order->id)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('orders.index') }}" class="text-gray-400 hover:text-indigo-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $order->getStatusBadgeClass() }}">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="font-semibold text-gray-900">Items Ordered</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($order->items as $item)
            <div class="px-6 py-4 flex items-center gap-4">
                @if($item->product && $item->product->image_url)
                <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="w-14 h-14 rounded-lg object-cover flex-shrink-0">
                @else
                <div class="w-14 h-14 rounded-lg bg-gray-100 flex-shrink-0"></div>
                @endif
                <div class="flex-1">
                    <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                    <p class="text-sm text-gray-500">${{ number_format($item->price, 2) }} × {{ $item->quantity }}</p>
                </div>
                <p class="font-bold text-gray-900">${{ number_format($item->subtotal(), 2) }}</p>
            </div>
            @endforeach
        </div>
        <div class="px-6 py-5 bg-gray-50 space-y-2">
            <div class="flex justify-between text-sm text-gray-600"><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
            <div class="flex justify-between text-sm text-gray-600"><span>Tax (10%)</span><span>${{ number_format($order->tax, 2) }}</span></div>
            <div class="flex justify-between text-sm text-gray-600"><span>Shipping</span><span>${{ number_format($order->shipping, 2) }}</span></div>
            <div class="flex justify-between font-bold text-gray-900 text-base border-t border-gray-200 pt-2"><span>Total</span><span>${{ number_format($order->total, 2) }}</span></div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
        <h2 class="font-semibold text-gray-900 mb-4">Order Details</h2>
        <dl class="grid grid-cols-2 gap-4 text-sm">
            <div><dt class="text-gray-500">Order Date</dt><dd class="font-medium text-gray-900 mt-1">{{ $order->created_at->format('M j, Y') }}</dd></div>
            <div><dt class="text-gray-500">Payment Status</dt><dd class="font-medium text-gray-900 mt-1">{{ ucfirst($order->status) }}</dd></div>
            @if($order->paid_at)
            <div><dt class="text-gray-500">Paid At</dt><dd class="font-medium text-gray-900 mt-1">{{ $order->paid_at->format('M j, Y g:i A') }}</dd></div>
            @endif
        </dl>
    </div>

    @if($order->isPaid())
    <div class="flex justify-end">
        <a href="{{ route('orders.invoice', $order) }}"
           class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-indigo-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download PDF Invoice
        </a>
    </div>
    @endif
</div>
@endsection
