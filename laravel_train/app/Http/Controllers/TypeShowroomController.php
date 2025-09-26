<?php

namespace App\Http\Controllers;

use App\Models\TypeShowroom;
use Illuminate\Http\Request;

class TypeShowroomController extends Controller
{
    public function index()
    {
        $typeShowrooms = TypeShowroom::all();
        return view('type_showroom.index', compact('typeShowrooms'));
    }

    public function create()
    {
        return view('type_showroom.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:type_showrooms,name'
        ]);

        TypeShowroom::create($request->only('name'));

        return redirect()->route('type_showroom.index')->with('success', 'Thêm loại showroom thành công!');
    }

    public function show(TypeShowroom $typeShowroom)
    {
        return view('type_showroom.show', compact('typeShowroom'));
    }

    public function edit(TypeShowroom $typeShowroom)
    {
        return view('type_showroom.edit', compact('typeShowroom'));
    }

    public function update(Request $request, TypeShowroom $typeShowroom)
    {
        $request->validate([
            'name' => 'required|unique:type_showrooms,name,' . $typeShowroom->id
        ]);

        $typeShowroom->update($request->only('name'));

        return redirect()->route('type_showroom.index')->with('success', 'Cập nhật loại showroom thành công!');
    }

    public function destroy(TypeShowroom $typeShowroom)
    {
        $typeShowroom->delete();
        return redirect()->route('type_showroom.index')->with('success', 'Xóa loại showroom thành công!');
    }
}
