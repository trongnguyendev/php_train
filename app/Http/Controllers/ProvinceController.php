<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $province = Province::all();
        return view('provinces.index', compact('province'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('provinces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Tên Tỉnh không được để trống!'
        ]);

        $province = Province::create([
            'name' => $request->name
        ]);

        return redirect()->route('provinces.index')->with('success', 'Tạo tỉnh thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Province $province)
    {
        return view('provinces.show', compact('province'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        return view('provinces.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Tên Tỉnh không được để trống!'
        ]);

        $province->update([
            'name' => $request->name
        ]);

        return redirect()->route('provinces.index')->with('success', 'Cập nhập tên tỉnh thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        $province->delete();
        return redirect()->route('provinces.index')->with('success', 'Xóa tên tỉnh thành công!');
    }
}
