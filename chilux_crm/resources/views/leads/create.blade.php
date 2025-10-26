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
<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('leads.store') }}" method="POST">
            @csrf
            
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
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <label for="first_arrival_date" class="form-label">
                                <i class="bi bi-calendar me-1"></i>Ngày khách đến lần đầu
                            </label>
                            <input type="date" name="first_arrival_date" id="first_arrival_date" 
                                   class="form-control @error('first_arrival_date') is-invalid @enderror"
                                   value="{{ old('first_arrival_date') }}">
                            @error('first_arrival_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="name" class="form-label">
                                <i class="bi bi-person me-1"></i>Tên khách hàng
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
                                <i class="bi bi-telephone me-1"></i>Số điện thoại
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
                                <i class="bi bi-chat-dots me-1"></i>Zalo
                            </label>
                            <input type="text" name="zalo" id="zalo" 
                                   class="form-control @error('zalo') is-invalid @enderror"
                                   value="{{ old('zalo') }}" placeholder="Nhập ID Zalo">
                            @error('zalo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="province_id" class="form-label">
                                <i class="bi bi-geo-alt me-1"></i>Tỉnh/Thành phố
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

                        <div class="col-md-8">
                            <label for="address" class="form-label">
                                <i class="bi bi-house me-1"></i>Địa chỉ
                            </label>
                            <input type="text" name="address" id="address" 
                                   class="form-control @error('address') is-invalid @enderror"
                                   value="{{ old('address') }}" placeholder="Nhập địa chỉ chi tiết">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Customer Classification -->
                        <div class="col-md-4">
                            <label for="customer_type_id" class="form-label">
                                <i class="bi bi-tag me-1"></i>Loại khách hàng
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

                        <div class="col-md-4">
                            <label for="is_new_customer" class="form-label">
                                <i class="bi bi-person-check me-1"></i>Khách hàng mới?
                            </label>
                            <select name="is_new_customer" id="is_new_customer" 
                                    class="form-select @error('is_new_customer') is-invalid @enderror">
                                <option value="1" {{ old('is_new_customer', '1') == '1' ? 'selected' : '' }}>Có</option>
                                <option value="0" {{ old('is_new_customer') == '0' ? 'selected' : '' }}>Không</option>
                            </select>
                            @error('is_new_customer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="customer_source_id" class="form-label">
                                <i class="bi bi-funnel me-1"></i>Nguồn khách hàng
                            </label>
                            <select name="customer_source_id" id="customer_source_id" 
                                    class="form-select @error('customer_source_id') is-invalid @enderror">
                                <option value="">-- Chọn nguồn --</option>
                                @foreach($customerSources as $src)
                                    <option value="{{ $src->id }}" {{ old('customer_source_id') == $src->id ? 'selected' : '' }}>
                                        {{ $src->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_source_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Business Information -->
                        <div class="col-md-4">
                            <label for="product_category_id" class="form-label">
                                <i class="bi bi-box-seam me-1"></i>Danh mục sản phẩm
                            </label>
                            <select name="product_category_id" id="product_category_id" 
                                    class="form-select @error('product_category_id') is-invalid @enderror">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach($productCategories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('product_category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="showroom_id" class="form-label">
                                <i class="bi bi-building me-1"></i>Showroom
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

                        <div class="col-md-4">
                            <label for="order_value" class="form-label">
                                <i class="bi bi-currency-dollar me-1"></i>Giá trị đơn hàng
                            </label>
                            <input type="number" name="order_value" id="order_value" 
                                   class="form-control @error('order_value') is-invalid @enderror"
                                   value="{{ old('order_value') }}" placeholder="Nhập giá trị đơn hàng">
                            @error('order_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Information -->
                        <div class="col-md-4">
                            <label for="first_customer_status_id" class="form-label">
                                <i class="bi bi-flag me-1"></i>Tình trạng KH ban đầu
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
                                <i class="bi bi-flag-fill me-1"></i>Tình trạng KH hiện tại
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
                        <div class="col-md-4">
                            <label for="support_status_customer_id" class="form-label">
                                <i class="bi bi-flag-fill me-1"></i>Tình trạng hỗ trợ
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
                        </div>

                        <div class="col-md-4">
                            <label for="lead_type" class="form-label">
                                <i class="bi bi-diagram-3 me-1"></i>Loại Lead
                            </label>
                            <select name="lead_type" id="lead_type" class="form-select @error('lead_type') is-invalid @enderror">
                                <option value="1" {{ old('lead_type', '1') == '1' ? 'selected' : '' }}>Trực tiếp</option>
                                <option value="2" {{ old('lead_type') == '2' ? 'selected' : '' }}>Online</option>
                            </select>
                            @error('lead_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sales Team -->
                        <div class="col-md-4">
                            <label for="sale_receive_customer_info_id" class="form-label">
                                <i class="bi bi-person-badge me-1"></i>Sale nhận KH
                            </label>
                            <select name="sale_receive_customer_info_id" id="sale_receive_customer_info_id" 
                                    class="form-select @error('sale_receive_customer_info_id') is-invalid @enderror">
                                <option value="">-- Chọn sale nhận --</option>
                                @foreach($saleUsers as $s)
                                    <option value="{{ $s->id }}" {{ old('sale_receive_customer_info_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sale_receive_customer_info_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="sale_support_id" class="form-label">
                                <i class="bi bi-headset me-1"></i>Sale hỗ trợ
                            </label>
                            <select name="sale_support_id" id="sale_support_id" 
                                    class="form-select @error('sale_support_id') is-invalid @enderror">
                                <option value="">-- Chọn sale hỗ trợ --</option>
                                @foreach($saleUsers as $s)
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
                                <i class="bi bi-sticky me-1"></i>Ghi chú
                            </label>
                            <textarea name="note" id="note" rows="3" 
                                      class="form-control @error('note') is-invalid @enderror"
                                      placeholder="Nhập ghi chú về khách hàng">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="exchange_content" class="form-label">
                                <i class="bi bi-chat-square-text me-1"></i>Nội dung trao đổi
                            </label>
                            <textarea name="exchange_content" id="exchange_content" rows="3" 
                                      class="form-control @error('exchange_content') is-invalid @enderror"
                                      placeholder="Nhập nội dung trao đổi với khách hàng">{{ old('exchange_content') }}</textarea>
                            @error('exchange_content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="results" class="form-label">
                                <i class="bi bi-trophy me-1"></i>Kết quả
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
        </form>
    </div>
    
    <div class="col-lg-4">
        <!-- Customer Care Information Card -->
        <div class="card fade-in mb-4" id="customer-care-card" style="display: none;">
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
</div>
@endsection

@push('scripts')
<script>
// Auto-fill current date for first arrival date
document.addEventListener('DOMContentLoaded', function() {
    const firstArrivalDate = document.getElementById('first_arrival_date');
    if (!firstArrivalDate.value) {
        const today = new Date().toISOString().split('T')[0];
        firstArrivalDate.value = today;
    }
    
    // Handle lead type change
    const leadTypeSelect = document.getElementById('lead_type');
    const customerCareCard = document.getElementById('customer-care-card');
    
    function toggleCustomerCare() {
        if (leadTypeSelect.value === '2') { // Online
            customerCareCard.style.display = 'block';
            customerCareCard.classList.add('fade-in');
        } else { // Trực tiếp
            customerCareCard.style.display = 'none';
            customerCareCard.classList.remove('fade-in');
        }
    }
    
    // Initial check
    toggleCustomerCare();
    
    // Listen for changes
    leadTypeSelect.addEventListener('change', toggleCustomerCare);
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
