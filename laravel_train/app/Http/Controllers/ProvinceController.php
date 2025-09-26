<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        return view('province.index', compact('provinces'));
    }

    public function create()
    {
        return view('province.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:provinces,name'
        ]);

        Province::create($request->only('name'));

        return redirect()->route('province.index')->with('success', 'Tỉnh/Thành phố đã được thêm!');
    }

    public function edit(Province $province)
    {
        return view('province.edit', compact('province'));
    }

    public function update(Request $request, Province $province)
    {
        $request->validate([
            'name' => 'required|unique:provinces,name,' . $province->id
        ]);

        $province->update($request->only('name'));

        return redirect()->route('province.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(Province $province)
    {
        $province->delete();
        return redirect()->route('province.index')->with('success', 'Xóa thành công!');
    }

}
