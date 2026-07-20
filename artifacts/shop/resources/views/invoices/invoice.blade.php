<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1a1a2e; background: #fff; }
        .container { padding: 40px; max-width: 750px; margin: 0 auto; }

        /* Header */
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; padding-bottom: 24px; border-bottom: 2px solid #4f46e5; }
        .brand { font-size: 24px; font-weight: 700; color: #4f46e5; }
        .brand-sub { font-size: 11px; color: #6b7280; margin-top: 3px; }
        .invoice-meta { text-align: right; }
        .invoice-title { font-size: 20px; font-weight: 700; color: #111827; }
        .invoice-num { font-size: 13px; color: #6b7280; margin-top: 3px; }
        .badge-paid { display: inline-block; background: #d1fae5; color: #065f46; font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.05em; }
        .badge-pending { display: inline-block; background: #fef3c7; color: #92400e; font-size: 10px; font-weight: 700; padding: 3px 10px; border-radius: 20px; margin-top: 6px; text-transform: uppercase; letter-spacing: 0.05em; }

        /* Info Grid */
        .info-grid { display: flex; justify-content: space-between; margin-bottom: 32px; gap: 24px; }
        .info-block { flex: 1; }
        .info-label { font-size: 10px; text-transform: uppercase; letter-spacing: 0.08em; color: #9ca3af; font-weight: 600; margin-bottom: 8px; }
        .info-value { font-size: 12px; color: #374151; line-height: 1.6; }
        .info-value strong { color: #111827; font-weight: 600; }

        /* Table */
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        thead th { background: #f3f4f6; padding: 10px 14px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 0.06em; color: #6b7280; font-weight: 600; }
        thead th:last-child { text-align: right; }
        tbody td { padding: 12px 14px; border-bottom: 1px solid #f3f4f6; font-size: 12px; color: #374151; vertical-align: top; }
        tbody td:last-child { text-align: right; font-weight: 600; color: #111827; }
        tbody tr:last-child td { border-bottom: none; }

        /* Totals */
        .totals { width: 240px; margin-left: auto; }
        .totals table { margin-bottom: 0; }
        .totals td { padding: 6px 14px; border: none; }
        .totals td:first-child { color: #6b7280; }
        .totals td:last-child { text-align: right; font-weight: 600; color: #374151; }
        .totals .grand-total td { padding-top: 10px; border-top: 2px solid #4f46e5; font-size: 14px; font-weight: 700; color: #111827; }

        /* Footer */
        .footer { margin-top: 48px; padding-top: 20px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 10px; color: #9ca3af; }
        .footer a { color: #4f46e5; }
    </style>
</head>
<body>
<div class="container">
    {{-- Header --}}
    <div class="header">
        <div>
            <div class="brand">ShopWave</div>
            <div class="brand-sub">shopwave.com · noreply@shopwave.com</div>
        </div>
        <div class="invoice-meta">
            <div class="invoice-title">INVOICE</div>
            <div class="invoice-num">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            @if($order->isPaid())
            <div class="badge-paid">&#10003; Paid</div>
            @else
            <div class="badge-pending">Pending</div>
            @endif
        </div>
    </div>

    {{-- Info --}}
    <div class="info-grid">
        <div class="info-block">
            <div class="info-label">Bill To</div>
            <div class="info-value">
                <strong>{{ $order->user->name }}</strong><br>
                {{ $order->user->email }}
            </div>
        </div>
        <div class="info-block">
            <div class="info-label">Invoice Details</div>
            <div class="info-value">
                <strong>Invoice #:</strong> {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}<br>
                <strong>Order Date:</strong> {{ $order->created_at->format('M j, Y') }}<br>
                @if($order->paid_at)
                <strong>Paid On:</strong> {{ $order->paid_at->format('M j, Y') }}<br>
                @endif
            </div>
        </div>
        <div class="info-block">
            <div class="info-label">Payment</div>
            <div class="info-value">
                <strong>Method:</strong> Stripe<br>
                <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
                <strong>Currency:</strong> USD
            </div>
        </div>
    </div>

    {{-- Line Items --}}
    <table>
        <thead>
            <tr>
                <th style="width:50%">Description</th>
                <th style="width:15%">Unit Price</th>
                <th style="width:10%">Qty</th>
                <th style="width:25%">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->subtotal(), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Totals --}}
    <div class="totals">
        <table>
            <tbody>
                <tr>
                    <td>Subtotal</td>
                    <td>${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax (10%)</td>
                    <td>${{ number_format($order->tax, 2) }}</td>
                </tr>
                <tr>
                    <td>Shipping</td>
                    <td>${{ number_format($order->shipping, 2) }}</td>
                </tr>
                <tr class="grand-total">
                    <td>Grand Total</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Thank you for your order! Questions? Contact us at <a href="mailto:support@shopwave.com">support@shopwave.com</a></p>
        <p style="margin-top:6px">ShopWave · Payments processed securely by Stripe</p>
    </div>
</div>
</body>
</html>
