<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategory = ProductCategory::all();
        return view('product_categories.index', compact('productCategory'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Tên không được để trống'
        ]);

        $productCategory = ProductCategory::create([
            'name' => $request->name
        ]);

        return redirect()->route('product_categories.index')->with('success', 'Tạo Showroom thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory)
    {
        return view('product_categories.show', compact('productCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('product_categories.edit', compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Tên danh mục không được để trống!'
        ]);

        $productCategory->update([
            'name' => $request->name
        ]);

        return redirect()->route('product_categories.index')->with('success', 'Cập nhập danh sách sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return redirect()->route('product_categories.index')->with('success', 'Xóa Danh mục thành công!');
    }
    
}
