<?php

namespace App\Http\Controllers;

use App\Models\CustomerStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Showroom::class);
        $customerStatus = CustomerStatus::all();
        return view('customer_status.index', compact('customerStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', CustomerStatus::class);
        return view('customer_status.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', CustomerStatus::class);
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Trạng thái không được để trống!'
        ]);

        $customerStatus = CustomerStatus::create([
            'name' => $request->name
        ]);

        return redirect()->route('customer_status.index')->with('success', 'Tạo trạng thái thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerStatus $customerStatus)
    {
        Gate::authorize('view', $customerStatus);
        return view('customer_status.show', compact('customerStatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerStatus $customerStatus)
    {
        Gate::authorize('update', $customerStatus);
        return view('customer_status.edit', compact('customerStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerStatus $customerStatus)
    {
        Gate::authorize('update', $customerStatus);
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Trạng thái không được để trống!'
        ]);

        $customerStatus->update([
            'name' => $request->name
        ]);

        return redirect()->route('customer_status.index')->with('success', 'Cập nhập trạng thái thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerStatus $customerStatus)
    {
        Gate::authorize('delete', $customerStatus);
        $customerStatus->delete();
        return redirect()->route('customer_status.index')->with('success', 'Xóa trạng thái thành công!');
    }
}
