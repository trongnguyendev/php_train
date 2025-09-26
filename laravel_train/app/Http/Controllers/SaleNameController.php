<?php

namespace App\Http\Controllers;

use App\Models\SaleName;
use Illuminate\Http\Request;

class SaleNameController extends Controller
{
    public function index()
    {
        $saleNames = SaleName::all();
        return view('salename.index', compact('saleNames'));
    }

    public function create()
    {
        return view('salename.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sale_names,name'
        ]);

        SaleName::create($request->only('name'));

        return redirect()->route('salename.index')->with('success', 'Tên Sale đã được thêm!');
    }

    public function show(SaleName $salename)
    {
        return view('salename.show', compact('salename'));
    }

    public function edit(SaleName $salename)
    {
        return view('salename.edit', compact('salename'));
    }

    public function update(Request $request, SaleName $salename)
    {
        $request->validate([
            'name' => 'required|unique:sale_names,name,' . $salename->id
        ]);

        $salename->update($request->only('name'));

        return redirect()->route('salename.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(SaleName $salename)
    {
        $salename->delete();
        return redirect()->route('salename.index')->with('success', 'Xóa thành công!');
    }
}
