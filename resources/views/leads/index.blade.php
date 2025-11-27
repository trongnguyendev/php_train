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
            <div class="col-md-3">
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

            <div class="col-md-3">
                <label for="first_arrival_date" class="form-label">
                    <i class="bi bi-calendar me-1"></i><span class="text-primary fw-bold">Từ Ngày</span>
                </label>
                <input 
                    type="date" 
                    name="first_arrival_date" 
                    id="form_date"
                    class="form-control" 
                    value="{{ request('first_arrival_date') }}"
                >
            </div>

            <div class="col-md-3">
                <label for="first_arrival_date" class="form-label">
                    <i class="bi bi-calendar me-1"></i><span class="text-primary fw-bold">Đến Ngày</span>
                </label>
                <input 
                    type="date" 
                    name="first_arrival_date" 
                    id="todate"
                    class="form-control" 
                    value="{{ request('first_arrival_date') }}"
                >
            </div>

            <div class="col-md-3">
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
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="online-tab" data-bs-toggle="tab" data-bs-target="#online-pane" type="button" role="tab" aria-controls="online-pane" aria-selected="true">
                    <i class="bi bi-globe me-2"></i>Lead Online
                    <span class="badge bg-info ms-2">{{ $leadsOnline->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="direct-tab" data-bs-toggle="tab" data-bs-target="#direct-pane" type="button" role="tab" aria-controls="direct-pane" aria-selected="false">
                    <i class="bi bi-telephone me-2"></i>Lead Trực tiếp
                    <span class="badge bg-warning ms-2">{{ $leads->count() }}</span>
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
                                    <th style="min-width: 60px;">ID</th>
                                    <th style="min-width: 120px;">Ngày</th>
                                    <th style="min-width: 200px;">Tên KH</th>
                                    <th style="min-width: 120px;">Điện thoại</th>
                                    <th style="min-width: 200px;">Tỉnh/Thành</th>
                                    <th style="min-width: 300px;">Địa Chỉ</th>
                                    <th style="min-width: 100px;">Zalo Feedback</th>
                                    <th style="min-width: 100px;">Khách Hàng Đã Đặt Hàng Chưa?</th>
                                    <th style="min-width: 200px;">Phân Loại Khách Hàng</th>
                                    <th style="min-width: 100px;">Nguồn</th>
                                    <th style="min-width: 200px;">Sản Phẩm Cần Tư Vấn</th>
                                    <th style="min-width: 200px;">Tình Trạng Khách Hàng Đầu Tiên</th>
                                    <th style="min-width: 300px;">Note</th>
                                    <th style="min-width: 200px;">Sale Nhận Thông Tin</th>
                                    <th style="min-width: 100px;">Sale Hỗ Trợ Khách</th>
                                    <th style="min-width: 200px;">Tình Trạng Khách Hiện Tại</th>
                                    <th style="min-width: 200px;">Thông tin trạo đổi với KH</th>
                                    <th style="min-width: 300px;">Kết Quả</th>
                                    <th style="min-width: 200px;">Ngày Chăm Khách Lần 1</th>
                                    <th style="min-width: 200px;">Kế hoạch lần 1</th>
                                    <th style="min-width: 200px;">Kết quả lần 1</th>
                                    <th style="min-width: 200px;">Ngày Chăm Khách Lần 2</th>
                                    <th style="min-width: 200px;">Kế hoạch lần 2</th>
                                    <th style="min-width: 200px;">Kết quả lần 2</th>
                                    <th style="min-width: 200px;">Ngày Chăm Khách Lần 3</th>
                                    <th style="min-width: 200px;">Kế hoạch lần 3</th>
                                    <th style="min-width: 200px;">Kết quả lần 3</th>
                                    <th style="min-width: 200px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leadsOnline as $lead)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">#{{ $lead->id }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($lead->first_arrival_date)->format('d/m/Y') }}</small>
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
                                            <a href="tel:{{ $lead->phone }}" class="text-decoration-none">
                                                <i class="bi bi-telephone me-1"></i>{{ $lead->phone }}
                                            </a>
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
                                            @if($lead->is_new_customer)
                                                <span class="badge bg-success">Khách Hàng Mới</span>
                                            @else
                                                <span class="badge bg-secondary">Khách Hàng Cũ</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lead->customerSource)
                                                <small>{{ $lead->customerSource->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                            php artisan make:migration create_lead_product_category_table --create=lead_product_category
                                        <td>
                                            @if($lead->productCategories && $lead->productCategories->count())
                                                @foreach($lead->productCategories as $category)
                                                    <span class="badge bg-primary">{{ $category->name }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($lead->firstStatus)
                                                <small>{{ $lead->firstStatus->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                         <td>
                                            @if($lead->note)
                                                <small>{{ $lead->note }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lead->saleReceive)
                                                <small>{{ $lead->saleReceive->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                         <td>
                                            @if($lead->saleSupport)
                                                <small>{{ $lead->saleSupport->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lead->currentStatus)
                                                <small>{{ $lead->currentStatus->name }}</small>
                                            @else
                                                <small class="text-muted">-</small>
                                            @endif
                                        </td>

                                        <!-- <td>
                                            @if($lead->customerStatuses)
                                                <small>{{ $lead->customerStatuses->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td> -->
                                        <td>
                                            @if($lead->exchange_content)
                                                <small>{{ $lead->exchange_content }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                         </td>
                                        <td>
                                            @if($lead->order_value)
                                                <span class="fw-medium text-success">{{ number_format($lead->order_value) }}đ</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        <!-- Chăm Khách 3 lần -->
                                            @php
                                                // Lấy tối đa 3 bản ghi chăm sóc của lead
                                                $cares = $lead->leadTakeCares->take(3);
                                            @endphp
                                                @for ($i = 0; $i < 3; $i++)
                                                    @php
                                                        $care = $cares[$i] ?? null;
                                                    @endphp

                                                    <td>{{ $care?->take_care_date ? date('d/m/Y', strtotime($care->take_care_date)) : '-' }}</td>
                                                    <td>{{ $care?->take_care_plan ?? '-' }}</td>
                                                    <td>{{ $care?->take_care_result ?? '-' }}</td>
                                                @endfor
                                         <!-- Chăm Khách 3 lần -->

                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('leads.show', $lead->id) }}" 
                                                    class="btn btn-sm btn-outline-info" 
                                                    title="Xem chi tiết">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('leads.edit', $lead->id) }}" 
                                                    class="btn btn-sm btn-outline-warning" 
                                                    title="Chỉnh sửa">
                                                    <i class="bi bi-pencil"></i>
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
                                    <th style="min-width: 60px;">ID</th>
                                    <th style="min-width: 120px;">Ngày</th>
                                    <th style="min-width: 200px;">Tên KH</th>
                                    <th style="min-width: 120px;">Điện thoại</th>
                                    <th style="min-width: 100px;">Tỉnh/Thành</th>
                                    <th style="min-width: 300px;">Địa Chỉ</th>
                                    <th style="min-width: 100px;">Zalo Feedback</th>
                                    <th style="min-width: 100px;">Khách Hàng Đã Đặt Hàng Chưa?</th>
                                    <th style="min-width: 100px;">Phân Loại Khách Hàng</th>
                                    <th style="min-width: 100px;">Nguồn</th>
                                    <th style="min-width: 100px;">Sản Phẩm Cần Tư Vấn</th>
                                    <th style="min-width: 100px;">Tình Trạng Khách Hàng Đầu Tiên</th>
                                    <th style="min-width: 100px;">Note</th>
                                    <th style="min-width: 100px;">Sale Nhận Thông Tin</th>
                                    <th style="min-width: 100px;">Sale Hỗ Trợ Khách</th>
                                    <th style="min-width: 100px;">Tình Trạng Khách Hiện Tại</th>
                                    <th style="min-width: 100px;">Thông tin trạo đổi với KH</th>
                                    <th style="min-width: 100px;">Kết Quả</th>
                                    <th style="min-width: 100px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leads as $lead)
                                    <tr>
                                        <td>
                                            <span class="badge bg-info">#{{ $lead->id }}</span>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($lead->first_arrival_date)->format('d/m/Y') }}</small>
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
                                            <a href="tel:{{ $lead->phone }}" class="text-decoration-none">
                                                <i class="bi bi-telephone me-1"></i>{{ $lead->phone }}
                                            </a>
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
                                            @if($lead->is_new_customer)
                                                <span class="badge bg-success">Khách Hàng Mới</span>
                                            @else
                                                <span class="badge bg-secondary">Khách Hàng Cũ</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lead->customerSource)
                                                <small>{{ $lead->customerSource->name }}</small>
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
                                        <td>
                                            @if($lead->firstStatus)
                                                <small>{{ $lead->firstStatus->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if($lead->note)
                                                <small>{{ $lead->note }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($lead->saleReceive)
                                                <small>{{ $lead->saleReceive->name }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                         <td>
                                            @if($lead->saleSupport)
                                                <small>{{ $lead->saleSupport->name }}</small>
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
                                    
                                        <td>
                                            @if($lead->exchange_content)
                                                <small>{{ $lead->exchange_content }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                         </td>
                                        <td>
                                            @if($lead->order_value)
                                                <span class="fw-medium text-success">{{ number_format($lead->order_value) }}đ</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('leads.show', $lead->id) }}" 
                                                    class="btn btn-sm btn-outline-info" 
                                                    title="Xem chi tiết">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('leads.edit', $lead->id) }}" 
                                                    class="btn btn-sm btn-outline-warning" 
                                                    title="Chỉnh sửa">
                                                    <i class="bi bi-pencil"></i>
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
document.addEventListener('DOMContentLoaded', function() {
    // Update product category button text when checkboxes change (filter)
    const productCheckboxesFilter = document.querySelectorAll('input[name="productCategories[]"]');
    const productNamesFilterBtn = document.getElementById('selectedProductNamesFilterBtn');
    const productLabelsFilter = {};
    @foreach($productCategories as $cat)
        productLabelsFilter[{{ $cat->id }}] = @json($cat->name);
    @endforeach

    function updateProductNamesFilterBtn() {
        const checked = Array.from(productCheckboxesFilter).filter(cb => cb.checked).map(cb => productLabelsFilter[cb.value]);
        if (checked.length) {
            productNamesFilterBtn.textContent = checked.join(', ');
        } else {
            productNamesFilterBtn.textContent = 'Chọn danh mục sản phẩm';
        }
    }
    productCheckboxesFilter.forEach(cb => {
        cb.addEventListener('change', updateProductNamesFilterBtn);
    });
    // Initial update
    updateProductNamesFilterBtn();
});
</script>
@endpush

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
</script>
@endpush
