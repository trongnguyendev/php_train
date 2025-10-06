<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Province;
use App\Models\TypeCustomer;
use App\Models\TypeShowroom;
use App\Models\Category;
use App\Models\Status;
use App\Models\Salename;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    /**
     * Danh sách Lead
     */
    public function index(Request $request)
    {
        $statusList = Status::all();

        $query = Lead::with([
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
        ]);

        if ($request->filled('status_first_id')) {
            $query->where('status_first_id', $request->status_first_id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $lead = $query->latest()->paginate(20);
        $lead->appends($request->all());

        return view('lead.index', compact('lead', 'statusList'));
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

        return view('lead.create', compact(
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
     * Lưu mới Lead
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
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

            // ✅ 6 trường chăm sóc
            'first_care_date' => 'nullable|date',
            'result1' => 'nullable|string|max:255',
            'two_care_date' => 'nullable|date',
            'result2' => 'nullable|string|max:255',
            'three_care_date' => 'nullable|date',
            'result3' => 'nullable|string|max:255',
        ], [
            'customer_for_showroom.required' => 'Ngày không được để trống',
            'name.required' => 'Tên không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
        ]);

        DB::transaction(function () use ($validatedData) {
            Lead::create($validatedData);
        });

        return redirect()->route('lead.index')->with('success', 'Thêm lead thành công!');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(Lead $lead)
    {
        $provinces = Province::all();
        $typeCustomer = TypeCustomer::all();
        $typeShowroom = TypeShowroom::all();
        $category = Category::all();
        $status = Status::all();
        $salename = Salename::all();
        $source = Source::all();

        return view('lead.edit', compact(
            'lead',
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
     * Cập nhật Lead
     */
    public function update(Request $request, Lead $lead)
    {
        $validatedData = $request->validate([
            'customer_for_showroom' => 'required|date',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
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

            // ✅ 6 trường chăm sóc
            'first_care_date' => 'nullable|date',
            'result1' => 'nullable|string|max:255',
            'two_care_date' => 'nullable|date',
            'result2' => 'nullable|string|max:255',
            'three_care_date' => 'nullable|date',
            'result3' => 'nullable|string|max:255',
        ], [
            'customer_for_showroom.required' => 'Ngày không được để trống',
            'name.required' => 'Tên không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
        ]);

        DB::transaction(function () use ($validatedData, $lead) {
            $lead->update($validatedData);
        });

        return redirect()
            ->route('lead.index')
            ->with('success', 'Cập nhật lead thành công!');
    }

    /**
     * Xóa Lead
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('lead.index')->with('success', 'Xóa lead thành công!');
    }
}
