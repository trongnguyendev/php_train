<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(30);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.edit', [
            'product' => new Product(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Đã thêm sản phẩm.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);

        $product->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Đã cập nhật sản phẩm.');
    }

    public function destroy(Product $product)
    {
        $product->update([
            'is_active' => false,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Đã ngừng bán sản phẩm.');
    }
}