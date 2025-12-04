@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-warning">✏️ Chỉnh sửa Lead và 3 lần chăm sóc</h2>

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

    <form action="{{ route('leads.update', $lead->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ========================= --}}
        {{-- THÔNG TIN LEAD --}}
        {{-- ========================= --}}
        <h4 class="text-primary mt-3">📋 Thông tin Lead</h4>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Loại Lead</span></label>
                <input type="hidden" name="lead_type" value="{{ $lead->lead_type }}">
                <div class="form-text">@if($lead->lead_type == 1) Trực tiếp @else Online @endif</div>
            </div>
            
            <div class="col-md-4 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Ngày khách đến lần đầu</span></label>
                <input type="date" name="customer_visit_date" value="{{ $lead->customer_visit_date }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Tên khách hàng</span></label>
                <input type="text" name="name" value="{{ $lead->name }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Số điện thoại</span></label>
                <input type="text" name="phone" value="{{ $lead->phone }}" class="form-control">
            </div>
             <label class="form-label"><span class="text-primary fw-bold">Tỉnh/Thành phố</span></label>

            <div class="col-md-4 mb-3">
                <label for="province_id" class="form-label"><span class="text-primary fw-bold">Tỉnh / Thành phố</span></label>
                <select name="province_id" id="province_id" class="form-control">
                    <option value="">-- Chọn Tỉnh / Thành --</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}" 
                            {{ $lead->province_id == $province->id ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Địa chỉ</span></label>
                <input type="text" name="address" value="{{ $lead->address }}" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Zalo</span></label>
                <input type="text" name="zalo" value="{{ $lead->zalo }}" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label for="customer_type_id" class="form-label"><span class="text-primary fw-bold">Loại khách hàng</span></label>
                <select name="customer_type_id" id="customer_type_id" class="form-control">
                    <option value="">-- Chọn Loại khách hàng --</option>
                    @foreach($customerTypes as $customerType)
                        <option value="{{ $customerType->id }}" 
                            {{ $lead->customer_type_id == $customerType->id ? 'selected' : '' }}>
                            {{ $customerType->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Khách hàng mới?</span></label>
                <select name="is_new_customer" class="form-select">
                    <option value="1" {{ $lead->is_new_customer ? 'selected' : '' }}>Khách Hàng Mới </option>
                    <option value="0" {{ !$lead->is_new_customer ? 'selected' : '' }}>Khách Hàng Cũ</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="customer_source_id" class="form-label"><span class="text-primary fw-bold">Nguồn khách hàng</span></label>
                <select name="customer_source_id" id="customer_source_id" class="form-control">
                    <option value="">-- Chọn Nguồn khách hàng --</option>
                    @foreach($customerSources as $customerSource)
                        <option value="{{ $customerSource->id }}" 
                            {{ $lead->customer_source_id == $customerSource->id ? 'selected' : '' }}>
                            {{ $customerSource->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">
                    <span class="text-primary fw-bold">Danh mục sản phẩm</span>
                </label>
                <div class="dropdown">
                    <button class="btn dropdown-toggle w-100" type="button" id="dropdownProductCategoriesEdit" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #fff; color: #0d6efd; border: 1px solid #0d6efd; border-radius: 0.375rem;">
                        <span id="selectedProductNamesEditBtn">
                            @php
                                $selectedProductNames = $lead->productCategories->pluck('name')->toArray();
                            @endphp
                            @if(count($selectedProductNames))
                                {{ implode(', ', $selectedProductNames) }}
                            @else
                                Chọn danh mục sản phẩm
                            @endif
                        </span>
                    </button>
                    <div class="dropdown-menu w-100 p-2" aria-labelledby="dropdownProductCategoriesEdit" style="max-height: 300px; overflow-y: auto; background-color: #fff; color: #0d6efd;">
                        @foreach($productCategories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="productCategories[]" id="editProductCategory{{ $category->id }}" value="{{ $category->id }}" {{ $lead->productCategories->contains($category->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="editProductCategory{{ $category->id }}" style="color: #0d6efd;">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="showroom_id" class="form-label"><span class="text-primary fw-bold">Ngày khách đến lần đầu</span> Showroom</label>
                <select name="showroom_id" id="showroom_id" class="form-control">
                    <option value="">-- Chọn Showroom --</option>
                    @foreach($showrooms as $showroom)
                        <option value="{{ $showroom->id }}" 
                            {{ $lead->showroom_id == $showroom->id ? 'selected' : '' }}>
                            {{ $showroom->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="first_customer_status_id" class="form-label"><span class="text-primary fw-bold">Tình trạng KH ban đầu</span></label>
                <select name="first_customer_status_id" id="first_customer_status_id" class="form-control">
                    <option value="">-- Chọn Tình trạng KH ban đầu --</option>
                    @foreach($customerStatuses as $customerStatuse)
                        <option value="{{ $customerStatuse->id }}" 
                            {{ $lead->first_customer_status_id == $customerStatuse->id ? 'selected' : '' }}>
                            {{ $customerStatuse->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Ghi chú</span></label>
                <textarea name="note" class="form-control" rows="2">{{ $lead->note }}</textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label for="sale_receive_customer_info_id" class="form-label"><span class="text-primary fw-bold">Sale nhận KH</span></label>
                <select name="sale_receive_customer_info_id" id="sale_receive_customer_info_id" class="form-control">
                    <option value="">-- Chọn Sale nhận KH --</option>
                    @foreach($saleUsers as $saleUser)
                        <option value="{{ $saleUser->id }}" 
                            {{ $lead->sale_receive_customer_info_id == $saleUser->id ? 'selected' : '' }}>
                            {{ $saleUser->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="sale_support_id" class="form-label"><span class="text-primary fw-bold">Sale hỗ trợ</span></label>
                <select name="sale_support_id" id="sale_support_id" class="form-control">
                    <option value="">-- Chọn Sale hỗ trợ --</option>
                    @foreach($saleUsers as $saleUser)
                        <option value="{{ $saleUser->id }}" 
                            {{ $lead->sale_support_id == $saleUser->id ? 'selected' : '' }}>
                            {{ $saleUser->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="current_customer_status_id" class="form-label"><span class="text-primary fw-bold">Tình trạng KH hiện tại</span></label>
                <select name="current_customer_status_id" id="current_customer_status_id" class="form-control">
                    <option value="">-- Chọn Tình trạng KH hiện tại--</option>
                    @foreach($customerStatuses as $customerStatuse)
                        <option value="{{ $customerStatuse->id }}" 
                            {{ $lead->current_customer_status_id == $customerStatuse->id ? 'selected' : '' }}>
                            {{ $customerStatuse->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Giá trị đơn hàng</span></label>
                <input type="number" name="order_value" value="{{ $lead->order_value }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Trạng thái hỗ trợ</span></label>
                <input type="text" name="support_status_customer_id" value="{{ $lead->supportStatuses }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Nội dung trao đổi</span></label>
                <textarea name="exchange_content" class="form-control" rows="2">{{ $lead->exchange_content }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label"><span class="text-primary fw-bold">Kết quả</span></label>
                <textarea name="results" class="form-control" rows="2">{{ $lead->results }}</textarea>
            </div>
        </div>

        <hr class="my-4">

        {{-- ========================= --}}
        {{-- 3 LẦN CHĂM SÓC --}}
        {{-- ========================= --}}

        @if($lead->lead_type == 2)
        <h4 class="text-success mb-3">💬 Thông tin chăm sóc khách hàng (3 lần)</h4>

        @php
            $takeCares = $lead->leadTakeCares->take(3);
        @endphp

        @for ($i = 0; $i < 3; $i++)
            @php
                $care = $takeCares[$i] ?? null;
            @endphp
            <div class="border rounded p-3 mb-3">
                <h6 class="text-secondary">🗓️ Lần chăm sóc {{ $i + 1 }}</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><span class="text-primary fw-bold">Kế hoạch chăm sóc</span></label>
                        <input type="text" name="take_care_plan[]" value="{{ $care->take_care_plan ?? '' }}" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><span class="text-primary fw-bold">Ngày chăm sóc</span></label>
                        <input type="date" name="take_care_date[]" value="{{ $care?->take_care_date ? date('Y-m-d', strtotime($care?->take_care_date)) : '' }}" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label"><span class="text-primary fw-bold">Kết quả chăm sóc</span></label>
                        <input type="text" name="take_care_result[]" value="{{ $care->take_care_result ?? '' }}" class="form-control">
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
    // Update product category button text when checkboxes change (edit)
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
    // Initial update
    updateProductNamesEditBtn();
});
</script>
@endpush
