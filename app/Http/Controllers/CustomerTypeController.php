<?php

namespace App\Http\Controllers;

use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', CustomerType::class);
        $customerType = CustomerType::all();
        return view('customer_types.index', compact('customerType'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', CustomerType::class);
        return view('customer_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', CustomerType::class);
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Loại khách hàng không được để trống'
        ]);

        $customerType = CustomerType::create([
            'name' => $request->name
        ]);

        return redirect()->route('customer_types.index')->with('success', 'Tạo loại khách hàng thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerType $customerType)
    {
        Gate::authorize('view', $customerType);
        return view('customer_types.show', compact('customerType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerType $customerType)
    {
        Gate::authorize('update', $customerType);
        return view('customer_types.edit', compact('customerType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerType $customerType)
    {
        Gate::authorize('update', $customerType);
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Loại khách hàng không được để trống!'
        ]);

        $customerType->update([
            'name' => $request->name
        ]);

        return redirect()->route('customer_types.index')->with('success', 'Cập nhập loại khách hàng thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerType $customerType)
    {
    Gate::authorize('delete', $customerType);
    $customerType->delete();
    return redirect()->route('customer_types.index')->with('success', 'Xóa loại khách hàng thành công!');
    }
}
