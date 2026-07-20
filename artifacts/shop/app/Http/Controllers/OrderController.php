<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items.product');

        return view('orders.show', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        $this->authorize('view', $order);

        if (!$order->isPaid()) {
            return back()->with('error', 'Invoice is only available for paid orders.');
        }

        return $this->invoiceService->getDownloadResponse($order);
    }
}
