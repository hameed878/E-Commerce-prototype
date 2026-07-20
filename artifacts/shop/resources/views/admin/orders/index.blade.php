@extends('layouts.admin')
@section('title', 'Orders')

@section('content')
<div class="flex items-center gap-3 mb-6">
    @foreach(['', 'pending', 'paid', 'failed', 'cancelled'] as $status)
    <a href="{{ route('admin.orders.index', $status ? ['status' => $status] : []) }}"
       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors
              {{ $statusFilter === $status || ($status === '' && !$statusFilter) ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
        {{ $status ? ucfirst($status) : 'All' }}
    </a>
    @endforeach
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if($orders->isEmpty())
    <div class="text-center py-16 text-gray-400 text-sm">No orders found.</div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left">Order #</th>
                    <th class="px-6 py-3 text-left">Customer</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Total</th>
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-indigo-600 hover:underline">#{{ $order->id }}</a>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $order->getStatusBadgeClass() }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right font-bold text-gray-900">${{ number_format($order->total, 2) }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $order->created_at->format('M j, Y') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center gap-2 justify-end">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:underline font-medium text-xs">View</a>
                            @if($order->isPaid())
                            <a href="{{ route('admin.orders.invoice', $order) }}" class="text-gray-500 hover:text-gray-700 font-medium text-xs">Invoice</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $orders->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
