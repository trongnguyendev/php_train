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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Phone;
use App\Models\CustomerCode;

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
            'saleInformation',
            'saleSupport',
            'leadTakeCares',
            'supportedChannel',
            'creator' // 4. THÊM QUAN HỆ NGƯỜI TẠO ĐỂ LẤY TÊN HIỂN THỊ RA INDEX
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
            'supportedChannel',
            'creator' // 4. THÊM QUAN HỆ NGƯỜI TẠO ĐỂ LẤY TÊN HIỂN THỊ RA INDEX
        ]);
        $customerStatuses = CustomerStatus::all();
        $productCategories = ProductCategory::all();
        $customerSources = CustomerSource::all();
        $customerTypes = CustomerType::all();
        $firstStatuses = CustomerStatus::all();
        $currentStatus = CustomerStatus::all();
        $provinces = Province::all();
        $supportChannel = SupportChannel::all();
        $saleUsers = User::all();
        $customerCode = Lead::with('customerCode')->orderBy('id', 'desc')->get();
        
       

        // --- ĐOẠN PHÂN QUYỀN TRONG CONTROLLER ---
        $user = auth()->user(); 

        // 🔥 CHECK QUYỀN BẢNG TRUNG GIAN: Nếu user có role là 'admin' hoặc 'manager'
        if ($user->roles()->whereIn('slug', ['admin', 'manager', 'supporter'])->exists()) {
            
            // Quản lý & Admin: Load toàn bộ nhân viên để sếp lựa chọn lọc
            $saleUsers = User::all();

        } else {
            // Nếu là nhân viên thường (Staff, Sale...) không có quyền sếp
            
            // Ô lọc nhân viên chỉ hiển thị chính họ
            $saleUsers = User::where('id', $user->id)->get();

            // Ép điều kiện lọc SQL: Chỉ xem các Lead của chính mình phụ trách hoặc hỗ trợ
            // $query->where(function($q) use ($user) {
            //     $q->where('sale_information_id', $user->id)
            //     ->orWhere('sale_support_id', $user->id);
            // });

            // $queryOnline->where(function($q) use ($user) {
            //     $q->where('sale_information_id', $user->id)
            //     ->orWhere('sale_support_id', $user->id);
            // });
        }
        

        // --- BỘ LỌC TÌM KIẾM SỐ ĐIỆN THOẠI QUA BẢNG KHÁC ---
        if ($request->type_phone) {
            
            // 1. Lọc cho danh sách Lead Trực tiếp (Type 1)
            // Thay 'phones' bằng tên hàm quan hệ thực tế trong Model Lead của bạn (ví dụ: 'phones' hoặc 'phone')
            $query->whereHas('phones', function($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->type_phone . '%');
            });

            // 2. Lọc cho danh sách Lead Online (Type 2)
            $queryOnline->whereHas('phones', function($q) use ($request) {
                $q->where('phone', 'like', '%' . $request->type_phone . '%');
            });
        }

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
        // ngày chăm
        if ($request->date_now) {
            $query->whereHas('leadTakeCares', function ($q) use ($request) {
                $q->whereDate('take_care_date', $request->date_now);
            });

            $queryOnline->whereHas('leadTakeCares', function ($q) use ($request) {
                $q->whereDate('take_care_date', $request->date_now);
            });
        }
        
        if ($request->filled('current_status')) {

            $query->whereIn(
                'current_customer_status_id',
                $request->current_status
            );

            $queryOnline->whereIn(
                'current_customer_status_id',
                $request->current_status
            );
        }
        // tmdt 
        if ($request->tmdt) {
            $query->where('tmdt', $request->tmdt);
            $queryOnline->where('tmdt', $request->tmdt);
        }

        // nguồn khách hàng
        if ($request->customer_source === 'null') {
            $query->where(function ($q) {
                $q->whereNull('source_id')
                ->orWhere('source_id', '');
            });

            $queryOnline->where(function ($q) {
                $q->whereNull('source_id')
                ->orWhere('source_id', '');
            });
        } elseif ($request->customer_source) {
            $query->where('source_id', $request->customer_source);
            $queryOnline->where('source_id', $request->customer_source);
        }
        

            // tên khách hàng
        if ($request->customer_name) {
            // Chuẩn hóa từ khóa về chữ thường
            $searchTerm = mb_strtolower($request->customer_name, 'UTF-8'); 

            $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
            $queryOnline->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
        }
        // tìm kiếm theo mã khách hàng
        if ($request->filled('customer_code')) {

            $searchTerm = $request->customer_code;

            $applySearch = function ($q) use ($searchTerm) {
                $q->where('customer_code', 'LIKE', "%{$searchTerm}%");
            };

            $query->whereHas('customerCode', $applySearch);
            $queryOnline->whereHas('customerCode', $applySearch);
        }

        if ($request->sale_user) {
            $query->where('sale_support_id', $request->sale_user);
            $queryOnline->where('sale_support_id', $request->sale_user);
        }
        if ($request->sale_information) {
            $query->where('sale_information_id', $request->sale_information);
            $queryOnline->where('sale_information_id', $request->sale_information);
        }

        if ($request->productCategories) {
        
            $query->whereHas('productCategories', function($q) use ($request) {
                $q->whereIn('product_category_id', $request->productCategories);
            });
            $queryOnline->whereHas('productCategories', function($q) use ($request) {
                $q->whereIn('product_category_id', $request->productCategories);
            });
        }

        
        // Paginate results to improve performance (30 rows per page)
        // $leads = $query->where('lead_type', 1)->latest()->paginate(30, ['*'], 'direct_page');
        $isAdminOrManager = $user->roles()
            ->whereIn('slug', ['admin', 'manager', 'supporter'])
            ->exists();
        $directLeadCount = (clone $query)
            ->where('lead_type', 1)
            ->when(!$isAdminOrManager, function ($q) use ($user) {
                $q->where('sale_information_id', $user->id);
            })
            ->count();

        $leads = $query
            ->whereIn('lead_type', [1, 2])
            ->when(!$isAdminOrManager, function ($q) use ($user) {
                $q->where('sale_information_id', $user->id);
            })
            ->latest()
            ->paginate(30, ['*'], 'direct_page');

        
        // lấy danh sách user có trong sale_support_id
        $supportUsers = Lead::whereNotNull('sale_support_id')
            ->pluck('sale_support_id')
            ->unique()
            ->toArray();

        $highlightLead = session('highlight_lead');

        $leadsOnline = $queryOnline
            ->where('lead_type', 2)
            ->when(!$isAdminOrManager && !in_array($user->id, $supportUsers), function ($q) {
                $q->whereRaw('1 = 0');
            })
            ->when($highlightLead, function ($q) use ($highlightLead) {
                $q->orderByRaw('CASE WHEN id = ? THEN 0 ELSE 1 END', [$highlightLead]);
            })
            ->latest()
            ->paginate(30, ['*'], 'online_page');


        // $leadsOnline = $queryOnline
        //     ->where('lead_type', 2)
        //     ->when(!$isAdminOrManager && !in_array($user->id, $supportUsers), function ($q) {
        //         $q->whereRaw('1 = 0');
        //     })
        //     ->latest()
        //     ->paginate(30, ['*'], 'online_page');

    
        // Thông báo khách online cần chăm sóc hôm nay
        // $today = now()->toDateString();
        // $careOnline = \App\Models\LeadTakeCare::whereIn('lead_id', $leadsOnline->pluck('id'))
        //     ->where('take_care_date', $today)
        //     ->with('lead')
        //     ->get();
        // cách 2

        // thông báo chăm khách online hôm nay
        $today = today()->toDateString();

        // get IDs from current page of online leads to compute today's care notifications
        $onlineLeadIds = $leadsOnline->pluck('id')->toArray();

        $careOnline = LeadTakeCare::with('lead')
            ->whereIn('lead_id', $onlineLeadIds)
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
            'saleUsers',
            'customerCode',
            'directLeadCount'  
        ));
}


/**
 * Show the form for creating a new resource.
 */
// public function create()
// {
    
//     $today = now()->format('dmy');

//     $count = \App\Models\Lead::whereDate('created_at', now())->count();

//     $number = $count + 1;

//     $previewCode = 'C' . $today . str_pad($number, 3, '0', STR_PAD_LEFT);
    

//     Gate::authorize('create', Lead::class);
//     $lead = Lead::all();
//     $leadTakeCares = LeadTakeCare::all();
//     $provinces = Province::all();
//     $customerTypes = CustomerType::all();
//     $customerSources = CustomerSource::all();
//     $productCategories = ProductCategory::all();
//     $showrooms = Showroom::all();
//     $customerStatuses = CustomerStatus::all();
//     $saleInformation = User::all();
//     $saleSupport = User::all();
//     $supportChannel = SupportChannel::all();
    
//     return view('leads.create', compact(
//         'lead',
//         'leadTakeCares',
//         'provinces',
//         'customerTypes',
//         'customerSources',
//         'productCategories',
//         'showrooms',
//         'customerStatuses',
//         'saleInformation',
//         'saleSupport',
//         'supportChannel',
//         'previewCode'
//     ));
// }

public function create(Request $request)
    {
        Gate::authorize('create', Lead::class);

        $today = now()->format('dmy');
        $previewCustomerCode = '';
        $previewOrderCode = '';

        // KIỂM TRA: Nếu có customer_id truyền lên (tức là tạo đơn cho KHÁCH CŨ)
        if ($request->has('customer_id')) {
            $customer = CustomerCode::find($request->customer_id);
            if ($customer) {
                $previewCustomerCode = $customer->customer_code; // Lấy luôn mã khách cũ
                
                // 🔥 SỬA TẠI ĐÂY: Đếm xem KHÁCH HÀNG NÀY đã có bao nhiêu đơn (lead) trong hệ thống
                $orderCount = Lead::where('customer_id', $customer->id)->count();
                
                // Mã đơn tiếp theo sẽ bằng: Mã Khách Hàng + Số thứ tự đơn tiếp theo
                // Ví dụ: C020626001-02, C020626001-03
                $previewOrderCode = $customer->customer_code . str_pad($orderCount + 1, 3, '0', STR_PAD_LEFT);
            }
        } 
        // TRƯỜNG HỢP: KHÁCH HÀNG MỚI HOÀN TOÀN
        else {
            // Tính mã Khách hàng tiếp theo sẽ sinh (C...)
            $customerCount = CustomerCode::whereDate('created_at', now())->count();
            $previewCustomerCode = 'C' . $today . str_pad($customerCount + 1, 3, '0', STR_PAD_LEFT);

            // 🔥 Vì là khách mới tinh, đây chắc chắn là đơn đầu tiên của họ
            $previewOrderCode = $previewCustomerCode . '001';
        }

        // --- Giữ nguyên toàn bộ phần 2 lấy dữ liệu đổ ra select box của bạn ---
        $lead = Lead::all();
        $leadTakeCares = LeadTakeCare::all();
        $provinces = Province::all();
        $customerTypes = CustomerType::all();
        $customerSources = CustomerSource::all();
        $productCategories = ProductCategory::all();
        $showrooms = Showroom::all();
        $customerStatuses = CustomerStatus::all();
        $saleInformation = User::all();
        $saleSupport = User::all();
        $supportChannel = SupportChannel::all();
        $customers = CustomerCode::orderBy('id', 'desc')->get();

        return view('leads.create', compact(
            'lead', 'leadTakeCares', 'provinces', 'customerTypes', 'customerSources',
            'productCategories', 'showrooms', 'customerStatuses', 'saleInformation',
            'saleSupport', 'supportChannel', 'previewCustomerCode', 'previewOrderCode', 'customers'
        ));
    }


/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    Gate::authorize('create', Lead::class);

    if ($request->lead_type == 1) {
        $rules =  [
            'phone' => 'nullable|array',
            'phone.*' => [
                'string',
                'regex:/^(0[0-9]{9}|\+[1-9]\d{7,14})$/'
            ],
            'customer_type_id' => 'required',
            'first_interaction_date' => 'required|date',
            'name' => 'required|string',
            'product_category_ids' => 'required|array|min:1',
            'showroom_id' => 'required_if:lead_type,1',
            'current_customer_status_id' => 'required',
            'sale_information_id' => 'required',
            'note' => 'required',
        ];$messages = [
            'phone.*.required' => 'Vui lòng không để trống ô số điện thoại.',
            'phone.*.regex'    => 'Số điện thoại :value không đúng định dạng (phải có 10 số và bắt đầu bằng 03,05,07,08,09).',
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
            'phone' => 'nullable|array', 
            'phone.*' => [
                'string',
                'regex:/^(0[0-9]{9}|\+[1-9]\d{7,14})$/'
            ],
            'customer_type_id' => 'required',
            'name' => 'required|string',
            'first_interaction_date' => 'required|date',
            'first_customer_status_id' =>'required_if:lead_type,2',
            'current_customer_status_id' => 'required',
            'sale_information_id' => 'required',
            'sale_support_id' => 'required',
            'product_category_ids' => 'required|array|min:1',
            'customer_discussion_details' => 'required',
            'source_id' => 'required',
            'lead_type' => 'required',
        ];$messages = [
            'phone.*.required' => 'Vui lòng không để trống ô số điện thoại.',
            'phone.*.regex'    => 'Số điện thoại :value không đúng định dạng (phải có 10 số và bắt đầu bằng 03,05,07,08,09).',
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
     // 3. LOGIC XỬ LÝ CUSTOMER_ID (Đảm bảo khách cũ dùng lại ID, khách mới sinh ID mới)
    if ($request->filled('customer_id')) {
        $customerId = $request->customer_id; // Lấy ID khách hàng từ input (nếu có)
    } else {
        $newCustomer = CustomerCode::create();
        $customerId = $newCustomer->id;
    }
    // Lấy ID của User đang đăng nhập hệ thống
    $currentUserId = auth()->id();
        

    if ($request->lead_type == 1) { // Trực tiếp
    
        $lead = Lead::create([
            'customer_id' => $customerId, // Gán ID khách hàng vào đây
            'first_interaction_date' => $request->first_interaction_date,
            'name' => $request->name,
            // 'phone' => $request->phone ?? 0,
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
            'lead_type' => $request->lead_type,
            // THÊM DÒNG NÀY: Lưu ID người tạo
            'created_by' => $currentUserId,
        ]);

        
        $phones = $request->phone ?? [];

        // Ép về array nếu là string
        if (!is_array($phones)) {
            $phones = [$phones];
        }

        // Lọc và loại trùng
        $phones = array_filter($phones);
        $phones = array_unique($phones);

        // Lưu
        foreach ($phones as $phone) {
            $lead->phones()->create([
                'phone' => $phone
            ]);
        }
    } else { // Online
        $lead = Lead::create([
            'customer_id' => $customerId, // Gán ID khách hàng vào đây
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
            'lead_type' => $request->lead_type,
            // THÊM DÒNG NÀY: Lưu ID người tạo
            'created_by' => $currentUserId,
        ]);

    

        $phones = $request->phone ?? [];

            // Ép về array nếu là string
            if (!is_array($phones)) {
                $phones = [$phones];
            }

            // Lọc và loại trùng
            $phones = array_filter($phones);
            $phones = array_unique($phones);

            // Lưu
            foreach ($phones as $phone) {
                $lead->phones()->create([
                    'phone' => $phone
                ]);
            }
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
    // 1. Eager load mối quan hệ với bảng mã khách hàng để tối ưu câu lệnh truy vấn
    $lead->load('customerCode');
    $phones = $lead->phones;
    $leadTakeCare = $lead->leadTakeCare;
    // 3. (TÙY CHỌN NÂNG CAO) Lấy toàn bộ lịch sử các đơn hàng khác của khách hàng này
    $otherLeads = [];
    if ($lead->customer_id) {
        $otherLeads = Lead::where('customer_id', $lead->customer_id)
            ->where('id', '!=', $lead->id) // Loại trừ đơn hàng hiện tại đang xem
            ->orderBy('created_at', 'desc')
            ->get();
    }
    return view('leads.show', compact('lead', 'phones', 'leadTakeCare', 'otherLeads'));
}

/**
 * Show the form for editing the specified resource.
 */
public function edit(Lead $lead)
{
    Gate::authorize('update', $lead);
    // 1. Eager load mã khách hàng để hiển thị trên form sửa nếu cần
    $lead->load('customerCode');
    $leadTakeCare = LeadTakeCare::all();
    $provinces = Province::all();
    $customerTypes = CustomerType::all();
    $customerSources = CustomerSource::all();
    $productCategories = ProductCategory::all();
    $showrooms = Showroom::all();
    $customerStatuses = CustomerStatus::all();
    $saleInformation = User::all();
    $saleSupport = User::all();
    $supportChannel = SupportChannel::all();
    $phones = Phone::where('phones.lead_id', $lead->id)->get();
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
        'supportChannel',
        'phones',


    ));
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, Lead $lead)
{
    Gate::authorize('update', $lead);
    $rules = [
        'phone' => 'nullable|array', 
        'phone.*' => [
                'string',
                'regex:/^(0[0-9]{9}|\+[1-9]\d{7,14})$/'
        ],
        'first_interaction_date' => 'required|date',
        'name' => 'required|string',
        'customer_type_id' => 'required',
        'productCategories' => 'required|array|min:1',
        'note' => 'required',
        'lead_type' => 'required',
        'sale_support_id' => 'nullable',
    ]; 
    
    $messages = [
        'phone.*.required' => 'Vui lòng không để trống ô số điện thoại.',
        'phone.*.regex'    => 'Số điện thoại :value không đúng định dạng (phải có 10 số và bắt đầu bằng 03,05,07,08,09).',
        'productCategories.required' => 'Vui lòng chọn ít nhất một Loại sản phẩm.',
        'first_interaction_date.required' => 'Vui lòng nhập Ngày tương tác đầu tiên.',
        'name.required' => 'Vui lòng nhập Tên khách hàng.',
        'note.required' => 'Vui lòng nhập Ghi chú về khách hàng.',
        'customer_type_id.required' => 'Vui lòng chọn Loại khách hàng.',
    ];
    $request->validate($rules, $messages);
    // Check để coi lead tô màu từ trực tiếp sang online 
    $oldLeadType = $lead->lead_type;

    $orderValue = 0;
    if ($request->order_value) {
        $orderValue = (int) str_replace('.', '', $request->order_value);
    }

    // Chỉ cập nhật bản ghi Lead hiện tại
    
    $lead->update([
        // Nhận customer_id mới nếu trên giao diện cho phép đổi khách hàng, ngược lại giữ nguyên giá trị cũ
        'customer_id' => $request->input('customer_id', $lead->customer_id),
        'first_interaction_date' => $request->first_interaction_date,
        'name' => $request->name,
        
        'province_id' => $request->province_id,
        'address' => $request->address,
        'zalo' => $request->zalo ?? '',
        'customer_type_id' => $request->customer_type_id,
        'source_id' => $request->source_id,
        'showroom_id' => $request->showroom_id,
        'note' => $request->note,
        'first_customer_status_id' => $request->first_customer_status_id ?? null,
        'sale_information_id' => $request->sale_information_id,
        'sale_support_id' => $request->sale_support_id ?? 0,
        'current_customer_status_id' => $request->current_customer_status_id,
        'order_value' => $orderValue,
        'support_channel_id' => $request->support_channel_id ?? null,
        'customer_discussion_details' => $request->customer_discussion_details ?? '',
        'tmdt' => $request->has('tmdt') ? $request->tmdt : null,
        'lead_type' => $request->lead_type
    ]);
    $lead->phones()->delete();

    $phones = collect($request->phone ?? [])
        ->filter()
        ->unique()
        ->map(fn($p) => ['phone' => $p])
        ->toArray();

    $lead->phones()->createMany($phones);

    // Lưu nhiều product category khi cập nhật
    if ($request->has('productCategories')) {
        $lead->productCategories()->sync($request->productCategories);
    }

    $leadTakeCare = LeadTakeCare::where('lead_id', $lead->id)->delete();

        foreach ((array) $request->take_care_plan as $index => $plan) {

            $date = $request->take_care_date[$index] ?? null;

            if (!$date && !$plan) {
                continue;
            }

            LeadTakeCare::create([
                'lead_id' => $lead->id,
                'take_care_plan' => $plan,
                'take_care_date' => $date,
                'take_care_result' => $request->take_care_result[$index] ?? null,
            ]);
        }

        $redirect = redirect()
            ->route('leads.index', request()->query())
            ->with('success', 'Cập nhập Lead thành công!');

        if ($oldLeadType == 1 && $request->lead_type == 2) {
            $redirect->with('highlight_lead', $lead->id);
        }

        if ($oldLeadType == 1 && $request->lead_type == 2) {
                session()->flash('highlight_lead', $lead->id);
            }

            return redirect()
                ->route('leads.index', request()->query())
                ->with('success', 'Cập nhật Lead thành công!');

        // return $redirect;
    // return redirect()->route('leads.index', request()->query())->with('success', 'Cập nhập Lead thành công!');
}

/**
 * Remove the specified resource from storage.
 */
public function destroy(Lead $lead)
{
    Gate::authorize('delete', $lead);

        // Xóa phone
    $lead->phones()->delete();
    
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
