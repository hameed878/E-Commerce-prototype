<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class OrderConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Your ShopWave Order #{$this->order->id} is Confirmed!",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-confirmed',
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        if ($this->order->invoice_path && Storage::disk('local')->exists($this->order->invoice_path)) {
            $attachments[] = Attachment::fromStorage($this->order->invoice_path)
                ->as("Invoice-Order-{$this->order->id}.pdf")
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
