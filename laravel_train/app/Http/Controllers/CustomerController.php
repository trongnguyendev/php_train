<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Province;
use App\Models\TypeCustomer;
use App\Models\TypeShowroom;
use App\Models\Category;
use App\Models\Status;
use App\Models\Salename;
use App\Models\Source;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Danh sách khách hàng
     */
    public function index()
    {
        $customer = Customer::with([
            'province',
            'typeCustomerYet',
            'typeCustomer',
            'typeShowroom',
            'category',
            'statusFirst',
            'currentStatus',
            'salenameInfor',
            'salenameSupport',
            'cateloryProduct',
            'source'
        ])->latest()->paginate(20);

        return view('customer.index', compact('customer'));
    }

    /**
     * Form thêm mới
     */
    public function create()
    {
        $provinces = Province::all();
        $typeCustomer = TypeCustomer::all();
        $typeShowroom = TypeShowroom::all();
        $category = Category::all();
        $status = Status::all();
        $salename = Salename::all();
        $source = Source::all();

        return view('customer.create', compact(
            'provinces',
            'typeCustomer',
            'typeShowroom',
            'category',
            'status',
            'salename',
            'source'
        ));
    }

    /**
     * Lưu mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_for_showroom' => 'nullable|date',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'province_id' => 'nullable|exists:provinces,id',
            'address' => 'nullable|string',
            'zalo_feedback' => 'nullable|string|max:255',
            'type_customer_yet_id' => 'nullable|exists:type_customers,id',
            'type_customer_id' => 'nullable|exists:type_customers,id',
            'type_showroom_id' => 'nullable|exists:type_showrooms,id',
            'type_category_id' => 'nullable|exists:categories,id',
            'status_first_id' => 'nullable|exists:statuses,id',
            'note_sale' => 'nullable|string|max:255',
            'salename_infor_id' => 'nullable|exists:sale_names,id',
            'salename_support_id' => 'nullable|exists:sale_names,id',
            'current_status_id' => 'nullable|exists:statuses,id',
            'order_value' => 'nullable|numeric',
            'customer_support_yet_id' => 'nullable|exists:sources,id',
        ]);

        Customer::create($request->all());

        return redirect()->route('customer.index')->with('success', 'Thêm khách hàng thành công!');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(Customer $customer)
    {
        $provinces = Province::all();
        $typeCustomer = TypeCustomer::all();
        $typeShowroom = TypeShowroom::all();
        $category = Category::all();
        $status = Status::all();
        $salename = Salename::all();
        $source = Source::all();

        return view('customer.edit', compact(
            'customer',
            'provinces',
            'typeCustomer',
            'typeShowroom',
            'category',
            'status',
            'salename',
            'source'
        ));
    }

    /**
     * Cập nhật
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'customer_for_showroom' => 'required|date',
            'name' => 'required|string',
            'phone' => 'required|string',
        ], [
            'customer_for_showroom.required' => 'Ngày không được để trống',
            'name.required' => 'Tên không được để trống',
            'phone.required' => 'Số Điện Thoại không được để trống',
        ]);

        $customer->update([
            'customer_for_showroom'   => $request->customer_for_showroom,
            'name'                    => $request->name,
            'phone'                   => $request->phone,
            'province_id'             => $request->province_id,
            'address'                 => $request->address,
            'zalo_feedback'           => $request->zalo_feedback, // nhớ sửa lại key, form bạn đặt là zalo_feedback
            'type_customer_yet_id'    => $request->type_customer_yet_id,
            'type_customer_id'        => $request->type_customer_id,
            'type_showroom_id'        => $request->type_showroom_id,
            'type_category_id'        => $request->type_category_id,
            'status_first_id'         => $request->status_first_id,
            'note_sale'               => $request->note_sale,
            'salename_infor_id'       => $request->salename_infor_id,
            'salename_support_id'     => $request->salename_support_id,
            'current_status_id'       => $request->current_status_id,
            'order_value'             => $request->order_value,
            'customer_support_yet_id' => $request->customer_support_yet_id,
        ]);

        return redirect()
            ->route('customer.index')
            ->with('success', 'Cập nhật khách hàng thành công!');
    }

    /**
     * Xóa
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Xóa khách hàng thành công!');
    }
}
