<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20)->withQueryString();
        $statusFilter = $request->status;

        return view('admin.orders.index', compact('orders', 'statusFilter'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function downloadInvoice(Order $order)
    {
        if (!$order->isPaid()) {
            return back()->with('error', 'Invoice only available for paid orders.');
        }

        return $this->invoiceService->getDownloadResponse($order);
    }
}
