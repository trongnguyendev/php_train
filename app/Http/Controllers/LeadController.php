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
use App\Models\SupportChannel;
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
            'saleInformation',
            'saleSupport',
            'leadTakeCares',
            'supportedChannel'
        ]);
        $queryOnline = Lead::with([
            'province',
            'customerType',
            'customerSource',
            'productCategory',
            'showroom',
            'firstStatus',
            'currentStatus',
            'saleInformation',
            'saleSupport',
            'leadTakeCares',
            'supportedChannel'
        ]);
        $customerStatuses = CustomerStatus::all();
        $productCategories = ProductCategory::all();
        $customerSources = CustomerSource::all();
        $customerTypes = CustomerType::all();
        $firstStatuses = CustomerStatus::all();
        $currentStatus = CustomerStatus::all();
        $provinces = Province::all();
        $supportChannel = SupportChannel::all();
        $saleUsers = SaleUser::all();

        if ($request->type_phone) {
        $query->where('phone', 'like', '%' . $request->type_phone . '%');
        $queryOnline->where('phone', 'like', '%' . $request->type_phone . '%');
        }

        // if ($request->first_arrival_date) {
        // $query->where('first_arrival_date', 'like', '%' . $request->first_arrival_date . '%');
        // $queryOnline->where('first_arrival_date', 'like', '%' . $request->first_arrival_date . '%');
        // }

        if ($request->form_date && $request->to_date) {
            $query->whereBetween('first_interaction_date', [
                $request->form_date,
                $request->to_date
            ]);

            $queryOnline->whereBetween('first_interaction_date', [
                $request->form_date,
                $request->to_date
            ]);
        }

        if ($request->current_status) {
            $query->where('current_customer_status_id', 'like', '%' . $request->current_status . '%');
            $queryOnline->where('current_customer_status_id', 'like', '%' . $request->current_status . '%');
        }
        if ($request->sale_user) {
            $query->where('sale_support_id', 'like', '%' . $request->sale_user . '%');
            $queryOnline->where('sale_support_id', 'like', '%' . $request->sale_user . '%');
        }

        if ($request->sale_user) {
            $query->where('sale_information_id', 'like', '%' . $request->sale_user . '%');
            $queryOnline->where('sale_information_id', 'like', '%' . $request->sale_user . '%');
        }

        if ($request->productCategories) {
            $query->whereHas('productCategories', function($q) use ($request) {
                $q->whereIn('product_category_id', $request->productCategories);
            });
            $queryOnline->whereHas('productCategories', function($q) use ($request) {
                $q->whereIn('product_category_id', $request->productCategories);
            });
        }

        
        $leads = $query->where('lead_type', 1)->get();
        $leadsOnline = $queryOnline->where('lead_type', 2)->get();

        // Thông báo khách online cần chăm sóc hôm nay
        // $today = now()->toDateString();
        // $careOnline = \App\Models\LeadTakeCare::whereIn('lead_id', $leadsOnline->pluck('id'))
        //     ->where('take_care_date', $today)
        //     ->with('lead')
        //     ->get();
        // cách 2

        // thông báo chăm khách online hôm nay
        $today = today()->toDateString();

        $careOnline = LeadTakeCare::with('lead')
            ->whereIn('lead_id', $leadsOnline->pluck('id'))
            ->whereDate('take_care_date', $today)
            ->get();

        return view('leads.index', compact(
            'leads',
            'leadsOnline',
            'customerStatuses',
            'productCategories',
            'customerSources',
            'customerTypes',
            'firstStatuses',
            'provinces',
            'supportChannel',
            'careOnline',
            'saleUsers'
        ));
        }
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
        $saleInformation = SaleUser::all();
        $saleSupport = SaleUser::all();
        $supportChannel = SupportChannel::all();
        return view('leads.create', compact(
            'lead',
            'leadTakeCares',
            'provinces',
            'customerTypes',
            'customerSources',
            'productCategories',
            'showrooms',
            'customerStatuses',
            'saleInformation',
            'saleSupport',
            'supportChannel'
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Lead::class);
        
        // $rules = [
        //     'first_interaction_date' => 'required|date',
        //     'name' => 'required|string',
        //     'customer_type_id' => 'required',
        //     'product_category_ids' => 'required|array|min:1',
        //     'first_customer_status_id' =>'required_if:lead_type,2',
        //     'current_customer_status_id' => 'required',
        //     'sale_information_id' => 'required',
        //     'sale_support_id' => 'nullable',
        //     'customer_discussion_details' => 'required_if:lead_type,2',
        //     'lead_type' => 'required',
        // ];
        if ($request->lead_type == 1) {
            $rules =  [
                'customer_type_id' => 'required',
                'first_interaction_date' => 'required|date',
                'name' => 'required|string',
                'product_category_ids' => 'required|array|min:1',
                'showroom_id' => 'required_if:lead_type,1',
                'current_customer_status_id' => 'required',
                'sale_information_id' => 'required',
                'note' => 'required',
            ];$messages = [
                'showroom_id.required_if' => 'Vui lòng chọn Showroom khi Lead là Trực tiếp.',
                'product_category_ids.required' => 'Vui lòng chọn ít nhất một Loại sản phẩm.',
                'first_interaction_date.required' => 'Vui lòng nhập Ngày tương tác đầu tiên.',
                'name.required' => 'Vui lòng nhập Tên khách hàng.',
                'current_customer_status_id.required' => 'Vui lòng chọn Trạng thái khách hàng hiện tại.',
                'sale_information_id.required' => 'Vui lòng chọn Nhân viên kinh doanh phụ trách.',
                'note.required' => 'Vui lòng nhập Ghi chú về khách hàng.',
                'customer_type_id.required' => 'Vui lòng chọn Loại khách hàng.',
                
            ];
        }
        if ($request->lead_type == 2) {
            $rules =  [
                'customer_type_id' => 'required',
                'name' => 'required|string',
                'first_interaction_date' => 'required|date',
                'product_category_ids' => 'required|array|min:1',
                'first_customer_status_id' =>'required_if:lead_type,2',
                'current_customer_status_id' => 'required',
                'sale_information_id' => 'required',
                'sale_support_id' => 'required',
                'product_category_ids' => 'required|array|min:1',
                'customer_discussion_details' => 'required',
                'source_id' => 'required',
                'lead_type' => 'required',
            ];$messages = [
                'product_category_ids.required' => 'Vui lòng chọn ít nhất một Loại sản phẩm.',
                'first_interaction_date.required' => 'Vui lòng nhập Ngày tương tác đầu tiên.',
                'name.required' => 'Vui lòng nhập Tên khách hàng.',
                'product_category_ids.required' => 'Vui lòng chọn ít nhất một Loại sản phẩm.',
                'customer_type_id.required' => 'Vui lòng chọn Loại khách hàng.',
                'first_customer_status_id.required_if' => 'Vui lòng chọn Trạng thái khách hàng ban đầu.',
                'current_customer_status_id.required' => 'Vui lòng chọn Trạng thái khách hàng hiện tại.',
                'sale_information_id.required' => 'Vui lòng chọn Sale Nhận Thôn Tin.',
                'sale_support_id.required' => 'Vui lòng chọn Sale Hỗ Trợ.',
                'source_id.required' => 'Vui lòng chọn Nguồn khách hàng.',
                'customer_discussion_details.required' => 'Vui lòng nhập Chi tiết trao đổi với khách hàng.',
            ];
        }
        $request->validate($rules, $messages);
        $orderValue = 0;
            if ($request->order_value) {
                $orderValue = (int) str_replace('.', '', $request->order_value);
            }

        if ($request->lead_type == 1) { // Trực tiếp
            $lead = Lead::create([
                'first_interaction_date' => $request->first_interaction_date,
                'name' => $request->name,
                'phone' => $request->phone ?? 0,
                'province_id' => $request->province_id,
                'address' => $request->address,
                'zalo' => $request->zalo ?? '',
                'customer_type_id' => $request->customer_type_id,
                'source_id' => $request->source_id,
                'showroom_id' => $request->showroom_id,
                'note' => $request->note,
                'sale_information_id' => $request->sale_information_id,
                'sale_support_id' => $request->sale_support_id ?? 0,
                'current_customer_status_id' => $request->current_customer_status_id,
                'order_value' => $orderValue,
                'support_channel_id' => $request->support_channel_id ?? null,
                'tmdt' => $request->has('tmdt') ? $request->tmdt : null,
                'lead_type' => $request->lead_type
            ]);
        } else { // Online
            $lead = Lead::create([
                'first_interaction_date' => $request->first_interaction_date,
                'name' => $request->name,
                'phone' => $request->phone ?? 0,
                'province_id' => $request->province_id ?? null,
                'address' => $request->address,
                'zalo' => $request->zalo ?? '',
                'customer_type_id' => $request->customer_type_id,
                'source_id' => $request->source_id,
                'first_customer_status_id' => $request->first_customer_status_id,
                'note' => $request->note,
                'sale_information_id' => $request->sale_information_id,
                'sale_support_id' => $request->sale_support_id,
                'order_value' => $orderValue,
                'current_customer_status_id' => $request->current_customer_status_id,
                'customer_discussion_details' => $request->customer_discussion_details,
                'tmdt' => $request->has('tmdt') ? $request->tmdt : null,
                'lead_type' => $request->lead_type
            ]);
        }
        // Lưu nhiều product category cho lead
        if ($request->has('product_category_ids')) {
            $lead->productCategories()->sync($request->product_category_ids);
        }

        if ($request->has('take_care_plan')) {
            foreach ((array) $request->take_care_plan as $index => $plan) {
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
        $saleInformation = SaleUser::all();
        $saleSupport = SaleUser::all();
        $supportChannel = SupportChannel::all();
        return view('leads.edit', compact(
            'lead',
            'leadTakeCare',
            'provinces',
            'customerTypes',
            'customerSources',
            'productCategories',
            'showrooms',
            'customerStatuses',
            'saleInformation',
            'saleSupport',
            'supportChannel'

        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        Gate::authorize('update', $lead);
        
        $rules = [
            'first_interaction_date' => 'required|date',
            'name' => 'required|string',
            // 'province_id' => 'required',
            // 'address' => 'required',
            'customer_type_id' => 'required',
            'product_category_ids' => 'required|array|min:1',
            'note' => 'required',
            'lead_type' => 'required',
            'sale_support_id' => 'nullable',
        ];

        $orderValue = 0;
        if ($request->order_value) {
            $orderValue = (int) str_replace('.', '', $request->order_value);
        }

        // Chỉ cập nhật bản ghi Lead hiện tại
        
        $lead->update([
            'first_interaction_date' => $request->first_interaction_date,
            'name' => $request->name,
            'phone' => $request->phone,
            'province_id' => $request->province_id,
            'address' => $request->address,
            'zalo' => $request->zalo ?? '',
            'customer_type_id' => $request->customer_type_id,
            'source_id' => $request->source_id,
            'showroom_id' => $request->showroom_id,
            'note' => $request->note,
            'sale_information_id' => $request->sale_information_id,
            'sale_support_id' => $request->sale_support_id ?? 0,
            'current_customer_status_id' => $request->current_customer_status_id,
            'order_value' => $orderValue,
            'support_channel_id' => $request->support_channel_id ?? null,
            'customer_discussion_details' => $request->customer_discussion_details ?? '',
            'tmdt' => $request->has('tmdt') ? $request->tmdt : null,
            'lead_type' => $request->lead_type
        ]);
        // Lưu nhiều product category khi cập nhật
        if ($request->has('product_category_ids')) {
            $lead->productCategories()->sync($request->product_category_ids);
        }

        $leadTakeCare = LeadTakeCare::Where('lead_id', $lead->id)->first();
         
        if($leadTakeCare){
            foreach((array) $request->take_care_plan as $index => $plan) {
                $leadTakeCare = LeadTakeCare::updateOrCreate(
                    ['lead_id' => $lead->id, 'take_care_date' => $request->take_care_date[$index] ?? null],
                    [
                        'take_care_plan' => $plan,
                        'take_care_result' => $request->take_care_result[$index] ?? null,
                    ]
                );
            }
        } else {
            foreach((array) $request->take_care_plan as $index => $plan) {
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

    public function updateInline(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $lead->{$request->field} = $request->value;
        $lead->save();

        return response()->json(['success' => true]);
    }

    public function getCategories($id)
    {
        $lead = Lead::findOrFail($id);
        return $lead->productCategories()->pluck('id');
    }

    public function updateCategories(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->productCategories()->sync($request->categories);
        return response()->json(['success' => true]);
    }



}
