<?php

namespace App\Http\Controllers;

use App\Models\LeadOnline;
use App\Models\Province;
use App\Models\TypeCustomer;
use App\Models\TypeShowroom;
use App\Models\Category;
use App\Models\Status;
use App\Models\Salename;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadOnlineController extends Controller
{
    public function index(Request $request)
    {
        $statusList = Status::all();

        $query = LeadOnline::with([
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
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        $leadonline = $query->latest()->paginate(20);
        $leadonline->appends($request->all());

        return view('leadonline.index', compact('leadonline', 'statusList'));
    }

    public function create()
    {
        $provinces = Province::all();
        $typeCustomer = TypeCustomer::all();
        $typeShowroom = TypeShowroom::all();
        $category = Category::all();
        $status = Status::all();
        $salename = Salename::all();
        $source = Source::all();

        return view('leadonline.create', compact(
            'provinces',
            'typeCustomer',
            'typeShowroom',
            'category',
            'status',
            'salename',
            'source'
        ));
    }

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
            'first_care_date' => 'nullable|date',
            'result1' => 'nullable|string',
            'two_care_date' => 'nullable|date',
            'result2' => 'nullable|string',
            'three_care_date' => 'nullable|date',
            'result3' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validatedData) {
            LeadOnline::create($validatedData);
        });

        return redirect()->route('leadonline.index')->with('success', 'Thêm khách hàng thành công!');
    }

    public function edit(leadOnline $leadonline)
    {
        $provinces = Province::all();
        $typeCustomer = TypeCustomer::all();
        $typeShowroom = TypeShowroom::all();
        $category = Category::all();
        $status = Status::all();
        $salename = Salename::all();
        $source = Source::all();

        return view('leadOnline.edit', compact(
            'leadonline',
            'provinces',
            'typeCustomer',
            'typeShowroom',
            'category',
            'status',
            'salename',
            'source'
        ));
    }

    public function update(Request $request, LeadOnline $leadOnline)
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
            'first_care_date' => 'nullable|date',
            'result1' => 'nullable|string',
            'two_care_date' => 'nullable|date',
            'result2' => 'nullable|string',
            'three_care_date' => 'nullable|date',
            'result3' => 'nullable|string',
        ]);

        // dd($validatedData);

        DB::transaction(function () use ($validatedData, $leadOnline) {
            $leadOnline->update($validatedData);
        });

        return redirect()->route('leadonline.index')->with('success', 'Cập nhật khách hàng thành công!');
    }

    public function show(LeadOnline $leadOnline)
    {
        return view('leadonline.show', compact('leadOnline'));
    }


    public function destroy(LeadOnline $leadOnline)
    {
        $leadOnline->delete();

        return redirect()->route('leadonline.index')->with('success', 'Xóa khách hàng thành công!');
    }
}
