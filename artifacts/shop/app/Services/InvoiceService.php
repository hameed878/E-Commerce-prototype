<?php

namespace App\Services;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    public function generate(Order $order): string
    {
        $order->load(['user', 'items.product']);

        $pdf = Pdf::loadView('invoices.invoice', compact('order'));
        $pdf->setPaper('A4', 'portrait');

        $filename = "invoices/invoice-{$order->id}-" . time() . ".pdf";

        Storage::disk('local')->put($filename, $pdf->output());

        return $filename;
    }

    public function getDownloadResponse(Order $order)
    {
        if (!$order->invoice_path || !Storage::disk('local')->exists($order->invoice_path)) {
            $order->invoice_path = $this->generate($order);
            $order->save();
        }

        $filename = "Invoice-Order-{$order->id}.pdf";

        return response()->download(
            Storage::disk('local')->path($order->invoice_path),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }
}
