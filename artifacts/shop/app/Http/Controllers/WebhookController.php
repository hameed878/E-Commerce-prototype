<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmedMail;
use App\Models\Order;
use App\Models\Product;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class WebhookController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature.'], 400);
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe webhook invalid payload.', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid payload.'], 400);
        }

        match ($event->type) {
            'checkout.session.completed' => $this->handleCheckoutSessionCompleted($event->data->object),
            'payment_intent.payment_failed' => $this->handlePaymentFailed($event->data->object),
            default => Log::info('Unhandled Stripe event: ' . $event->type),
        };

        return response()->json(['status' => 'ok']);
    }

    private function handleCheckoutSessionCompleted(object $session): void
    {
        $order = Order::with(['user', 'items.product'])
            ->where('stripe_session_id', $session->id)
            ->first();

        if (!$order) {
            Log::error('Order not found for Stripe session: ' . $session->id);
            return;
        }

        if ($order->isPaid()) {
            Log::info('Order already paid, skipping: ' . $order->id);
            return;
        }

        // Decrement stock for each item
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->decrementStock($item->quantity);
            }
        }

        // Generate PDF invoice
        try {
            $invoicePath = $this->invoiceService->generate($order);
            $order->update([
                'status' => 'paid',
                'invoice_path' => $invoicePath,
                'paid_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Invoice generation failed for order ' . $order->id . ': ' . $e->getMessage());
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }

        // Send confirmation email
        try {
            Mail::to($order->user->email)->send(new OrderConfirmedMail($order));
        } catch (\Exception $e) {
            Log::error('Order confirmation email failed for order ' . $order->id . ': ' . $e->getMessage());
        }

        // Clear the user's cart (best-effort, cart stored in session so may already be gone)
        Log::info('Order ' . $order->id . ' marked as paid successfully.');
    }

    private function handlePaymentFailed(object $paymentIntent): void
    {
        Log::warning('Payment failed for payment intent: ' . $paymentIntent->id);
    }
}
