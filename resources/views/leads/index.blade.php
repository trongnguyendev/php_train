@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}" class="text-decoration-none">
            <i class="bi bi-house-door"></i> Trang chủ
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        <i class="bi bi-people"></i> Danh sách Lead
    </li>
@endsection

@section('content')
<!-- Main Content Card -->
<div class="card">
    <div class="card-header bg-white border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">
                    DANH SÁCH LEAD
                </h5>
            </div>
            <a href="{{ route('leads.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Thêm Lead mới
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card-body border-bottom bg-light">
        <form action="{{ route('leads.index') }}" method="GET" class="row g-3">
            <div class="col-md-2">
                <label for="type_phone" class="form-label">
                    <i class="bi bi-telephone me-1"></i><span class="text-primary fw-bold">Số điện thoại</span>
                </label>
                <input 
                    type="text" 
                    name="type_phone" 
                    id="type_phone"
                    class="form-control" 
                    placeholder="Nhập số điện thoại..." 
                    value="{{ request('type_phone') }}"
                >
            </div>
            <div class="col-md-2">
                <label for="customer_code" class="form-label">
                    <i class="bi bi-person me-1"></i><span class="text-primary fw-bold">Mã Khách Hàng</span>
                </label>
                <input type="text" 
                    name="customer_code" 
                    id="customer_code" 
                    class="form-control" 
                    placeholder="Nhập mã khách hàng cần tìm..." 
                    value="{{ request('customer_code') }}">
            </div>
            
            
            <!-- <div class="col-md-3">
                <label for="lead_type" class="form-label">
                    <i class="bi bi-tag me-1"></i>Loại Lead
                </label>
                <select name="lead_type" id="lead_type" class="form-select">
                    <option value="">-- Tất cả loại --</option>
                    <option value="1" {{ request('lead_type') == '1' ? 'selected' : '' }}>Trực tiếp</option>
                    <option value="2" {{ request('lead_type') == '2' ? 'selected' : '' }}>Online</option>
                </select>
            </div> -->

            <div class="col-md-2">
                <label for="form_date" class="form-label">
                    <i class="bi bi-calendar me-1"></i><span class="text-primary fw-bold">Từ Ngày</span>
                </label>
                <input 
                    type="date" 
                    name="form_date" 
                    id="form_date"
                    class="form-control" 
                    value="{{ request('form_date') }}"
                >
            </div>

            <div class="col-md-2">
                <label for="to_date" class="form-label">
                    <i class="bi bi-calendar me-1"></i><span class="text-primary fw-bold">Đến Ngày</span>
                </label>
                <input 
                    type="date" 
                    name="to_date" 
                    id="to_date"
                    class="form-control" 
                    value="{{ request('to_date') }}"
                >
            </div>

            <div class="col-md-2">
                <label for="current_status" class="form-label">
                    <i class="bi bi-calendar me-1"></i><span class="text-primary fw-bold">Tình trạng hiện tại</span>
                </label>
                <select name="current_status" id="current_status" class="form-select">
                    <option value="">-- Tất cả --</option>
                    @foreach($customerStatuses as $status)
                        <option value="{{ $status->id }}" {{ request('current_status') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- lọc nguồn -->
            <div class="col-md-2">
                <label for="customer_source" class="form-label">
                    <i class="bi bi-calendar me-1"></i><span class="text-primary fw-bold">Nguồn</span>
                </label>
                <select name="customer_source" id="customer_source" class="form-select">
                    <option value="">Tất cả nguồn</option>
                    <option value="null">Chưa có nguồn</option>
                    @foreach($customerSources as $status)
                        <option value="{{ $status->id }}" {{ request('customer_source') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="sale_user" class="form-label">
                    <i class="bi bi-calendar me-1"></i><span class="text-primary fw-bold">Sale hỗ trợ</span>
                </label>
                <select name="sale_user" id="sale_user" class="form-select">
                    <option value="">-- Tất cả --</option>
                    @foreach($saleUsers as $status)
                        <option value="{{ $status->id }}" {{ request('sale_user') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="sale_information" class="form-label">
                    <i class="bi bi-calendar me-1"></i><span class="text-primary fw-bold">Sale nhận thông tin</span>
                </label>
                <select name="sale_information" id="sale_information" class="form-select">
                    <option value="">-- Tất cả --</option>
                    @foreach($saleUsers as $sales)
                        <option value="{{ $sales->id }}" {{ request('sale_information') == $sales->id ? 'selected' : '' }}>{{ $sales->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- lọc tmdt -->
            <div class="col-md-2">
                <label for="tmdt" class="form-label">
                    <i class="bi bi-calendar me-1"></i>
                    <span class="text-primary fw-bold">Đã Chuyển TMDT</span>
                </label>

                <div class="form-control d-flex align-items-center" style="height: 38px;">
                    <input type="checkbox"
                        name="tmdt"
                        id="tmdt"
                        value="TMDT"
                        {{ request('tmdt') == 'TMDT' ? 'checked' : '' }}
                        style="width:18px;height:18px;accent-color:#28a745;">
                    <label for="tmdt" class="ms-2 mb-0">TMDT</label>
                </div>
            </div>
            <!-- tìm bằng tên khách hàng -->
            <div class="col-md-3">
                <label for="customer_name" class="form-label">
                    <i class="bi bi-person me-1"></i><span class="text-primary fw-bold">Tên Khách Hàng</span>
                </label>
                <input type="text" 
                    name="customer_name" 
                    id="customer_name" 
                    class="form-control" 
                    placeholder="Nhập tên khách hàng cần tìm..." 
                    value="{{ request('customer_name') }}">
            </div>
             <!-- tìm bằng tên khách hàng -->
            <div class="col-md-3">
                <label class="form-label">
                    <i class="bi bi-calendar me-1"></i><span class="text-primary fw-bold">Danh Mục Sản Phẩm</span>
                </label>
                <div class="dropdown">
                        <button class="btn dropdown-toggle w-100" type="button" id="dropdownProductCategories" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #fff; color: #0d6efd; border: 1px solid #0d6efd; border-radius: 0.375rem;">
                            <span id="selectedProductNamesFilterBtn">
                                @php
                                    $selectedProductNames = collect($productCategories)
                                        ->whereIn('id', (array)request('productCategories', []))
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
                        <div class="dropdown-menu w-100 p-2" aria-labelledby="dropdownProductCategories" style="max-height: 300px; overflow-y: auto; background-color: #fff; color: #0d6efd;">
                            @foreach($productCategories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="productCategories[]" id="productCategory{{ $category->id }}" value="{{ $category->id }}" {{ in_array($category->id, request('productCategories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="productCategory{{ $category->id }}" style="color: #0d6efd;">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Tìm kiếm
                    </button>
                    <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i>Làm mới
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tab Navigation -->
    <div class="card-header bg-light border-bottom p-0">
        <ul class="nav nav-tabs nav-fill" id="leadTabs" role="tablist">
           
                @if($hasOnlineLead)
<li class="nav-item" role="presentation">

    <button class="nav-link"
            id="online-tab"
            data-bs-toggle="tab"
            data-bs-target="#online-pane">

        <i class="bi bi-globe me-2"></i>
        Lead Online

        <span class="badge bg-info ms-2">
            {{ $leadsOnline->total() }}
        </span>

    </button>

</li>
@endif
            
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="direct-tab" data-bs-toggle="tab" data-bs-target="#direct-pane" type="button" role="tab" aria-controls="direct-pane" aria-selected="false">
                    <i class="bi bi-telephone me-2"></i>Lead Trực tiếp
                    <span class="badge bg-warning ms-2">{{ $leads->total() }}</span>
                </button>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="leadTabsContent">
        <!-- Lead Online Tab -->
        <div class="tab-pane fade show active" id="online-pane" role="tabpanel" aria-labelledby="online-tab">
            <!-- Online Leads Table -->
            <div class="card-body p-0">
                @if($leadsOnline->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="min-width: 60px;">Mã Khách Hàng</th>
                                    <th style="min-width: 60px;">Mã Đơn Hàng</th>
                                    <th style="min-width: 120px;">Ngày tương tác đầu tiên</th>
                                    <th style="min-width: 200px;">Tên KH</th>
                                    <th style="min-width: 120px;">Điện thoại</th>
                                    <th style="min-width: 200px;">Tỉnh/Thành</th>
                                    <th style="min-width: 300px;">Địa Chỉ</th>
                                    <th style="min-width: 100px;">Zalo Feedback</th>
                                    <th style="min-width: 200px;">Phân Loại Khách Hàng</th>
                                    <th style="min-width: 200px;">Nguồn</th>
                                    <th style="min-width: 200px;">Sản Phẩm Cần Tư Vấn</th>
                                    <th style="min-width: 200px;">Tình Trạng Khách Hàng Đầu Tiên</th>
                                    <th style="min-width: 300px;">Ghi chú sale nhận khách</th>
                                    <th style="min-width: 200px;">Sale Nhận Thông Tin</th>
                                    <th style="min-width: 100px;">Sale Hỗ Trợ Khách</th>
                                    <th style="min-width: 200px;">Tình Trạng Khách Hiện Tại</th>
                                    <th style="min-width: 100px;">Giá trị đơn chốt được</th>
                                    <th style="min-width: 200px;">Thông tin trạo đổi với KH</th>
                                    <th style="min-width: 200px;">Chuyển Sang TMDT</th>
                                    <th style="min-width: 200px;">Ngày Chăm Khách Lần 1</th>
                                    <th style="min-width: 200px;">Kế hoạch lần 1</th>
                                    <th style="min-width: 200px;">Kết quả lần 1</th>
                                    <th style="min-width: 200px;">Ngày Chăm Khách Lần 2</th>
                                    <th style="min-width: 200px;">Kế hoạch lần 2</th>
                                    <th style="min-width: 200px;">Kết quả lần 2</th>
                                    <th style="min-width: 200px;">Ngày Chăm Khách Lần 3</th>
                                    <th style="min-width: 200px;">Kế hoạch lần 3</th>
                                    <th style="min-width: 200px;">Kết quả lần 3</th>
                                    <th style="min-width: 200px;">Người Tạo</th>
                                    <th style="min-width: 200px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leadsOnline as $lead)
                                    <tr class="{{ session('highlight_lead') == $lead->id ? 'table-warning' : '' }}">
                                        <td>
                                            <span class="badge bg-info">{{ $lead->customerCode->customer_code ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $lead->order_code }}
                                            </span>
                                        </td>
                                    
                                        <td>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($lead->first_interaction_date)->format('d/m/Y') }}</small>
                                        </td>
                                        
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-info-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <i class="bi bi-globe text-info"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $lead->name }}</div>
                                                    @if($lead->zalo)
                                                        <small class="text-muted">
                                                            <i class="bi bi-chat-dots me-1"></i>{{ $lead->zalo }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($lead->phones->isNotEmpty())
                                                @php
                                                    $allPhones = $lead->phones->pluck('phone')->implode(', ');
                                                    $firstPhone = $lead->phones->first()->phone;
                                                @endphp
                                                
                                                <a href="tel:{{ $firstPhone }}" 
                                                class="text-decoration-none"
                                                onclick="copyAndStop(event, this, '{{ $allPhones }}')">
                                                    <i class="bi bi-telephone me-1"></i>{{ $allPhones }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>
                                            <span class="editable-select" data-id="{{ $lead->id }}" data-field="province_id">
                                                {{ $lead->province->name ?? '-' }}
                                            </span>
                                            <select class="form-select d-none inline-select" data-id="{{ $lead->id }}" data-field="province_id">
                                                <option value="">-- Chọn --</option>
                                                @foreach($provinces as $province)
                                                    <option value="{{ $province->id }}" {{ $lead->province_id == $province->id ? 'selected' : '' }}>
                                                        {{ $province->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>


                                        <!-- <td>
                                            <small>{{ $lead->address ?? '-' }}</small>
                                        </td> -->
                                    
                                        <td>
                                            <span class="editable-text" data-id="{{ $lead->id }}" data-field="address">
                                                {{ $lead->address ?? '-' }}
                                            </span>
                                            <input type="text" class="form-control d-none inline-text" data-id="{{ $lead->id }}" data-field="address" value="{{ $lead->address }}">
                                        </td>
                                        <!-- 
                                         <td>
                                            <span class="editable-select" data-id="{{ $lead->id }}" data-field="address">
                                                {{ $lead->address ?? '-' }}
                                            </span>
                                            <select class="form-select d-none inline-select" data-id="{{ $lead->id }}" data-field="address">
                                                 <span class="text-muted">-</span>
                    
                                            </select>
                                        </td> -->

                                        

                                        <td>
                                            <a href="tel:{{ $lead->zalo }}" class="text-decoration-none">
                                                <i class="bi bi-telephone me-1"></i>{{ $lead->zalo }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="editable-select" data-id="{{ $lead->id }}" data-field="customer_type_id">
                                                {{ $lead->customerType ? $lead->customerType->name : '-' }}
                                            </span>
                                            <select class="form-select d-none inline-select" data-id="{{ $lead->id }}" data-field="customer_type_id">
                                                <option value="">-- Chọn --</option>
                                                @foreach($customerTypes as $type)
                                                    <option value="{{ $type->id }}" {{ $lead->customer_type_id == $type->id ? 'selected' : '' }}>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <span class="editable-select" data-id="{{ $lead->id }}" data-field="source_id">
                                                {{ $lead->customerSource ? $lead->customerSource->name : '-' }}
                                            </span>
                                            <select class="form-select d-none inline-select" data-id="{{ $lead->id }}" data-field="source_id">
                                                <option value="">-- Chọn --</option>
                                                @foreach($customerSources as $source)
                                                    <option value="{{ $source->id }}" {{ $lead->source_id == $source->id ? 'selected' : '' }}>
                                                        {{ $source->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <span class="editable-multi" data-id="{{ $lead->id }}" style="cursor:pointer;">
                                                @if($lead->productCategories && $lead->productCategories->count())
                                                    @foreach($lead->productCategories as $category)
                                                        <span class="badge bg-primary">{{ $category->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                                <i class="bi bi-pencil ms-1 text-warning"></i>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="editable-select" data-id="{{ $lead->id }}" data-field="first_customer_status_id">
                                                {{ $lead->firstStatus ? $lead->firstStatus->name : '-' }}
                                            </span>
                                            <select class="form-select d-none inline-select" data-id="{{ $lead->id }}" data-field="first_customer_status_id">
                                                <option value="">-- Chọn --</option>
                                                @foreach($customerStatuses as $status)
                                                    <option value="{{ $status->id }}" {{ $lead->first_customer_status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <!-- <td>
                                            <span class="editable-text" data-id="{{ $lead->id }}" data-field="note">
                                                {{ $lead->note ?? '-' }}
                                            </span>
                                            <input type="text" class="form-control d-none inline-text" data-id="{{ $lead->id }}" data-field="note" value="{{ $lead->note }}">
                                        </td>   -->
                                        
                                        <td>
                                            @if($lead->note)
                                                <small class="d-inline-block text-truncate" 
                                                    style="max-width: 150px; cursor: pointer;" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="right" 
                                                    title="{{ $lead->note }}">
                                                    {{ $lead->note }}
                                                </small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>


                                        <td>
                                            <span class="editable-select" data-id="{{ $lead->id }}" data-field="sale_information_id">
                                                {{ $lead->saleInformation ? $lead->saleInformation->name : '-' }}
                                            </span>
                                            <select class="form-select d-none inline-select" data-id="{{ $lead->id }}" data-field="sale_information_id">
                                                <option value="">-- Chọn --</option>
                                                @foreach($saleUsers as $user)
                                                    <option value="{{ $user->id }}" {{ $lead->sale_information_id == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                                    

                                        <!-- <td>
                                            @if($lead->saleInformation)
                                                <small>{{ $lead->saleInformation->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td> -->
                                        <td>
                                            <span class="editable-select" data-id="{{ $lead->id }}" data-field="sale_support_id">
                                                {{ $lead->saleSupport ? $lead->saleSupport->name : '-' }}
                                            </span>
                                            <select class="form-select d-none inline-select" data-id="{{ $lead->id }}" data-field="sale_support_id">
                                                <option value="">-- Chọn --</option>
                                                @foreach($saleUsers as $user)
                                                    <option value="{{ $user->id }}" {{ $lead->sale_support_id == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                         <!-- <td>
                                            @if($lead->saleSupport)
                                                <small>{{ $lead->saleSupport->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td> -->
                                        <td>
                                            <span class="editable-select" data-id="{{ $lead->id }}" data-field="current_customer_status_id">
                                                {{ $lead->currentStatus ? $lead->currentStatus->name : '-' }}
                                            </span>
                                            <select class="form-select d-none inline-select" data-id="{{ $lead->id }}" data-field="current_customer_status_id">
                                                <option value="">-- Chọn --</option>
                                                @foreach($customerStatuses as $status)
                                                    <option value="{{ $status->id }}" {{ $lead->current_customer_status_id == $status->id ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>

                                         <td>
                                            <span class="editable-text" data-id="{{ $lead->id }}" data-field="order_value">
                                                {{ number_format($lead->order_value) ?? '-' }}
                                            </span>
                                            <input type="text" class="form-control d-none inline-text" data-id="{{ $lead->id }}" data-field="order_value" value="{{ $lead->order_value }}">
                                        </td>
                                        <!-- <td>
                                            @if($lead->currentStatus)
                                                <small>
                                                    {{-- Hiển thị tên nếu có, nếu không thì show toàn bộ object để debug --}}
                                                    {{ isset($lead->currentStatus->name) ? $lead->currentStatus->name : json_encode($lead->currentStatus) }}
                                                </small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td> -->

                                        <!-- <td>
                                            @if($lead->customerStatuses)
                                                <small>{{ $lead->customerStatuses->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td> -->
                                        <!-- <td>
                                            @if($lead->customer_discussion_details)
                                                <small>{{ $lead->customer_discussion_details }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td> -->
                                        <td>
                                            <span class="editable-text" data-id="{{ $lead->id }}" data-field="customer_discussion_details">
                                                {{ $lead->customer_discussion_details ?? '-' }}
                                            </span>
                                            <input type="text" class="form-control d-none inline-text" data-id="{{ $lead->id }}" data-field="customer_discussion_details" value="{{ $lead->customer_discussion_details }}">
                                        </td>

                                    

                                        <td>
                                            <input type="checkbox" disabled {{ $lead->tmdt == 'TMDT' ? 'checked' : '' }} style="accent-color: #28a745;">
                                        </td>

                                        <!-- Chăm Khách 3 lần -->

                                            @php
                                                // Lấy tối đa 3 bản ghi chăm sóc của lead
                                                $cares = $lead->leadTakeCares->take(3);
                                            @endphp
                                            @for ($i = 0; $i < 3; $i++)
                                                @php
                                                    $care = $cares[$i] ?? null;
                                                    $careId = $care?->id ?? '';
                                                    $careDate = $care?->take_care_date ?? '';
                                                    $carePlan = $care?->take_care_plan ?? '';
                                                    $careResult = $care?->take_care_result ?? '';
                                                @endphp
                                                <td>
                                                    <span class="editable-text" data-id="{{ $careId }}" data-field="take_care_date" data-index="{{ $i }}" data-lead-id="{{ $lead->id }}">
                                                        {{ $careDate ? date('d/m/Y', strtotime($careDate)) : '-' }}
                                                    </span>
                                                <input type="date" class="form-control d-none inline-text" data-id="{{ $careId }}" data-field="take_care_date" data-index="{{ $i }}" data-lead-id="{{ $lead->id }}" value="{{ $careDate ? \Carbon\Carbon::parse($careDate)->format('Y-m-d') : '' }}">
                                                </td>
                                                <td>
                                                    <span class="editable-text" data-id="{{ $careId }}" data-field="take_care_plan" data-index="{{ $i }}" data-lead-id="{{ $lead->id }}">
                                                        {{ $carePlan !== '' ? $carePlan : '-' }}
                                                    </span>
                                                    <input type="text" class="form-control d-none inline-text" data-id="{{ $careId }}" data-field="take_care_plan" data-index="{{ $i }}" data-lead-id="{{ $lead->id }}" value="{{ $carePlan }}">
                                                </td>
                                                <td>
                                                    <span class="editable-text" data-id="{{ $careId }}" data-field="take_care_result" data-index="{{ $i }}" data-lead-id="{{ $lead->id }}">
                                                        {{ $careResult !== '' ? $careResult : '-' }}
                                                    </span>
                                                    <input type="text" class="form-control d-none inline-text" data-id="{{ $careId }}" data-field="take_care_result" data-index="{{ $i }}" data-lead-id="{{ $lead->id }}" value="{{ $careResult }}">
                                                </td>
                                            @endfor
                                         <!-- Chăm Khách 3 lần -->
                                                <td>
                                                    @if($lead->creator)
                                                        <small>{{ $lead->creator->name }}</small>
                                                    @endif
                                                </td>

                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('leads.show', $lead->id) . '?' . http_build_query(request()->query()) }}" 
                                                    class="btn btn-sm btn-outline-info" 
                                                    title="Xem chi tiết">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('leads.edit', $lead->id) . '?' . http_build_query(request()->query()) }}"
                                                    class="btn btn-sm btn-outline-warning" 
                                                    title="Chỉnh sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                 <a href="{{ route('leads.create', ['customer_id' => $lead->customer_id]) }}" class="btn btn-sm btn-primary">
                                                    + Thêm đơn mới
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Xóa"
                                                        onclick="confirmDelete({{ $lead->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Hidden Delete Form -->
                                            <form id="delete-form-{{ $lead->id }}" 
                                                    action="{{ route('leads.destroy', $lead->id) }}" 
                                                    method="POST" 
                                                    class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div class="text-muted">
                            Hiển thị {{ $leadsOnline->firstItem() ?: 0 }} - {{ $leadsOnline->lastItem() ?: 0 }} trên {{ $leadsOnline->total() }} kết quả
                        </div>
                        <div>
                            {!! $leadsOnline->appends(request()->query())->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>

                @else
                    <div class="text-center py-5">
                        <i class="bi bi-globe display-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">Không có Lead Online</h5>
                        <p class="text-muted">Chưa có lead online nào được tạo.</p>
                        <a href="{{ route('leads.create') }}" class="btn btn-info">
                            <i class="bi bi-plus-circle me-2"></i>Tạo Lead Online đầu tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Lead Trực tiếp Tab -->
        <div class="tab-pane fade" id="direct-pane" role="tabpanel" aria-labelledby="direct-tab">
            <!-- Direct Leads Table -->
            <div class="card-body p-0">
                @if($leads->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="min-width: 60px;">Mã Khách Hàng</th>
                                    <th style="min-width: 60px;">Mã Đơn Hàng</th>
                                    <th style="min-width: 120px;">Ngày</th>
                                    <th style="min-width: 200px;">Tên KH</th>
                                    <th style="min-width: 120px;">Điện thoại</th>
                                    <th style="min-width: 100px;">Tỉnh/Thành</th>
                                    <th style="min-width: 300px;">Địa Chỉ</th>
                                    <th style="min-width: 100px;">Zalo Feedback</th>
                                    <th style="min-width: 100px;">Phân Loại Khách Hàng</th>
                                    <th style="min-width: 100px;">Showroom</th>
                                    <th style="min-width: 100px;">Sản Phẩm Cần Tư Vấn</th>
                                    <th style="min-width: 100px;">Ghi chú sale nhận khách</th>
                                    <th style="min-width: 100px;">Sale Nhận Thông Tin</th>
                                    <th style="min-width: 100px;">Tình Trạng Khách Hiện Tại</th>
                                    <th style="min-width: 100px;">KH đã được hỗ trợ trước qua kênh nào?</th>
                                    <th style="min-width: 100px;">Giá trị đơn chốt được</th>
                                    <th style="min-width: 100px;">Chuyển Sang TMDT</th>
                                    <th style="min-width: 200px;">Người Tạo</th>
                                    <th style="min-width: 100px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leads as $lead)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">{{ $lead->customerCode->customer_code ?? 'N/A' }}</span>
                                        </td>
                                         <td>
                                            <span class="badge bg-info">{{ $lead->order_code }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($lead->first_interaction_date)->format('d/m/Y') }}</small>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-info-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <i class="bi bi-globe text-info"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $lead->name }}</div>
                                                    @if($lead->zalo)
                                                        <small class="text-muted">
                                                            <i class="bi bi-chat-dots me-1"></i>{{ $lead->zalo }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                       
                                        <td>
                                            @if($lead->phones->isNotEmpty())
                                                @php
                                                    $allPhones = $lead->phones->pluck('phone')->implode(', ');
                                                    $firstPhone = $lead->phones->first()->phone;
                                                @endphp
                                                
                                                <a href="tel:{{ $firstPhone }}" 
                                                class="text-decoration-none"
                                                onclick="copyAndStop(event, this, '{{ $allPhones }}')">
                                                    <i class="bi bi-telephone me-1"></i>{{ $allPhones }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        
                                         <td>
                                            <small>{{ $lead->province->name ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <small>{{ $lead->address ?? '-' }}</small>
                                        </td>

                                        <td>
                                            <a href="tel:{{ $lead->zalo }}" class="text-decoration-none">
                                                <i class="bi bi-telephone me-1"></i>{{ $lead->zalo }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($lead->customerType)
                                                <span class="badge bg-info">{{ $lead->customerType->name }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                            
                                        <td>
                                            @if($lead->showroom)
                                                <small>{{ $lead->showroom->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lead->productCategories && $lead->productCategories->count())
                                                @foreach($lead->productCategories as $category)
                                                    <span class="badge bg-primary">{{ $category->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                       

                                        <!-- <td>
                                            @if($lead->note)
                                                <small>{{ $lead->note }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td> -->
                                        <td>
                                            @if($lead->note)
                                                <small class="d-inline-block text-truncate" 
                                                    style="max-width: 150px; cursor: pointer;" 
                                                    data-bs-toggle="tooltip" 
                                                    data-bs-placement="right" 
                                                    title="{{ $lead->note }}">
                                                    {{ $lead->note }}
                                                </small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lead->saleInformation)
                                                <small>{{ $lead->saleInformation->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        
                                    
                                        <td>
                                            @if($lead->currentStatus)
                                                <small>{{ $lead->currentStatus->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                       
                                        <td>
                                            <small>{{ $lead->supportedChannel ? $lead->supportedChannel->name : '-' }}</small>
                                        </td>

                                    
                                        <td>
                                            @if($lead->order_value)
                                                <span class="fw-medium text-success">{{ number_format($lead->order_value) }}đ</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        <td>
                                            <input type="checkbox" disabled {{ $lead->tmdt == 'TMDT' ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            @if($lead->creator)
                                                <small>{{ $lead->creator->name }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('leads.show', $lead->id) . '?' . http_build_query(request()->query()) }}"
                                                    class="btn btn-sm btn-outline-info" 
                                                    title="Xem chi tiết">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                 <a href="{{ route('leads.edit', $lead->id) . '?' . http_build_query(request()->query()) }}"
                                                    class="btn btn-sm btn-outline-warning" 
                                                    title="Chỉnh sửa">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="{{ route('leads.create', ['customer_id' => $lead->customer_id]) }}" class="btn btn-sm btn-primary">
                                                    + Thêm đơn mới
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Xóa"
                                                        onclick="confirmDelete({{ $lead->id }})">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                            
                                            
                                            <!-- Hidden Delete Form -->
                                            <form id="delete-form-{{ $lead->id }}" 
                                                    action="{{ route('leads.destroy', $lead->id) }}" 
                                                    method="POST" 
                                                    class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div class="text-muted">
                            Hiển thị {{ $leads->firstItem() ?: 0 }} - {{ $leads->lastItem() ?: 0 }} trên {{ $leads->total() }} kết quả
                        </div>
                        <div>
                            {!! $leads->appends(request()->query())->links('pagination::bootstrap-5') !!}
                        </div>
                    </div>

                @else
                    <div class="text-center py-5">
                        <i class="bi bi-telephone display-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">Không có Lead Trực tiếp</h5>
                        <p class="text-muted">Chưa có lead trực tiếp nào được tạo.</p>
                        <a href="{{ route('leads.create') }}" class="btn btn-warning">
                            <i class="bi bi-plus-circle me-2"></i>Tạo Lead Trực tiếp đầu tiên
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(isset($careOnline) && $careOnline->count())
        <div class="alert alert-success">
            <strong>Thông báo:</strong> Có {{ $careOnline->count() }} khách online đến ngày chăm sóc hôm nay!
            <ul>
                @foreach($careOnline as $care)
                    <li>
                        {{ $care->lead->name ?? 'Khách' }} - {{ $care->take_care_plan }} ({{ $care->take_care_date }})
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    Xác nhận xóa Lead
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa Lead này và tất cả dữ liệu chăm sóc liên quan?</p>
                <p class="text-muted small">Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa Lead</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(leadId) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    
    confirmBtn.onclick = function() {
        document.getElementById('delete-form-' + leadId).submit();
    };
    
    modal.show();
}

setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);

document.addEventListener('DOMContentLoaded', function() {
    const leadTypeSelect = document.getElementById('lead_type');
    const onlineTab = document.getElementById('online-tab');
    const directTab = document.getElementById('direct-tab');
    
    if (leadTypeSelect && onlineTab && directTab) {
        leadTypeSelect.addEventListener('change', function() {
            const selectedValue = this.value;
            
            if (selectedValue === '2') {
                const onlineTabTrigger = new bootstrap.Tab(onlineTab);
                onlineTabTrigger.show();
            } else if (selectedValue === '1') {
                const directTabTrigger = new bootstrap.Tab(directTab);
                directTabTrigger.show();
            }
        });
        
        const currentLeadType = leadTypeSelect.value;
        if (currentLeadType === '2') {
            const onlineTabTrigger = new bootstrap.Tab(onlineTab);
            onlineTabTrigger.show();
        } else if (currentLeadType === '1') {
            const directTabTrigger = new bootstrap.Tab(directTab);
            directTabTrigger.show();
        }
    }
});



// Inline edit for select fields
$(document).on('click', '.editable-select', function() {
    $(this).addClass('d-none');
    $(this).siblings('.inline-select').removeClass('d-none').focus();
});

$(document).on('change blur', '.inline-select', function () {
    let id = $(this).data('id');
    let field = $(this).data('field');
    let value = $(this).val();
    let text = $(this).find("option:selected").text();
    $.post("/lead/update-inline/" + id, {
        field: field,
        value: value,
        _token: "{{ csrf_token() }}"
    }, () => {
        let span = $(this).siblings('.editable-select');
        span.text(text);
        span.removeClass('d-none');
        $(this).addClass('d-none');
    });
});

// Inline edit for text fields
$(document).on('click', '.editable-text', function() {
    $(this).addClass('d-none');
    $(this).siblings('.inline-text').removeClass('d-none').focus();
});

$(document).on('change blur', '.inline-text', function () {
    let id = $(this).data('id');
    let field = $(this).data('field');
    let value = $(this).val();
    let index = $(this).data('index');
    let leadId = $(this).data('lead-id');
    // Nếu là trường của LeadTakeCare thì gửi về route riêng
    const takeCareFields = ['take_care_date', 'take_care_plan', 'take_care_result'];
    let url = takeCareFields.includes(field)
        ? "/lead-take-care/update-inline/" + (id ? id : '')
        : "/lead/update-inline/" + id;
    let data = {
        field: field,
        value: value,
        _token: "{{ csrf_token() }}"
    };
    if (takeCareFields.includes(field) && !id) {
        data.lead_id = leadId;
        data.index = index;
    }
    $.post(url, data, (res) => {
        let span = $(this).siblings('.editable-text');
        span.text(value);
        span.removeClass('d-none');
        $(this).addClass('d-none');
        // Kiểm tra response trả về
        console.log('LeadTakeCare inline response:', res);
        if (res && res.id) {
            $(this).attr('data-id', res.id);
            span.attr('data-id', res.id);
        }
    });
});

// ----------------------
// -- productCategories --
// ----------------------

// Khi click mở modal
$('.editable-multi').on('click', function () {
    let id = $(this).data('id');
    $('#modalLeadId').val(id);

    $.get("/lead/get-categories/" + id, function (selected) {
        $('.category-check').prop('checked', false);
        selected.forEach(id => {
            $('.category-check[value="' + id + '"]').prop('checked', true);
        });
        $('#categoryModal').modal('show');
    });
});

// Lưu thay đổi nhiều–nhiều
$('#saveCategory').on('click', function() {
    let id = $('#modalLeadId').val();
    let categories = [];

    $('.category-check:checked').each(function () {
        categories.push($(this).val());
    });

    $.post("/lead/update-categories/" + id, {
        categories: categories,
        _token: "{{ csrf_token() }}"
    }, function () {
        location.reload();
    });
});

// copy sdt

function copyAndStop(event, element, text) {
    // Dòng này cực kỳ quan trọng để chặn trình duyệt mở ứng dụng gọi điện
    event.preventDefault(); 

    navigator.clipboard.writeText(text).then(() => {
        const originalHTML = element.innerHTML;
        element.innerHTML = '<i class="bi bi-check-lg me-1"></i> Đã sao chép';
        element.style.color = '#28a745'; // Đổi sang màu xanh lá báo hiệu thành công

        setTimeout(() => {
            element.innerHTML = originalHTML;
            element.style.color = ''; // Trả về màu mặc định
        }, 1500);
    }).catch(err => {
        // Nếu trình duyệt lỗi không copy được, lúc đó mới cho phép gọi điện
        window.location.href = element.href;
    });
}

$(document).ready(function() {
    // Cấu hình trigger là 'manual' để tự kiểm soát bằng code
    $('body').tooltip({
        selector: '[data-bs-toggle="tooltip"]',
        trigger: 'manual' 
    });

    // Lắng nghe sự kiện nhấp đúp chuột (dblclick) trên toàn bộ trang
    $('body').on('dblclick', '[data-bs-toggle="tooltip"]', function() {
        // Toggle (Bật/Tắt) tooltip khi double click
        $(this).tooltip('toggle');
    });

    // Tự động ẩn tooltip nếu người dùng click ra ngoài khu vực ghi chú
    $(document).on('click', function (e) {
        if (!$(e.target).closest('[data-bs-toggle="tooltip"]').length) {
            $('[data-bs-toggle="tooltip"]').tooltip('hide');
        }
    });
});
</script>

@endpush

<div class="modal fade" id="categoryModal">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <h5>Chọn Danh Mục Sản Phẩm</h5>

            <input type="hidden" id="modalLeadId">

            <div id="categoryCheckboxList">
                @foreach($productCategories as $cat)
                    <div class="form-check">
                        <input class="form-check-input category-check" 
                               type="checkbox"
                               value="{{ $cat->id }}">
                        <label class="form-check-label">{{ $cat->name }}</label>
                    </div>
                @endforeach
            </div>

            <button class="btn btn-primary mt-3 w-100" id="saveCategory">Lưu</button>
        </div>
    </div>
</div>