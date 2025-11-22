<?php

namespace App\Http\Controllers;

use App\Models\CustomerSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CustomerSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customerSource = CustomerSource::all();
        return view('customer_sources.index', compact('customerSource'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer_sources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Tình trạng khách hàng không được để trống!'
        ]);

        $customerSource = CustomerSource::create([
             'name' => $request->name
        ]
        );

        return redirect()->route('customer_sources.index')->with('success', 'Tạo tình trạng khách hàng thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerSource $customerSource)
    {
        return view('customer_sources.show', compact('customerSource'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerSource $customerSource)
    {
        return view('customer_sources.edit', compact('customerSource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerSource $customerSource)
    {
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Tình trạng khách hàng không được để trống!'
        ]);

        $customerSource->update([
            'name' => $request->name
        ]);

        return redirect()->route('customer_sources.index')->with('success', 'Cập nhập tình trạng khách hàng thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerSource $customerSource)
    {
        $customerSource->delete();
        return redirect()->route('customer_sources.index')->with('success', 'Xóa tình trạng khách hàng thành công!');
    }
}
