@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-warning">✏️ Chỉnh sửa Lead</h2>

    {{-- Hiển thị lỗi validate --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('leads.update', $lead->id) . '?' . http_build_query(request()->query()) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ========================= --}}
        {{-- THÔNG TIN LEAD --}}
        {{-- ========================= --}}
        <h4 class="text-primary mt-3">📋 Thông tin Lead</h4>
        <div class="row">
            @if(auth()->user()->roles()->whereIn('slug', ['admin', 'manager','supporter'])->exists())
                <div class="col-md-4 mb-3">
                    <label class="form-label"><span class="text-primary fw-bold">Loại Lead</span></label>
                    <select name="lead_type" class="form-select fw-bold">
                        <option value="1" {{ old('lead_type', $lead->lead_type) == 1 ? 'selected' : '' }}>Trực tiếp</option>
                        <option value="2" {{ old('lead_type', $lead->lead_type) == 2 ? 'selected' : '' }}>Online</option>
                    </select>
                </div>
            @else
                <input type="hidden" name="lead_type" value="{{ $lead->lead_type }}">
            @endif
            <div class="col-md-3">
                <label class="text-primary fw-bold">Mã khách hàng</label>
                <input type="text" class="form-control" value="{{ $lead->customerCode->customer_code ?? 'N/A' }}" readonly>
            </div>
            <div class="col-md-3">
                <label class="text-primary fw-bold">Mã đơn hàng</label>
                <input type="text" class="form-control" value="{{ $lead->order_code }}" readonly>
            </div>

            
            <div class="col-md-4 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Ngày tương tác đầu tiên</span></label>
                <input type="date" name="first_interaction_date" value="{{ old('first_interaction_date', $lead->first_interaction_date) }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Tên khách hàng</span></label>
                <input type="text" name="name" value="{{ old('name', $lead->name) }}" class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">
                    <span class="text-primary fw-bold">Số điện thoại</span>
                </label>

                <div class="d-flex align-items-start gap-2 flex-wrap">
                    <button type="button" id="add-phone" class="btn btn-outline-primary">
                        + Thêm
                    </button>

                    <div id="phone-wrapper" class="d-flex gap-2 flex-wrap">
                        {{-- Ưu tiên lấy mảng số điện thoại vừa gửi lỗi từ old('phone') trước --}}
                        @if(is_array(old('phone')))
                            @foreach(old('phone') as $oldPhone)
                                <div class="phone-item d-flex align-items-center gap-1">
                                    <input type="text" name="phone[]" value="{{ $oldPhone }}" class="form-control" placeholder="Nhập số điện thoại">
                                    <button type="button" class="btn btn-danger btn-sm remove-phone">x</button>
                                </div>
                            @endforeach
                        @elseif($phones->isNotEmpty())
                            @foreach($phones as $phone)
                                <div class="phone-item d-flex align-items-center gap-1">
                                    <input type="text" name="phone[]" value="{{ $phone->phone }}" class="form-control" placeholder="Nhập số điện thoại">
                                    <button type="button" class="btn btn-danger btn-sm remove-phone">x</button>
                                </div>
                            @endforeach
                        @else
                            <div class="phone-item d-flex align-items-center gap-1">
                                <input type="text" name="phone[]" class="form-control" placeholder="Nhập số điện thoại">
                                <button type="button" class="btn btn-danger btn-sm remove-phone">x</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="province_id" class="form-label"><span class="text-primary fw-bold">Tỉnh / Thành phố</span></label>
                <select name="province_id" id="province_id" class="form-control">
                    <option value="">-- Chọn Tỉnh / Thành --</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}" 
                            {{ old('province_id', $lead->province_id) == $province->id ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Địa chỉ</span></label>
                <input type="text" name="address" value="{{ old('address', $lead->address) }}" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Zalo</span></label>
                <input type="text" name="zalo" value="{{ old('zalo', $lead->zalo) }}" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label for="customer_type_id" class="form-label"><span class="text-primary fw-bold">Phân Loại khách hàng</span></label>
                <select name="customer_type_id" id="customer_type_id" class="form-control">
                    <option value="">-- Chọn Phân loại khách hàng --</option>
                    @foreach($customerTypes as $customerType)
                        <option value="{{ $customerType->id }}" 
                            {{ old('customer_type_id', $lead->customer_type_id) == $customerType->id ? 'selected' : '' }}>
                            {{ $customerType->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if($lead->lead_type != 1)
            <div class="col-md-4 mb-3">
                <label for="source_id" class="form-label"><span class="text-primary fw-bold">Nguồn khách hàng</span></label>
                <select name="source_id" id="source_id" class="form-control">
                    <option value="">-- Chọn Nguồn khách hàng --</option>
                    @foreach($customerSources as $customerSource)
                        <option value="{{ $customerSource->id }}" 
                            {{ old('source_id', $lead->source_id) == $customerSource->id ? 'selected' : '' }}>
                            {{ $customerSource->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="col-md-4 mb-3">
                <label class="form-label">
                    <span class="text-primary fw-bold">Danh mục sản phẩm</span>
                </label>
                <div class="dropdown">
                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownProductCategoriesEdit" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #fff; color: #0d6efd; border: 1px solid #0d6efd; border-radius: 0.375rem;">
                        <span id="selectedProductNamesEditBtn">
                            Chọn danh mục sản phẩm
                        </span>
                    </button>
                    <div class="dropdown-menu w-100 p-2" aria-labelledby="dropdownProductCategoriesEdit" style="max-height: 300px; overflow-y: auto; background-color: #fff; color: #0d6efd;">
                        @foreach($productCategories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="productCategories[]" id="editProductCategory{{ $category->id }}" value="{{ $category->id }}" 
                                    {{ in_array($category->id, old('productCategories', $lead->productCategories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label class="form-check-label" for="editProductCategory{{ $category->id }}" style="color: #0d6efd;">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($lead->lead_type != 2)
            <div class="col-md-4 mb-3">
                <label for="showroom_id" class="form-label"><span class="text-primary fw-bold">Showroom</span></label>
                <select name="showroom_id" id="showroom_id" class="form-control">
                    <option value="">-- Chọn Showroom --</option>
                    @foreach($showrooms as $showroom)
                        <option value="{{ $showroom->id }}" 
                            {{ old('showroom_id', $lead->showroom_id) == $showroom->id ? 'selected' : '' }}>
                            {{ $showroom->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            @if($lead->lead_type != 1)
            <div class="col-md-4 mb-3">
                <label for="first_customer_status_id" class="form-label"><span class="text-primary fw-bold">Tình trạng KH ban đầu</span></label>
                <select name="first_customer_status_id" id="first_customer_status_id" class="form-control">
                    <option value="">-- Chọn Tình trạng KH ban đầu --</option>
                    @foreach($customerStatuses as $customerStatuse)
                        <option value="{{ $customerStatuse->id }}" 
                            {{ old('first_customer_status_id', $lead->first_customer_status_id) == $customerStatuse->id ? 'selected' : '' }}>
                            {{ $customerStatuse->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="col-md-8 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Ghi chú sale nhận khách</span></label>
                <textarea name="note" class="form-control" rows="2">{{ old('note', $lead->note) }}</textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label for="sale_information_id" class="form-label"><span class="text-primary fw-bold">Sale nhận KH</span></label>
                <select name="sale_information_id" id="sale_information_id" class="form-control">
                    <option value="">-- Chọn Sale nhận KH --</option>
                    @foreach($saleInformation as $saleUser)
                        <option value="{{ $saleUser->id }}" 
                            {{ old('sale_information_id', $lead->sale_information_id) == $saleUser->id ? 'selected' : '' }}>
                            {{ $saleUser->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            
           <div class="col-md-4 mb-3">
                <label for="sale_support_id" class="form-label">
                    <span class="text-primary fw-bold">Sale hỗ trợ</span>
                </label>

                @if(auth()->user()->roles()->whereIn('slug', ['admin', 'manager','supporter'])->exists())
                    <select name="sale_support_id" id="sale_support_id" class="form-control fw-bold">
                        <option value="">-- Chọn Sale hỗ trợ --</option>
                        @foreach($saleSupport as $saleUser)
                            <option value="{{ $saleUser->id }}" 
                                {{ old('sale_support_id', $lead->sale_support_id) == $saleUser->id ? 'selected' : '' }}>
                                {{ $saleUser->name }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <select class="form-control fw-bold" disabled>
                        <option value="">-- Chưa có Sale hỗ trợ --</option>
                        @foreach($saleSupport as $saleUser)
                            <option value="{{ $saleUser->id }}" 
                                {{ old('sale_support_id', $lead->sale_support_id) == $saleUser->id ? 'selected' : '' }}>
                                {{ $saleUser->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <input type="hidden" name="sale_support_id" value="{{ old('sale_support_id', $lead->sale_support_id) }}">
                @endif
            </div>
            

            <div class="col-md-4 mb-3">
                <label for="current_customer_status_id" class="form-label"><span class="text-primary fw-bold">Tình trạng KH hiện tại</span></label>
                <select name="current_customer_status_id" id="current_customer_status_id" class="form-control">
                    <option value="">-- Chọn Tình trạng KH hiện tại--</option>
                    @foreach($customerStatuses as $customerStatuse)
                        <option value="{{ $customerStatuse->id }}" 
                            {{ old('current_customer_status_id', $lead->current_customer_status_id) == $customerStatuse->id ? 'selected' : '' }}>
                            {{ $customerStatuse->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            
            <div class="col-md-4 mb-3">
                <label class="form-label">
                    <span class="text-primary fw-bold">Giá trị đơn hàng</span>
                </label>

                <input type="text" id="order_value_display" 
                    value="{{ number_format(old('order_value', $lead->order_value), 0, ',', '.') }}" 
                    class="form-control">

                <input type="hidden" name="order_value" id="order_value" 
                    value="{{ old('order_value', $lead->order_value) }}">
            </div>
           

            @if($lead->lead_type != 2)
            <div class="col-md-4 mb-3">
                <label for="support_channel_id" class="form-label"><span class="text-primary fw-bold">KH đã được hỗ trợ trước qua kênh nào?</span></label>
                <select name="support_channel_id" id="support_channel_id" class="form-control">
                    <option value="">-- Chọn Nguồn khách hàng --</option>
                    @foreach($supportChannel as $Channel)
                        <option value="{{ $Channel->id }}" 
                            {{ old('support_channel_id', $lead->support_channel_id) == $Channel->id ? 'selected' : '' }}>
                            {{ $Channel->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
            
            @if($lead->lead_type != 1)
            <div class="col-md-6 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Thông tin đã trao đổi với KH</span></label>
                <textarea name="customer_discussion_details" class="form-control" rows="2">{{ old('customer_discussion_details', $lead->customer_discussion_details) }}</textarea>
            </div>
            @endif
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="tmdt" id="kq1" value="TMDT"
                    {{ old('tmdt', $lead->tmdt) == 'TMDT' ? 'checked' : '' }}>
                <label class="form-check-label" for="kq1">Chuyển sang TMDT</label>
            </div>


        </div>

        <hr class="my-4">

        {{-- ========================= --}}
        {{-- 3 LẦN CHĂM SÓC --}}
        {{-- ========================= --}}

        @if($lead->lead_type == 2)
        <h4 class="text-success mb-3">💬 Thông tin chăm sóc khách hàng</h4>

        @php
            $takeCares = $lead->leadTakeCares->take(3);
        @endphp

        @for ($i = 0; $i < 3; $i++)
            @php
                $care = $takeCares[$i] ?? null;
                // Xử lý ngày hiển thị cũ khi lỗi validation của mảng
                $oldDateValue = old('take_care_date.' . $i);
                if (!$oldDateValue && $care?->take_care_date) {
                    $oldDateValue = date('Y-m-d', strtotime($care->take_care_date));
                }
            @endphp
            <div class="border rounded p-3 mb-3">
                <h6 class="text-secondary">🗓️ Lần chăm sóc {{ $i + 1 }}</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><span class="text-primary fw-bold">Kế hoạch chăm sóc</span></label>
                        <input type="text" name="take_care_plan[]" value="{{ old('take_care_plan.' . $i, $care->take_care_plan ?? '') }}" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><span class="text-primary fw-bold">Ngày chăm sóc</span></label>
                        <input type="date"
       name="take_care_date[]"
       value="{{ old('take_care_date.' . $i, isset($care->take_care_date) ? \Carbon\Carbon::parse($care->take_care_date)->format('Y-m-d') : '') }}"
       class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><span class="text-primary fw-bold">Kết quả chăm sóc</span></label>
                        <input type="text" name="take_care_result[]" value="{{ old('take_care_result.' . $i, $care->take_care_result ?? '') }}" class="form-control">
                    </div>
                </div>
            </div>
        @endfor
        @endif

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-warning px-4">💾 Cập nhật Lead</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productCheckboxesEdit = document.querySelectorAll('input[name="productCategories[]"]');
    const productNamesEditBtn = document.getElementById('selectedProductNamesEditBtn');
    const productLabelsEdit = {};
    @foreach($productCategories as $cat)
        productLabelsEdit[{{ $cat->id }}] = @json($cat->name);
    @endforeach

    function updateProductNamesEditBtn() {
        const checked = Array.from(productCheckboxesEdit).filter(cb => cb.checked).map(cb => productLabelsEdit[cb.value]);
        if (checked.length) {
            productNamesEditBtn.textContent = checked.join(', ');
        } else {
            productNamesEditBtn.textContent = 'Chọn danh mục sản phẩm';
        }
    }
    productCheckboxesEdit.forEach(cb => {
        cb.addEventListener('change', updateProductNamesEditBtn);
    });
    updateProductNamesEditBtn();
});

const display = document.getElementById('order_value_display');
const real = document.getElementById('order_value');

function formatNumber(n) {
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

display.addEventListener('input', function () {
    this.value = formatNumber(this.value);
    real.value = this.value.replace(/\./g, '');
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
</script>
@endpush