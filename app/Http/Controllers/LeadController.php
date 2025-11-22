<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Province;
use App\Models\LeadTakeCare;
use App\Models\CustomerType;
use App\Models\CustomerSource;
use App\Models\ProductCategory;
use App\Models\Showroom;
use App\Models\CustomerStatus;
use App\Models\SaleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Lead::class);
        
        $query = Lead::with([
            'province',
            'customerType',
            'customerSource',
            'productCategory',
            'showroom',
            'firstStatus',
            'currentStatus',
            'saleReceive',
            'saleSupport',
            'leadTakeCares'
        ]);
        $queryOnline = Lead::with([
            'province',
            'customerType',
            'customerSource',
            'productCategory',
            'showroom',
            'firstStatus',
            'currentStatus',
            'saleReceive',
            'saleSupport',
            'leadTakeCares'
        ]);
        $customerStatuses = CustomerStatus::all();

        if ($request->type_phone) {
        $query->where('phone', 'like', '%' . $request->type_phone . '%');
        $queryOnline->where('phone', 'like', '%' . $request->type_phone . '%');
        }

        if ($request->first_arrival_date) {
        $query->where('first_arrival_date', 'like', '%' . $request->first_arrival_date . '%');
        $queryOnline->where('first_arrival_date', 'like', '%' . $request->first_arrival_date . '%');
        }

        if ($request->current_status) {
            $query->where('current_customer_status_id', 'like', '%' . $request->current_status . '%');
            $queryOnline->where('current_customer_status_id', 'like', '%' . $request->current_status . '%');
        }

        
        $leads = $query->where('lead_type', 1)->get();
        $leadsOnline = $queryOnline->where('lead_type', 2)->get();
        return view('leads.index', compact(
            'leads',
            'leadsOnline',
            'customerStatuses'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Lead::class);
        
        $lead = Lead::all();
        $leadTakeCares = LeadTakeCare::all();
        $provinces = Province::all();
        $customerTypes = CustomerType::all();
        $customerSources = CustomerSource::all();
        $productCategories = ProductCategory::all();
        $showrooms = Showroom::all();
        $customerStatuses = CustomerStatus::all();
        $saleUsers = SaleUser::all();
        $supportStatuses = SaleUser::all();

        return view('leads.create', 
        compact(
            'lead',
            'leadTakeCares',
            'provinces',
            'customerTypes',
            'customerSources',
            'productCategories',
            'showrooms',
            'customerStatuses',
            'saleUsers',
            'supportStatuses'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Lead::class);
        
        $request->validate([
            'first_arrival_date' => 'required|date',
            'name' => 'required|string',
            'province_id' => 'required',
            'address' => 'required',
            'customer_type_id' => 'required',
            'is_new_customer' => 'required',
            'customer_source_id' => 'required',
            'product_category_id' => 'required',
            'showroom_id' => 'required',
            'first_customer_status_id' => 'required',
            'note' => 'required',
            'sale_receive_customer_info_id' => 'required',
            'sale_support_id' => 'required',
            'current_customer_status_id' => 'required',
            'support_status_customer_id' => 'required',
            'exchange_content' => 'required',
            'lead_type' => 'required'
        ], [
            'first_arrival_date.required' => 'Ngày đầu tiên không được để trống!',
            'name.required' => 'Tên không được để trống!',
            'province_id.required' => 'Tỉnh không được để trống!',
            'address.required' => 'Địa chỉ không được để trống!',
            'customer_type_id.required' => 'Loại khách hàng không được để trống!',
            'is_new_customer.required' => 'Tình trạng khách hàng không được để trống!',
            'customer_source_id.required' => 'Không được để trống!',
            'product_category_id.required' => 'Danh mục không được để trống!',
            'showroom_id.required' => 'Showroom không được để trống!',
            'first_customer_status_id.required' => 'Tình trạng đầu tiên không được để trống!',
            'sale_receive_customer_info_id.required' => 'Sale nhận thông tin không được để trống!',
            'sale_support_id.required' => 'Sale hỗ trợ không được để trống!',
            'current_customer_status_id.required' => 'Tình trạng hiện tại không được để trống!',
            'exchange_content.required' => 'Không được để trống!'
             
        ]);

        $lead = Lead::create([
            'first_arrival_date' => $request->first_arrival_date,
            'name' => $request->name,
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'address' => $request->address,
            'zalo' => $request->zalo ?? '',
            'customer_type_id' => $request->customer_type_id,
            'is_new_customer' => $request->is_new_customer,
            'customer_source_id' => $request->customer_source_id,
            'product_category_id' => $request->product_category_id,
            'showroom_id' => $request->showroom_id,
            'first_customer_status_id' => $request->first_customer_status_id,
            'note' => $request->note,
            'sale_receive_customer_info_id' => $request->sale_receive_customer_info_id,
            'sale_support_id' => $request->sale_support_id,
            'current_customer_status_id' => $request->current_customer_status_id,
            'order_value' => $request->order_value ?? 0,
            'support_status_customer_id' => $request->support_status_customer_id,
            'exchange_content' => $request->exchange_content,
            'results' => $request->results ?? '',
            'lead_type' => $request->lead_type
        ]);

        if ($request->has('take_care_plan')) {
            foreach ($request->take_care_plan as $index => $plan) {
                // Bỏ qua dòng trống (nếu user không nhập)
                if (empty($plan) && empty($request->take_care_date[$index]) && empty($request->take_care_result[$index])) {
                    continue;
                }

                // LeadTakeCare::create([
                //     'lead_id' => $lead->id,
                //     'take_care_plan' => $plan,
                //     'take_care_date' => $request->take_care_date[$index] ?? null,
                //     'take_care_result' => $request->take_care_result[$index] ?? null,
                // ]);
                try {
                    LeadTakeCare::create([
                        'lead_id' => $lead->id,
                        'take_care_plan' => $plan,
                        'take_care_date' => $request->take_care_date[$index] ?? null,
                        'take_care_result' => $request->take_care_result[$index] ?? null,
                    ]);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
        }
    }       

        return redirect()->route('leads.index')->with('success', 'Tạo Lead thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        Gate::authorize('view', $lead);
        
        $leadTakeCare = $lead->leadTakeCare;
        return view('leads.show', compact('lead', 'leadTakeCare'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        Gate::authorize('update', $lead);

        $leadTakeCare = LeadTakeCare::all();
        $provinces = Province::all();
        $customerTypes = CustomerType::all();
        $customerSources = CustomerSource::all();
        $productCategories = ProductCategory::all();
        $showrooms = Showroom::all();
        $customerStatuses = CustomerStatus::all();
        $saleUsers = SaleUser::all();
        $supportStatuses = SaleUser::all(); 
        return view('leads.edit', compact(
            'lead',
            'leadTakeCare',
            'provinces',
            'customerTypes',
            'customerSources',
            'productCategories',
            'showrooms',
            'customerStatuses',
            'saleUsers',
            'supportStatuses'

        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        Gate::authorize('update', $lead);
        
        $request->validate([
            'first_arrival_date' => 'required|date',
            'name' => 'required|string',
            'province_id' => 'required',
            'address' => 'required',
            'customer_type_id' => 'required',
            'is_new_customer' => 'required',
            'customer_source_id' => 'required',
            'product_category_id' => 'required',
            'showroom_id' => 'required',
            'first_customer_status_id' => 'required',
            'note' => 'required',
            'sale_receive_customer_info_id' => 'required',
            'sale_support_id' => 'required',
            'current_customer_status_id' => 'required',
            'support_status_customer_id' => 'required',
            'exchange_content' => 'required',
            'lead_type' => 'required'
        ], [
            'first_arrival_date.required' => 'Ngày đầu tiên không được để trống!',
            'name.required' => 'Tên không được để trống!',
            'province_id.required' => 'Tỉnh không được để trống!',
            'address.required' => 'Địa chỉ không được để trống!',
            'customer_type_id.required' => 'Loại khách hàng không được để trống!',
            'is_new_customer.required' => 'Tình trạng khách hàng không được để trống!',
            'customer_source_id.required' => 'Không được để trống!',
            'product_category_id.required' => 'Danh mục không được để trống!',
            'showroom_id.required' => 'Showroom không được để trống!',
            'first_customer_status_id.required' => 'Tình trạng đầu tiên không được để trống!',
            'sale_receive_customer_info_id.required' => 'Sale nhận thông tin không được để trống!',
            'sale_support_id.required' => 'Sale hỗ trợ không được để trống!',
            'current_customer_status_id.required' => 'Tình trạng hiện tại không được để trống!',
            'exchange_content.required' => 'Không được để trống!'
             
        ]);

        $lead->update([
            'first_arrival_date' => $request->first_arrival_date,
            'name' => $request->name,
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'address' => $request->address,
            'zalo' => $request->zalo,
            'customer_type_id' => $request->customer_type_id,
            'is_new_customer' => $request->is_new_customer,
            'customer_source_id' => $request->customer_source_id,
            'product_category_id' => $request->product_category_id,
            'showroom_id' => $request->showroom_id,
            'first_customer_status_id' => $request->first_customer_status_id,
            'note' => $request->note,
            'sale_receive_customer_info_id' => $request->sale_receive_customer_info_id,
            'sale_support_id' => $request->sale_support_id,
            'current_customer_status_id' => $request->current_customer_status_id,
            'order_value' => $request->order_value,
            'support_status_customer_id' => $request->support_status_customer_id,
            'exchange_content' => $request->exchange_content,
            'results' => $request->results,
            'lead_type' => $request->lead_type
        ]);

        $leadTakeCare = LeadTakeCare::Where('lead_id', $lead->id)->first();
         
        if($leadTakeCare){
            foreach($request->take_care_plan as $index => $plan) {
                $leadTakeCare = LeadTakeCare::updateOrCreate(
                    ['lead_id' => $lead->id, 'take_care_date' => $request->take_care_date[$index] ?? null],
                    [
                        'take_care_plan' => $plan,
                        'take_care_result' => $request->take_care_result[$index] ?? null,
                    ]
                );
            }
        } else {
            foreach($request->take_care_plan as $index => $plan) {
                LeadTakeCare::create([
                    'lead_id' => $lead->id,
                    'take_care_plan' => $plan,
                    'take_care_date' => $request->take_care_date[$index] ?? null,
                    'take_care_result' => $request->take_care_result[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('leads.index')->with('success', 'Cập nhập Lead thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        Gate::authorize('delete', $lead);
        
        LeadTakeCare::where('lead_id', $lead->id)->delete();
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Đã xóa Lead và dữ liệu chăm sóc liên quan!');
    }
}
