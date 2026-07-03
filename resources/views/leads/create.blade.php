@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}" class="text-decoration-none">
            <i class="bi bi-house-door"></i> Trang chủ
        </a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('leads.index') }}" class="text-decoration-none">
            <i class="bi bi-people"></i> Danh sách Lead
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        <i class="bi bi-person-plus"></i> Thêm Lead mới
    </li>
@endsection

@section('content')
<form action="{{ route('leads.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-8 col-md-8">
            <!-- Lead Information Card -->
            <div class="card fade-in mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-primary-light text-primary me-3">
                            <i class="bi bi-person-plus"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Thông tin Lead</h5>
                            <p class="text-muted mb-0">Nhập thông tin cơ bản của khách hàng</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="lead_type" class="form-label">
                                <i class="bi bi-diagram-3 me-1"></i><span class="text-primary fw-bold">Loại Lead</span>
                            </label>
                            <select name="lead_type" id="lead_type" class="form-select @error('lead_type') is-invalid @enderror">
                                <option value="1" {{ old('lead_type', '1') == '1' ? 'selected' : '' }}>Trực tiếp</option>
                                <option value="2" {{ old('lead_type') == '2' ? 'selected' : '' }}>Online</option>
                            </select>
                            @error('lead_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- Basic Information -->
                        <div class="col-md-4">
                           <label class="text-primary fw-bold">Mã khách hàng</label>
                            
                            <input type="text" class="form-control" value="{{ $previewCustomerCode }}" readonly>
                            
                            @if(request()->filled('customer_id'))
                                <input type="hidden" name="customer_id" value="{{ request('customer_id') }}">
                            @endif
                        </div>`

                        <div class="col-md-4">
                            <label class="text-primary fw-bold">Mã đơn hàng</label>
                            <input type="text" class="form-control" value="{{ $previewOrderCode }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label for="first_interaction_date" class="form-label">
                                <i class="bi bi-calendar me-1"></i><span class="text-primary fw-bold">Ngày tương tác đầu tiên</span>
                            </label>
                            <input type="date" name="first_interaction_date" id="first_interaction_date" 
                                    class="form-control @error('first_interaction_date') is-invalid @enderror"
                                    value="{{ old('first_interaction_date') }}">
                            @error('first_interaction_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label">
                                <i class="bi bi-person me-1"></i><span class="text-primary fw-bold">Tên khách hàng</span>
                            </label>
                            <input type="text" name="name" id="name" 
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Nhập tên khách hàng">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                       <div class="d-flex align-items-start gap-2 flex-wrap">
                            <button type="button" id="add-phone" class="btn btn-outline-primary">
                                + Thêm số điện thoại
                            </button>

                            <div id="phone-wrapper" class="d-flex gap-2 flex-wrap">
                                <div class="phone-item d-flex align-items-center gap-1">
                                    <input type="text" name="phone[]" class="form-control" placeholder="Nhập số điện thoại">
                                    <button type="button" class="btn btn-danger btn-sm remove-phone">x</button>
                                </div>
                            </div>
                        </div>
            

                        <div class="col-md-3">
                            <label for="zalo" class="form-label">
                                <i class="bi bi-chat-dots me-1"></i><span class="text-primary fw-bold">Zalo</span>
                            </label>
                            <input type="text" name="zalo" id="zalo" 
                                    class="form-control @error('zalo') is-invalid @enderror"
                                    value="{{ old('zalo') }}" placeholder="Nhập ID Zalo">
                            @error('zalo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-8">
                            <label for="address" class="form-label">
                                <i class="bi bi-house me-1"></i><span class="text-primary fw-bold">Địa chỉ</span>
                            </label>
                            <input type="text" name="address" id="address" 
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address') }}" placeholder="Nhập địa chỉ chi tiết">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="province_id" class="form-label">
                                <i class="bi bi-geo-alt me-1"></i><span class="text-primary fw-bold">Tỉnh/Thành phố</span>
                            </label>
                            <select name="province_id" id="province_id" 
                                    class="form-select @error('province_id') is-invalid @enderror">
                                <option value="">-- Chọn tỉnh/thành --</option>
                                @foreach($provinces as $p)
                                    <option value="{{ $p->id }}" {{ old('province_id') == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('province_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    

                        <!-- Customer Classification -->
                        <div class="col-md-4">
                            <label for="customer_type_id" class="form-label">
                                <i class="bi bi-tag me-1"></i><span class="text-primary fw-bold">Phân Loại khách hàng</span>
                            </label>
                            <select name="customer_type_id" id="customer_type_id" 
                                    class="form-select @error('customer_type_id') is-invalid @enderror">
                                <option value="">-- Chọn Phân loại khách hàng --</option>
                                @foreach($customerTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('customer_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                       <!-- Nguồn -->
                        <div class="col-md-4" id="source-field">
                            <label class="form-label">
                                <i class="bi bi-funnel me-1"></i><span class="text-primary fw-bold">Nguồn</span>
                            </label>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle w-100 @error('source_id') is-invalid border-danger @enderror"
                                    type="button" id="dropdownCustomerSources" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="background-color: #fff; color: #0d6efd; border: 1px solid #717375ff; border-radius: 0.375rem;">
                                    <span id="selectedSourceNameBtn">
                                        @php
                                            // Lấy ra tên của nguồn đã được chọn trước đó (nếu có validation lỗi)
                                            $selectedSource = collect($customerSources)->firstWhere('id', old('source_id'));
                                        @endphp
                                        @if($selectedSource)
                                            {{ $selectedSource->name }}
                                        @else
                                            -- Chọn nguồn --
                                        @endif
                                    </span>
                                </button>
                                
                                <div class="dropdown-menu w-100 p-2" aria-labelledby="dropdownCustomerSources" style="max-height: 300px; overflow-y: auto; background-color: #ffffff;">
                                    
                                    <div class="mb-2 position-sticky top-0 bg-white z-index-1">
                                        <input type="text" id="searchSourceInput" class="form-control form-control-sm" placeholder="Nhập tên nguồn để tìm...">
                                    </div>
                                    <hr class="dropdown-divider">

                                    <div id="sourceList">
                                        @foreach($customerSources as $src)
                                            <div class="form-check source-item mb-1">
                                                <input class="form-check-input source-radio" type="radio" name="source_id" 
                                                    id="source_{{ $src->id }}" value="{{ $src->id }}" 
                                                    data-name="{{ $src->name }}"
                                                    {{ old('source_id') == $src->id ? 'checked' : '' }}>
                                                <label class="form-check-label w-100" for="source_{{ $src->id }}" style="color: #1215ddff; cursor: pointer;">
                                                    {{ $src->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                </div>
                            </div>
                            @error('source_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Danh Mục Sản Phẩm -->
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="bi bi-funnel me-1"></i><span class="text-primary fw-bold">Danh mục sản phẩm</span>
                            </label>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle w-100 @error('product_category_ids') is-invalid border-danger @enderror"
                                    type="button" id="dropdownProductCategoriesCreate" data-bs-toggle="dropdown" aria-expanded="false"
                                    style="background-color: #fff; color: #0d6efd; border: 1px solid #717375ff; border-radius: 0.375rem;">
                                    <span id="selectedProductNamesBtn">
                                        @php
                                            $selectedProductNames = collect($productCategories)
                                                ->whereIn('id', (array)old('product_category_ids', []))
                                                ->pluck('name')
                                                ->toArray();
                                        @endphp
                                        @if(count($selectedProductNames))
                                            {{ implode(', ', $selectedProductNames) }}
                                        @else
                                            Chọn danh mục sản phẩm
                                        @endif
                                    </span>
                                </button>
                                
                                <div class="dropdown-menu w-100 p-2" aria-labelledby="dropdownProductCategoriesCreate" style="max-height: 300px; overflow-y: auto; background-color: #ffffffff;">
                                    
                                    <div class="mb-2 position-sticky top-0 bg-white z-index-1">
                                        <input type="text" id="searchCategoryInput" class="form-control form-control-sm" placeholder="Nhập tên danh mục để tìm...">
                                    </div>
                                    <hr class="dropdown-divider">

                                    <div id="categoryList">
                                        @foreach($productCategories as $cat)
                                            <div class="form-check category-item">
                                                <input class="form-check-input" type="checkbox" name="product_category_ids[]" id="product_category_{{ $cat->id }}" value="{{ $cat->id }}" {{ (collect(old('product_category_ids', []))->contains($cat->id)) ? 'checked' : '' }}>
                                                <label class="form-check-label w-100" for="product_category_{{ $cat->id }}" style="color: #1215ddff; cursor: pointer;">
                                                    {{ $cat->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                </div>
                            </div>
                            @error('product_category_ids')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4" id="showroom-field" style="display: {{ old('lead_type', '2') == '1' ? 'none' : 'block' }};">
                            <label for="showroom_id" class="form-label">
                                <i class="bi bi-building me-1"></i><span class="text-primary fw-bold">Showroom</span>
                            </label>
                            <select name="showroom_id" id="showroom_id" 
                                    class="form-select @error('showroom_id') is-invalid @enderror">
                                <option value="">-- Chọn showroom --</option>
                                @foreach($showrooms as $sr)
                                    <option value="{{ $sr->id }}" {{ old('showroom_id') == $sr->id ? 'selected' : '' }}>
                                        {{ $sr->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('showroom_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6" id="order-value-field">
                            <label for="order_value" class="form-label">
                                <i class="bi bi-currency-dollar me-1"></i><span class="text-primary fw-bold">Giá trị đơn chốt được</span>
                            </label>
                            <input type="text" name="order_value" id="order_value" 
                                class="form-control @error('order_value') is-invalid @enderror"
                                value="{{ old('order_value') }}" placeholder="Nhập giá trị đơn chốt được">
                            @error('order_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Information -->
                        <div class="col-md-6" id="first_customer_status_id-field" style="display: {{ old('lead_type', '1') == '2' ? 'none' : 'block' }};">
                            <label for="first_customer_status_id" class="form-label">
                                <i class="bi bi-flag me-1"></i><span class="text-primary fw-bold">Tình trạng KH ban đầu</span>
                            </label>
                            @php
                                $quanTamId = 2; // Thay bằng ID của trạng thái "Quan Tâm"
                            @endphp
                            <select name="first_customer_status_id" id="first_customer_status_id" 
                                    class="form-select @error('first_customer_status_id') is-invalid @enderror">
                                    
                                <option value="">-- Chọn tình trạng --</option>
                                @foreach($customerStatuses as $st)
                                    <!-- <option value="{{ $st->id }}" {{ old('first_customer_status_id') == $st->id ? 'selected' : '' }}>
                                        {{ $st->name }}
                                    </option> -->

                                    <option value="{{ $st->id }}"
                                        {{ old(
                                            'first_customer_status_id',
                                            old('lead_type', '1') == '2' ? $quanTamId : ''
                                        ) == $st->id ? 'selected' : '' }}>
                                        {{ $st->name }}
                                    </option>
        
                                @endforeach
                            </select>
                            @error('first_customer_status_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="current_customer_status_id" class="form-label">
                                <i class="bi bi-flag-fill me-1"></i><span class="text-primary fw-bold">Tình trạng KH hiện tại</span>
                            </label>
                            <select name="current_customer_status_id" id="current_customer_status_id" 
                                    class="form-select @error('current_customer_status_id') is-invalid @enderror">
                                <option value="">-- Chọn tình trạng --</option>
                                @foreach($customerStatuses as $st)
                                    <option value="{{ $st->id }}" {{ old('current_customer_status_id') == $st->id ? 'selected' : '' }}>
                                        {{ $st->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('current_customer_status_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- sale Nhận Thông tin -->
                        <div class="col-md-6" id="sale-field">

                            <label class="form-label">
                                <i class="bi bi-person-badge me-1"></i>
                                <span class="text-primary fw-bold">Sale nhận KH</span>
                            </label>

                            <div class="dropdown">
                                <button class="btn dropdown-toggle w-100 @error('sale_information_id') is-invalid border-danger @enderror"
                                    type="button"
                                    id="dropdownSaleInformation"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    style="background-color:#fff; color:#0d6efd; border:1px solid #717375ff; border-radius:0.375rem;">

                                    <span id="selectedSaleText">
                                        @php
                                            $selectedSale = collect($saleInformation)->firstWhere('id', old('sale_information_id'));
                                        @endphp

                                        @if($selectedSale)
                                            {{ $selectedSale->name }}
                                        @else
                                            -- Chọn sale --
                                        @endif
                                    </span>
                                </button>

                                <div class="dropdown-menu w-100 p-2"
                                    aria-labelledby="dropdownSaleInformation"
                                    style="max-height:300px; overflow-y:auto; background-color:#fff;">

                                    <!-- SEARCH -->
                                    <div class="mb-2 position-sticky top-0 bg-white z-index-1">
                                        <input type="text"
                                            id="searchSaleInput"
                                            class="form-control form-control-sm"
                                            placeholder="Nhập tên sale để tìm...">
                                    </div>

                                    <hr class="dropdown-divider">

                                    <!-- LIST -->
                                    <div id="saleList">

                                        @foreach($saleInformation as $s)
                                            <div class="form-check sale-item mb-1">

                                                <input class="form-check-input sale-radio"
                                                    type="radio"
                                                    name="sale_information_id"
                                                    id="sale_{{ $s->id }}"
                                                    value="{{ $s->id }}"
                                                    data-name="{{ $s->name }}"
                                                    {{ old('sale_information_id') == $s->id ? 'checked' : '' }}>

                                                <label class="form-check-label w-100"
                                                    for="sale_{{ $s->id }}"
                                                    style="color:#1215ddff; cursor:pointer;">
                                                    {{ $s->name }}
                                                </label>

                                            </div>
                                        @endforeach

                                    </div>

                                </div>
                            </div>

                            @error('sale_information_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    
                        <!-- sale hỗ trợ -->
                        <div class="col-md-6" id="sale-support-field">
                            <label class="form-label">
                                <i class="bi bi-headset me-1"></i>
                                <span class="text-primary fw-bold">Sale hỗ trợ</span>
                            </label>

                            <div class="dropdown">
                                <button class="btn dropdown-toggle w-100"
                                    type="button"
                                    id="dropdownSaleSupport"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    style="background-color:#fff; color:#0d6efd; border:1px solid #717375ff; border-radius:0.375rem;">

                                    <span id="selectedSaleSupportText">
                                        @php
                                            $selectedSaleSupport = collect($saleSupport)->firstWhere('id', old('sale_support_id'));
                                        @endphp

                                        @if($selectedSaleSupport)
                                            {{ $selectedSaleSupport->name }}
                                        @else
                                            Chọn sale hỗ trợ
                                        @endif
                                    </span>
                                </button>

                                <div class="dropdown-menu w-100 p-2"
                                    aria-labelledby="dropdownSaleSupport"
                                    style="max-height:300px; overflow-y:auto; background-color:#fff;">

                                    <!-- SEARCH -->
                                    <div class="mb-2 position-sticky top-0 bg-white">
                                        <input type="text"
                                            id="searchSaleSupportInput"
                                            class="form-control form-control-sm"
                                            placeholder="Nhập tên sale để tìm...">
                                    </div>

                                    <hr class="dropdown-divider">

                                    <!-- LIST -->
                                    <div id="saleSupportList">
                                        @foreach($saleSupport as $s)
                                            <div class="form-check sale-support-item mb-1">
                                                <input class="form-check-input sale-support-radio"
                                                    type="radio"
                                                    name="sale_support_id"
                                                    id="sale_support_{{ $s->id }}"
                                                    value="{{ $s->id }}"
                                                    data-name="{{ $s->name }}"
                                                    {{ old('sale_support_id') == $s->id ? 'checked' : '' }}>

                                                <label class="form-check-label w-100"
                                                    for="sale_support_{{ $s->id }}"
                                                    style="color:#1215ddff; cursor:pointer;">
                                                    {{ $s->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                            @error('sale_support_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6" id="support-channel-field" style="display: {{ old('lead_type', '1') == '1' ? 'block' : 'none' }};">
                                <label for="support_channel_id" class="form-label">
                                    <i class="bi bi-headset me-1"></i><span class="text-primary fw-bold">KH đã được hỗ trợ trước qua kênh nào?</span>
                            </label>
                            <select name="support_channel_id" id="support_channel_id" 
                                    class="form-select @error('support_channel_id') is-invalid @enderror">
                                <option value="">-- Chọn kênh hỗ trợ --</option>
                                @foreach($supportChannel as $s)
                                    <option value="{{ $s->id }}" {{ old('support_channel_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('support_channel_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="note" class="form-label">
                                <i class="bi bi-sticky me-1"></i><span class="text-primary fw-bold">Ghi chú sale nhận khách</span>
                            </label>
                            <textarea name="note" id="note" rows="3" 
                                        class="form-control @error('note') is-invalid @enderror"
                                        placeholder="Nhập ghi chú về khách hàng">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

            
                    

                        <div class="col-md-6" id="customer-discussion-details-field" style="display: {{ old('lead_type', '1') == '2' ? 'block' : 'none' }};">
                                <label for="customer_discussion_details" class="form-label">
                                    <i class="bi bi-sticky me-1"></i><span class="text-primary fw-bold">Thông Tin Trao Đổi</span>
                            </label>
                            <textarea name="customer_discussion_details" id="customer_discussion_details" rows="3" 
                                        class="form-control @error('customer_discussion_details') is-invalid @enderror"
                                        placeholder="Nhập ghi chú về khách hàng">{{ old('customer_discussion_details') }}</textarea>
                            @error('customer_discussion_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check col-md-6">
                            <input class="form-check-input" type="checkbox" name="tmdt" id="kq1" value="TMDT" {{ old('tmdt') == 'TMDT' ? 'checked' : '' }}>
                            <label for="kq1" class="form-label">
                                    <i class="bi bi-sticky me-1"></i><span class="text-primary fw-bold">Chuyển sang TMDT</span>
                            </label>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 col-md-4">
            <!-- Customer Care Information Card -->
            <!-- style="display: none;" -->
            <div class="card fade-in mb-4" id="customer-care-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle bg-success-light text-success me-3">
                            <i class="bi bi-chat-heart"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Kế hoạch chăm sóc khách hàng</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="care-plan mb-4 p-3 border rounded bg-light">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0 text-primary">Lần chăm sóc {{ $i }}</h6>
                            </div>
                            <div class="row g-3">
                                <label for="take_care_plan_{{ $i }}">Kế hoạch chăm sóc</label>
                                <input type="text" name="take_care_plan[]" id="take_care_plan_{{ $i }}" 
                                        class="form-control @error('take_care_plan.'.$i-1) is-invalid @enderror"
                                        value="{{ old('take_care_plan.'.$i-1) }}" 
                                        placeholder="Nhập kế hoạch chăm sóc">
                                @error('take_care_plan.'.$i-1)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label for="take_care_date_{{ $i }}">Ngày chăm sóc</label>
                                <input type="date" name="take_care_date[]" id="take_care_date_{{ $i }}" 
                                        class="form-control @error('take_care_date.'.$i-1) is-invalid @enderror"
                                        value="{{ old('take_care_date.'.$i-1) }}">
                                @error('take_care_date.'.$i-1)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <label for="take_care_result_{{ $i }}">Kết quả chăm sóc</label>
                                <input type="text" name="take_care_result[]" id="take_care_result_{{ $i }}" 
                                        class="form-control @error('take_care_result.'.$i-1) is-invalid @enderror"
                                        value="{{ old('take_care_result.'.$i-1) }}" 
                                        placeholder="Nhập kết quả chăm sóc">
                                @error('take_care_result.'.$i-1)
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card fade-in">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>Lưu Lead
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
// Auto-fill current date for first arrival date
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý ẩn/hiện các trường theo loại Lead
    const leadTypeSelect = document.getElementById('lead_type');
    const customerCareCard = document.getElementById('customer-care-card');
    const showroomField = document.getElementById('showroom-field');
    const orderValueField = document.getElementById('order-value-field');
    const firstCustomerStatusField = document.getElementById('first_customer_status_id-field');
    const saleSupportField = document.getElementById('sale-support-field');
    const supportChannelField = document.getElementById('support-channel-field');
    const sourceField = document.getElementById('source-field');
    const customerDiscussionDetailsField = document.getElementById('customer-discussion-details-field');

    function toggleLeadFields() {
        const isOnline = leadTypeSelect.value === '2';
        if (customerCareCard) {
            customerCareCard.style.display = isOnline ? 'block' : 'none';
            customerCareCard.classList.toggle('fade-in', isOnline);
        }
        if (showroomField) {
            showroomField.style.display = isOnline ? 'none' : 'block';
        }
        if (saleSupportField) {
            saleSupportField.style.display = isOnline ? 'block' : 'none';
        }
        if (firstCustomerStatusField) {
            firstCustomerStatusField.style.display = isOnline ? 'block' : 'none';
        }
        if (supportChannelField) {
            supportChannelField.style.display = isOnline ? 'none' : 'block';
        }
        if (customerDiscussionDetailsField) {
            customerDiscussionDetailsField.style.display = isOnline ? 'block' : 'none';
        }
        if (sourceField) {
            sourceField.style.display = isOnline ? 'block' : 'none';
        }
    }

    // Khởi tạo trạng thái ban đầu
    toggleLeadFields();
    // Lắng nghe sự thay đổi
    leadTypeSelect.addEventListener('change', toggleLeadFields);

    // Update product category button text when checkboxes change
    const productCheckboxes = document.querySelectorAll('input[name="product_category_ids[]"]');
    const productNamesBtn = document.getElementById('selectedProductNamesBtn');
    const productLabels = {};
    @foreach($productCategories as $cat)
        productLabels[{{ $cat->id }}] = @json($cat->name);
    @endforeach

    function updateProductNamesBtn() {
        const checked = Array.from(productCheckboxes).filter(cb => cb.checked).map(cb => productLabels[cb.value]);
        if (checked.length) {
            productNamesBtn.textContent = checked.join(', ');
        } else {
            productNamesBtn.textContent = 'Chọn danh mục sản phẩm';
        }
    }
    productCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateProductNamesBtn);
    });
    // Initial update
    updateProductNamesBtn();
});

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);

// tự thêm dấu chấm hàng nghìn cho giá trị đơn chốt được
document.getElementById('order_value').addEventListener('input', function (e) {
    let value = this.value.replace(/\D/g, ""); // bỏ ký tự không phải số
    this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // thêm dấu chấm
});

document.getElementById('add-phone').addEventListener('click', function () {
    let wrapper = document.getElementById('phone-wrapper');

    let div = document.createElement('div');
    div.classList.add('phone-item', 'd-flex', 'align-items-center', 'gap-1');

    div.innerHTML = `
        <input type="text" name="phone[]" class="form-control" placeholder="Nhập số điện thoại">
        <button type="button" class="btn btn-danger btn-sm remove-phone">x</button>
    `;

    wrapper.appendChild(div);
});

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-phone')) {
        e.target.closest('.phone-item').remove();
    }
});

document.addEventListener('DOMContentLoaded', function () {

    function initSmartDropdown(config) {

        const {
            searchId,
            itemClass,
            inputName,
            textId,
            defaultText,
            multiple = false
        } = config;

        const searchInput = document.getElementById(searchId);
        const textEl = document.getElementById(textId);

        if (!searchInput || !textEl) return;

        const getItems = () => document.querySelectorAll(itemClass);
        const getInputs = () => document.querySelectorAll(`input[name="${inputName}"]`);

        // ================= SEARCH (OPTIMIZED) =================
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();

            getItems().forEach(item => {

                const labelEl = item.querySelector('.form-check-label');
                const label = (labelEl?.textContent || '').toLowerCase();

                item.style.display = label.includes(keyword) ? '' : 'none';
            });
        });

        // ================= UPDATE TEXT =================
        const updateText = () => {

            const inputs = getInputs();
            let selectedNames = [];

            inputs.forEach(input => {
                if (input.checked) {

                    const label =
                        input.dataset.name ||
                        document.querySelector(`label[for="${input.id}"]`)?.textContent ||
                        '';

                    if (label.trim()) {
                        selectedNames.push(label.trim());
                    }
                }
            });

            textEl.innerText =
                selectedNames.length
                    ? (multiple ? selectedNames.join(', ') : selectedNames[0])
                    : defaultText;
        };

        // ================= EVENT DELEGATION (SAFE) =================
        document.addEventListener('change', function (e) {
            if (e.target.matches(`input[name="${inputName}"]`)) {
                updateText();
            }
        });

        // ================= INIT =================
        updateText();
    }

    // =====================================================
    // 🔥 INIT ALL DROPDOWNS
    // =====================================================

    initSmartDropdown({
        searchId: 'searchCategoryInput',
        itemClass: '.category-item',
        inputName: 'product_category_ids[]',
        textId: 'selectedProductNamesBtn',
        defaultText: 'Chọn danh mục sản phẩm',
        multiple: true
    });

    initSmartDropdown({
        searchId: 'searchSaleInput',
        itemClass: '.sale-item',
        inputName: 'sale_information_id',
        textId: 'selectedSaleText',
        defaultText: '-- Chọn sale --',
        multiple: false
    });

    initSmartDropdown({
        searchId: 'searchSaleSupportInput',
        itemClass: '.sale-support-item',
        inputName: 'sale_support_id',
        textId: 'selectedSaleSupportText',
        defaultText: 'Chọn sale hỗ trợ',
        multiple: false
    });

    initSmartDropdown({
        searchId: 'searchSourceInput',
        itemClass: '.source-item',
        inputName: 'source_id',
        textId: 'selectedSourceNameBtn',
        defaultText: '-- Chọn nguồn --',
        multiple: false
    });

});
// Online mặc định Quan Tâm
const quanTamId = {{ $quanTamId }};

$('#lead_type').on('change', function () {
    if ($(this).val() == '2') {
        $('#first_customer_status_id').val(quanTamId);
        $('#first_customer_status_id-field').hide();
    } else {
        $('#first_customer_status_id').val('');
        $('#first_customer_status_id-field').show();
    }
});
</script>
@endpush
