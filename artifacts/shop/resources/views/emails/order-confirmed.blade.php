<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed — ShopWave</title>
    <style>
        body { margin: 0; padding: 0; background: #f9fafb; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .wrapper { max-width: 600px; margin: 0 auto; padding: 32px 16px; }
        .card { background: #ffffff; border-radius: 16px; overflow: hidden; border: 1px solid #e5e7eb; }
        .header { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 32px; text-align: center; }
        .header-icon { width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 700; margin: 0 0 6px; }
        .header p { color: rgba(255,255,255,0.8); font-size: 14px; margin: 0; }
        .body { padding: 32px; }
        .greeting { font-size: 16px; color: #374151; margin: 0 0 24px; }
        .section-title { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #9ca3af; margin-bottom: 12px; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .items-table th { padding: 10px 12px; background: #f9fafb; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb; }
        .items-table td { padding: 12px; font-size: 13px; color: #374151; border-bottom: 1px solid #f3f4f6; }
        .items-table td:last-child { text-align: right; font-weight: 600; color: #111827; }
        .totals { background: #f9fafb; border-radius: 12px; padding: 16px; margin-bottom: 24px; }
        .total-row { display: flex; justify-content: space-between; font-size: 13px; color: #6b7280; padding: 4px 0; }
        .total-row.grand { font-size: 15px; font-weight: 700; color: #111827; border-top: 1px solid #e5e7eb; padding-top: 12px; margin-top: 8px; }
        .info-box { background: #eff6ff; border-radius: 12px; padding: 16px; margin-bottom: 24px; font-size: 13px; color: #1d4ed8; }
        .btn { display: inline-block; background: #4f46e5; color: #ffffff; text-decoration: none; padding: 14px 28px; border-radius: 12px; font-weight: 600; font-size: 14px; margin-bottom: 24px; }
        .footer { padding: 24px; background: #f9fafb; border-top: 1px solid #e5e7eb; text-align: center; }
        .footer p { font-size: 12px; color: #9ca3af; margin: 4px 0; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="card">
        {{-- Header --}}
        <div class="header">
            <div style="font-size:40px; margin-bottom:12px;">✅</div>
            <h1>Order Confirmed!</h1>
            <p>Your ShopWave order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} has been placed successfully.</p>
        </div>

        {{-- Body --}}
        <div class="body">
            <p class="greeting">Hi {{ $order->user->name }},<br><br>
                Great news! Your payment has been confirmed and your order is being processed. Your PDF invoice is attached to this email.
            </p>

            {{-- Items --}}
            <div class="section-title">Items Ordered</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->subtotal(), 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totals --}}
            <div class="totals">
                <div class="total-row"><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
                <div class="total-row"><span>Tax (10%)</span><span>${{ number_format($order->tax, 2) }}</span></div>
                <div class="total-row"><span>Shipping</span><span>${{ number_format($order->shipping, 2) }}</span></div>
                <div class="total-row grand"><span>Grand Total</span><span>${{ number_format($order->total, 2) }}</span></div>
            </div>

            {{-- Invoice note --}}
            <div class="info-box">
                📎 Your PDF invoice is attached to this email. You can also download it anytime from your account's order history.
            </div>

            <div style="text-align:center">
                <a href="{{ url('/orders/' . $order->id) }}" class="btn">View Order Details</a>
            </div>

            <p style="font-size:13px; color:#6b7280; text-align:center">
                Have a question? Reply to this email or contact us at<br>
                <a href="mailto:support@shopwave.com" style="color:#4f46e5">support@shopwave.com</a>
            </p>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p><strong style="color:#374151">ShopWave</strong></p>
            <p>Payments securely processed by Stripe</p>
            <p style="margin-top:8px">You received this email because you placed an order on ShopWave.</p>
        </div>
    </div>
</div>
</body>
</html>
