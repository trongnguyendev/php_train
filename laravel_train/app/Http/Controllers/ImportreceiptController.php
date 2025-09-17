<?php

namespace App\Http\Controllers;

use App\Models\Importreceipt;
use App\Models\Warehouses;
use App\Models\Products;
use Illuminate\Http\Request;

class ImportreceiptController extends Controller
{
    /**
     * Hiển thị danh sách phiếu nhập
     */
    public function index()
    {
     
        $receipts = Importreceipt::with('warehouse', 'products')->get();
        return view('importreceipts.index', compact('receipts'));
    }


    /**
     * Form tạo phiếu nhập mới
     */
    public function create()
    {
        $warehouses = Warehouses::all();
        $products = Products::all();
        return view('importreceipts.create', compact('warehouses', 'products'));
    }

    /**
     * Lưu phiếu nhập mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'code' => 'required|unique:importreceipts,code',
            'received_at' => 'required|date',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $receipt = Importreceipt::create([
            'warehouse_id' => $validated['warehouse_id'],
            'code' => $validated['code'],
            'received_at' => $validated['received_at'],
        ]);

        foreach ($validated['products'] as $product) {
            $receipt->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return redirect()->route('importreceipts.index')->with('success', 'Tạo phiếu nhập thành công');
    }

    /**
     * Hiển thị chi tiết phiếu nhập
     */
    public function show(Importreceipt $importreceipt)
    {
        $importreceipt->load('warehouse', 'products');
        return view('importreceipts.show', compact('importreceipt'));
    }

    /**
     * Form chỉnh sửa phiếu nhập
     */
    public function edit(Importreceipt $importreceipt)
    {
        $warehouses = Warehouses::all();
        $products = Products::all();
        $importreceipt->load('products');
        return view('importreceipts.edit', compact('importreceipt', 'warehouses', 'products'));
    }

    /**
     * Cập nhật phiếu nhập
     */
    public function update(Request $request, Importreceipt $importreceipt)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'code' => 'required|unique:importreceipts,code,' . $importreceipt->id,
            'received_at' => 'required|date',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Cập nhật phiếu nhập
        $importreceipt->update([
            'warehouse_id' => $validated['warehouse_id'],
            'code' => $validated['code'],
            'received_at' => $validated['received_at'],
        ]);

        // Xóa sản phẩm cũ và gắn lại
        $importreceipt->products()->detach();
        foreach ($validated['products'] as $product) {
            $importreceipt->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        return redirect()->route('importreceipts.index')->with('success', 'Cập nhật phiếu nhập thành công');
    }

    /**
     * Xóa phiếu nhập
     */
    public function destroy(Importreceipt $importreceipt)
    {
        $importreceipt->delete();
        return redirect()->route('importreceipts.index')->with('success', 'Xóa phiếu nhập thành công');
    }
}
