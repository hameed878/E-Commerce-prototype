<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'nullable|exists:categories,id',
            'description'    => 'required|string',
            'price'          => 'required|numeric|min:0',
            'image_url'      => 'nullable|url|max:500',
            'image_file'     => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'stock_quantity' => 'required|integer|min:0',
            'is_active'      => 'boolean',
        ]);

        $validated['slug']      = Str::slug($validated['name']) . '-' . Str::random(5);
        $validated['is_active'] = $request->boolean('is_active');

        // File upload takes priority over URL
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        unset($validated['image_file']);

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'nullable|exists:categories,id',
            'description'    => 'required|string',
            'price'          => 'required|numeric|min:0',
            'image_url'      => 'nullable|url|max:500',
            'image_file'     => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'stock_quantity' => 'required|integer|min:0',
            'is_active'      => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        // File upload takes priority over URL
        if ($request->hasFile('image_file')) {
            // Delete old uploaded image if it was stored locally
            if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $product->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image_file')->store('products', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        unset($validated['image_file']);

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Clean up uploaded image if stored locally
        if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $product->image_url);
            Storage::disk('public')->delete($oldPath);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
