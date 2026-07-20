<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    const TAX_RATE = 0.10;
    const SHIPPING_FEE = 5.00;

    public function index()
    {
        $cart = session('cart', []);
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = round($subtotal * self::TAX_RATE, 2);
        $shipping = count($cart) > 0 ? self::SHIPPING_FEE : 0;
        $total = $subtotal + $tax + $shipping;

        return view('cart.index', compact('cart', 'subtotal', 'tax', 'shipping', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:100']);

        if (!$product->isInStock()) {
            return back()->with('error', 'Sorry, this product is out of stock.');
        }

        $cart = session('cart', []);
        $quantity = (int) $request->quantity;
        $id = $product->id;

        if (isset($cart[$id])) {
            $newQty = $cart[$id]['quantity'] + $quantity;
            if ($newQty > $product->stock_quantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cart[$id]['quantity'] = $newQty;
        } else {
            if ($quantity > $product->stock_quantity) {
                return back()->with('error', 'Not enough stock available.');
            }
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float) $product->price,
                'image_url' => $product->image_url,
                'quantity' => $quantity,
                'stock_quantity' => $product->stock_quantity,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', "\"{$product->name}\" added to cart.");
    }

    public function update(Request $request, int $productId)
    {
        $request->validate(['quantity' => 'required|integer|min:1|max:100']);

        $cart = session('cart', []);

        if (!isset($cart[$productId])) {
            return back()->with('error', 'Item not found in cart.');
        }

        $product = Product::findOrFail($productId);
        $quantity = (int) $request->quantity;

        if ($quantity > $product->stock_quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart[$productId]['quantity'] = $quantity;
        $cart[$productId]['stock_quantity'] = $product->stock_quantity;
        session(['cart' => $cart]);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(int $productId)
    {
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared.');
    }
}
