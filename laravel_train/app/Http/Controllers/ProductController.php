<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductController extends Controller
{
    public function index()
    {
        // $users = User::latest()->paginate(10);
        $products = Products::all();
        return view('products.index', compact('products'));
    }

    /**
     * Hiển thị form tạo user mới
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Lưu user mới vào database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'unique:products,code',
            'price' => 'required|numeric',
        ], [
            'name.required' => 'Tên không được để trống',
            'code.required' => 'Mã sản phẩm không được để trống',
            'code.unique' => 'Code đã tồn tại',
            'price.required' => 'Giá không được để trống',
            'price.number' => 'Giá phải là số'
        ]);

        $products = Products::create([
            'name' => $request->name,
            'code' => $request->code,
            'price' => $request->price,
            'description' => $request->description
        ]);

        return redirect()->route('products.index')->with('success', 'Tạo sản phẩm thành công!');
    }


    /**
     * Hiển thị thông tin chi tiết của user
     */
    public function show(Poducts $products)
    {
        return view('products.show', compact('products'));
    }

    /**
     * Hiển thị form chỉnh sửa user
     */
    public function edit(Products $product)
    {
        return view('products.edit', compact('product'));
    }

     /**
     * Cập nhật thông tin Products
     */
    public function update(Request $request, Products $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // Nếu muốn cho phép giữ nguyên code khi update, phải thêm ignore:
            'code' => 'required|unique:products,code,' . $product->id,
            'price' => 'required|numeric',
        ], [
            'name.required' => 'Tên không được để trống',
            'code.required' => 'Mã sản phẩm không được để trống',
            'code.unique' => 'Code đã tồn tại',
            'price.required' => 'Giá không được để trống',
            'price.number' => 'Giá phải là số'
        ]);

        $product->update([
            'name' => $request->name,
            'code' => $request->code,
            'price' => $request->price,
            'description' => $request->description, // nhớ thêm nếu muốn lưu mô tả
        ]);

        return redirect()->route('products.index')->with('success', 'Cập nhật Sản Phẩm thành công!');
    }

    /**
     * Xóa user
     */
    public function destroy(Products $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Xóa Sản Phẩm thành công!');
    }

}
