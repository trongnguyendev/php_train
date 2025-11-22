<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\SaleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SaleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', SaleUser::class);
        $saleUser = SaleUser::all();
        return view('sale_users.index', compact('saleUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', SaleUser::class);
        return view('sale_users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', SaleUser::class);
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Tên sale không được để trống!'
        ]);

        $saleUser = SaleUser::create([
            'name' => $request->name
        ]);

        return redirect()->route('sale_users.index')->with('success', 'Tạo tên sale thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleUser $saleUser)
    {
        Gate::authorize('view', $saleUser);
        return view('sale_users.show', compact('saleUser'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleUser $saleUser)
    {
        Gate::authorize('update', $saleUser);
        return view('sale_users.edit', compact('saleUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaleUser $saleUser)
    {
        Gate::authorize('update', $saleUser);
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Tên sale không được để trống!'
        ]);

        $saleUser->update([
            'name' => $request->name
        ]);

        return redirect()->route('sale_users.index')->with('success', 'Cập nhập tên sale thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleUser $saleUser)
    {
        Gate::authorize('delete', $saleUser);
        $saleUser->delete();
        return redirect()->route('sale_users.index')->with('success', 'Xóa tên sale thành công!');
    }
}
        return view('sale_users.edit', compact('saleUser'));
