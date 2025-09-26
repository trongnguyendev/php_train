<?php

namespace App\Http\Controllers;

use App\Models\TypeCustomer;
use Illuminate\Http\Request;

class TypeCustomerController extends Controller
{
    public function index()
    {
        $typeCustomers = TypeCustomer::all();
        return view('type_customer.index', compact('typeCustomers'));
    }

    public function create()
    {
        return view('type_customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:type_customers,name'
        ]);

        TypeCustomer::create($request->only('name'));

        return redirect()->route('type_customer.index')->with('success', 'Thêm loại khách hàng thành công!');
    }

    public function show(TypeCustomer $typeCustomer)
    {
        return view('type_customer.show', compact('typeCustomer'));
    }

    public function edit(TypeCustomer $typeCustomer)
    {
        return view('type_customer.edit', compact('typeCustomer'));
    }

    public function update(Request $request, TypeCustomer $typeCustomer)
    {
        $request->validate([
            'name' => 'required|unique:type_customers,name,' . $typeCustomer->id
        ]);

        $typeCustomer->update($request->only('name'));

        return redirect()->route('type_customer.index')->with('success', 'Cập nhật loại khách hàng thành công!');
    }

    public function destroy(TypeCustomer $typeCustomer)
    {
        $typeCustomer->delete();
        return redirect()->route('type_customer.index')->with('success', 'Xóa loại khách hàng thành công!');
    }
}
