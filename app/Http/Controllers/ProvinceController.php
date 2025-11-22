<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Province::class);
        $province = Province::all();
        return view('provinces.index', compact('province'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Province::class);
         return view('provinces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Province::class);
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
        Gate::authorize('view', $province);
        return view('provinces.show', compact('province'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        Gate::authorize('update', $province);
        return view('provinces.edit', compact('province'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Province $province)
    {
        Gate::authorize('update', $province);
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
        
        Gate::authorize('delete', $province);
        $province->delete();
        return redirect()->route('provinces.index')->with('success', 'Xóa tên tỉnh thành công!');
    }
}
