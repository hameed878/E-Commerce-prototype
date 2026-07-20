<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;

class CheckoutController extends Controller
{
    const TAX_RATE = 0.10;
    const SHIPPING_FEE = 5.00;

    public function create(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate stock availability
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product || !$product->isInStock() || $product->stock_quantity < $item['quantity']) {
                return redirect()->route('cart.index')->with('error', "\"" . $item['name'] . "\" does not have enough stock.");
            }
        }

        $subtotal = collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']);
        $tax = round($subtotal * self::TAX_RATE, 2);
        $shipping = self::SHIPPING_FEE;
        $total = $subtotal + $tax + $shipping;

        // Create a pending order in the DB
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'total' => $total,
        ]);

        foreach ($cart as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        // Build Stripe line items
        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
        foreach ($cart as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item['name'],
                        'images' => $item['image_url'] ? [$item['image_url']] : [],
                    ],
                    'unit_amount' => (int) round($item['price'] * 100),
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // Add tax as a line item
        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => 'Tax (10%)'],
                'unit_amount' => (int) round($tax * 100),
            ],
            'quantity' => 1,
        ];

        // Add shipping as a line item
        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => 'Shipping'],
                'unit_amount' => (int) round($shipping * 100),
            ],
            'quantity' => 1,
        ];

        try {
            $checkoutSession = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'customer_email' => auth()->user()->email,
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout.cancel'),
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => auth()->id(),
                ],
            ]);

            $order->update(['stripe_session_id' => $checkoutSession->id]);

            return redirect($checkoutSession->url);
        } catch (ApiErrorException $e) {
            $order->update(['status' => 'failed']);
            return redirect()->route('cart.index')->with('error', 'Payment initiation failed: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $order = null;

        if ($sessionId) {
            $order = Order::where('stripe_session_id', $sessionId)
                ->where('user_id', auth()->id())
                ->with('items')
                ->first();
        }

        return view('checkout.success', compact('order'));
    }

    public function cancel(Request $request)
    {
        return view('checkout.cancel');
    }
}
