<?php

namespace App\Http\Controllers;

use App\Models\Warehouses; // bạn đang dùng model tên Warehouses
use Illuminate\Http\Request;

class WarehousesController extends Controller
{
    /**
     * Hiển thị danh sách kho hàng
     */
    public function index()
    {
        $warehouses = Warehouses::all();
        return view('warehouses.index', compact('warehouses'));
    }

    /**
     * Form tạo kho hàng mới
     */
    public function create()
    {
        return view('warehouses.create');
    }

    /**
     * Lưu kho hàng mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string'
        ], [
            'name.required' => 'Tên kho không được để trống',
            'location.required' => 'Vị trí kho không được để trống'
        ]);

        Warehouses::create($request->only(['name', 'location']));

        return redirect()->route('warehouses.index')->with('success', 'Tạo kho thành công');
    }

    /**
     * Hiển thị chi tiết kho
     */
    public function show(Warehouses $warehouse)
    {
        return view('warehouses.show', compact('warehouse'));
    }

    /**
     * Form chỉnh sửa kho
     */
    public function edit(Warehouses $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    /**
     * Cập nhật kho
     */
    public function update(Request $request, Warehouses $warehouse)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string'
        ], [
            'name.required' => 'Tên kho không được để trống',
            'location.required' => 'Vị trí kho không được để trống'
        ]);

        $warehouse->update($request->only(['name', 'location']));

        return redirect()->route('warehouses.index')->with('success', 'Cập nhật kho thành công');
    }

    /**
     * Xóa kho
     */
    public function destroy(Warehouses $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('success', 'Xóa kho thành công!');
    }
}
