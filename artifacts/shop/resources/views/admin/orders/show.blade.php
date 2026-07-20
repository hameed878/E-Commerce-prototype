@extends('layouts.admin')
@section('title', 'Order #' . $order->id)

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Orders
    </a>

    {{-- Header --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <h2 class="text-xl font-bold text-gray-900">Order #{{ $order->id }}</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $order->getStatusBadgeClass() }}">{{ ucfirst($order->status) }}</span>
            </div>
            <p class="text-sm text-gray-500">Placed {{ $order->created_at->format('M j, Y \a\t g:i A') }}</p>
        </div>
        @if($order->isPaid())
        <a href="{{ route('admin.orders.invoice', $order) }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download Invoice PDF
        </a>
        @endif
    </div>

    {{-- Customer --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">
        <h3 class="font-semibold text-gray-900 mb-3">Customer</h3>
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center font-bold text-indigo-600">
                {{ strtoupper(substr($order->user->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-5">
        <div class="px-6 py-5 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Items</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($order->items as $item)
            <div class="px-6 py-4 flex items-center gap-4">
                @if($item->product?->image_url)
                <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="w-14 h-14 rounded-lg object-cover flex-shrink-0">
                @else
                <div class="w-14 h-14 bg-gray-100 rounded-lg flex-shrink-0"></div>
                @endif
                <div class="flex-1">
                    <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} · ${{ number_format($item->price, 2) }} each</p>
                </div>
                <p class="font-bold text-gray-900">${{ number_format($item->subtotal(), 2) }}</p>
            </div>
            @endforeach
        </div>
        <div class="px-6 py-5 bg-gray-50 space-y-2 text-sm">
            <div class="flex justify-between text-gray-600"><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
            <div class="flex justify-between text-gray-600"><span>Tax (10%)</span><span>${{ number_format($order->tax, 2) }}</span></div>
            <div class="flex justify-between text-gray-600"><span>Shipping</span><span>${{ number_format($order->shipping, 2) }}</span></div>
            <div class="flex justify-between font-bold text-gray-900 text-base border-t border-gray-200 pt-2"><span>Grand Total</span><span>${{ number_format($order->total, 2) }}</span></div>
        </div>
    </div>

    {{-- Payment Info --}}
    @if($order->stripe_session_id)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="font-semibold text-gray-900 mb-3">Payment</h3>
        <div class="text-sm text-gray-600 space-y-1">
            <p><span class="font-medium text-gray-700">Stripe Session:</span> <code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs">{{ $order->stripe_session_id }}</code></p>
            @if($order->paid_at)
            <p><span class="font-medium text-gray-700">Paid At:</span> {{ $order->paid_at->format('M j, Y g:i A') }}</p>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
