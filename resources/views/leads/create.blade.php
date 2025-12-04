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
                        <div class="col-md-4">
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
                        <div class="col-md-6">
                            <label for="customer_visit_date" class="form-label">
                                <i class="bi bi-calendar me-1"></i><span class="text-primary fw-bold">Ngày khách đến lần đầu</span>
                            </label>
                            <input type="date" name="customer_visit_date" id="customer_visit_date" 
                                    class="form-control @error('customer_visit_date') is-invalid @enderror"
                                    value="{{ old('customer_visit_date') }}">
                            @error('customer_visit_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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

                        <div class="col-md-6">
                            <label for="phone" class="form-label">
                                <i class="bi bi-telephone me-1"></i><span class="text-primary fw-bold">Số điện thoại</span>
                            </label>
                            <input type="text" name="phone" id="phone" 
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" placeholder="Nhập số điện thoại">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
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
                                <i class="bi bi-tag me-1"></i><span class="text-primary fw-bold">Loại khách hàng</span>
                            </label>
                            <select name="customer_type_id" id="customer_type_id" 
                                    class="form-select @error('customer_type_id') is-invalid @enderror">
                                <option value="">-- Chọn loại khách --</option>
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

                        <!-- <div class="col-md-4">
                            <label for="is_new_customer" class="form-label">
                                <i class="bi bi-person-check me-1"></i><span class="text-primary fw-bold">Khách hàng mới?</span>
                            </label>
                            <select name="is_new_customer" id="is_new_customer" 
                                    class="form-select @error('is_new_customer') is-invalid @enderror">
                                <option value="1" {{ old('is_new_customer', '1') == '1' ? 'selected' : '' }}>Có</option>
                                <option value="0" {{ old('is_new_customer') == '0' ? 'selected' : '' }}>Không</option>
                            </select>
                            @error('is_new_customer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> -->

                        <div class="col-md-4" id="source-field">
                            <label for="source_id" class="form-label">
                                <i class="bi bi-funnel me-1"></i><span class="text-primary fw-bold">Nguồn</span>
                            </label>
                            <select name="source_id" id="source_id" 
                                    class="form-select @error('source_id') is-invalid @enderror">
                                <option value="">-- Chọn nguồn --</option>
                                @foreach($customerSources as $src)
                                    <option value="{{ $src->id }}" {{ old('source_id') == $src->id ? 'selected' : '' }}>
                                        {{ $src->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('source_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Business Information -->
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="bi bi-funnel me-1"></i><span class="text-primary fw-bold">Danh mục sản phẩm</span>
                            </label>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle w-100" type="button" id="dropdownProductCategoriesCreate" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #fff; color: #0d6efd; border: 1px solid #717375ff; border-radius: 0.375rem;">
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
                                <div class="dropdown-menu w-100 p-2" aria-labelledby="dropdownProductCategoriesCreate" style="max-height: 300px; overflow-y: auto; background-color: #ffffffff; color: #fff;">
                                    @foreach($productCategories as $cat)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="product_category_ids[]" id="product_category_{{ $cat->id }}" value="{{ $cat->id }}" {{ (collect(old('product_category_ids', []))->contains($cat->id)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="product_category_{{ $cat->id }}" style="color: #1215ddff;">
                                                {{ $cat->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('product_category_ids')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4" id="showroom-field" style="display: {{ old('lead_type', '1') == '2' ? 'none' : 'block' }};">
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

                        <div class="col-md-4" id="order-value-field" style="display: {{ old('lead_type', '1') == '2' ? 'none' : 'block' }};">
                            <label for="order_value" class="form-label">
                                <i class="bi bi-currency-dollar me-1"></i><span class="text-primary fw-bold">Giá trị đơn chốt được</span>
                            </label>
                            <input type="number" name="order_value" id="order_value" 
                                    class="form-control @error('order_value') is-invalid @enderror"
                                    value="{{ old('order_value') }}" placeholder="Nhập giá trị đơn chốt được">
                            @error('order_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Information -->
                        <div class="col-md-4">
                            <label for="first_customer_status_id" class="form-label">
                                <i class="bi bi-flag me-1"></i><span class="text-primary fw-bold">Tình trạng KH ban đầu</span>
                            </label>
                            <select name="first_customer_status_id" id="first_customer_status_id" 
                                    class="form-select @error('first_customer_status_id') is-invalid @enderror">
                                <option value="">-- Chọn tình trạng --</option>
                                @foreach($customerStatuses as $st)
                                    <option value="{{ $st->id }}" {{ old('first_customer_status_id') == $st->id ? 'selected' : '' }}>
                                        {{ $st->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('first_customer_status_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
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
                        <!-- <div class="col-md-4">
                            <label for="support_status_customer_id" class="form-label">
                                <i class="bi bi-flag-fill me-1"></i><span class="text-primary fw-bold">Tình trạng hỗ trợ</span>
                            </label>
                            <select name="support_status_customer_id" id="support_status_customer_id" 
                                    class="form-select @error('support_status_customer_id') is-invalid @enderror">
                                <option value="">-- Chọn tình trạng --</option>
                                @foreach($customerStatuses as $st)
                                    <option value="{{ $st->id }}" {{ old('support_status_customer_id') == $st->id ? 'selected' : '' }}>
                                        {{ $st->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('support_status_customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div> -->


                        <!-- Sales Team -->
                        <div class="col-md-4">
                            <label for="sale_information_id" class="form-label">
                                <i class="bi bi-person-badge me-1"></i><span class="text-primary fw-bold">Sale nhận KH</span>
                            </label>
                            <select name="sale_information_id" id="sale_information_id" 
                                    class="form-select @error('sale_information_id') is-invalid @enderror">
                                <option value="">-- Chọn sale nhận --</option>
                                @foreach($saleInformation as $s)
                                    <option value="{{ $s->id }}" {{ old('sale_information_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sale_information_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4" id="sale-support-field">
                            <label for="sale_support_id" class="form-label">
                                <i class="bi bi-headset me-1"></i><span class="text-primary fw-bold">Sale hỗ trợ</span>
                            </label>
                            <select name="sale_support_id" id="sale_support_id" 
                                    class="form-select @error('sale_support_id') is-invalid @enderror">
                                <option value="">-- Chọn sale hỗ trợ --</option>
                                @foreach($saleSupport as $s)
                                    <option value="{{ $s->id }}" {{ old('sale_support_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sale_support_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes and Results -->
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

            
                        <div class="col-md-4" id="support_channel-field" style="display: {{ old('lead_type', '1') == '1' ? 'block' : 'none' }};">
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

                        <div class="col-md-6" id="customer_discussion_details-field" style="display: {{ old('lead_type', '1') == '2' ? 'block' : 'none' }};">
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

                        <div class="col-12">
                            <label for="results" class="form-label">
                                <i class="bi bi-trophy me-1"></i><span class="text-primary fw-bold">Kết quả</span>
                            </label>
                            <textarea name="results" id="results" rows="5" 
                                        class="form-control @error('results') is-invalid @enderror"
                                        placeholder="Nhập kết quả đạt được">{{ old('results') }}</textarea>
                            @error('results')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                            <h5 class="mb-1">Thông tin chăm sóc khách hàng</h5>
                            <p class="text-muted mb-0">Lập kế hoạch chăm sóc khách hàng (3 lần)</p>
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
        if (orderValueField) {
            orderValueField.style.display = isOnline ? 'none' : 'block';
        }
        if (saleSupportField) {
            saleSupportField.style.display = isOnline ? 'block' : 'none';
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
</script>
@endpush
