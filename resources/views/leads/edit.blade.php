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
                <label class="form-label">Loại Lead</label>
                <input type="hidden" name="lead_type" value="{{ $lead->lead_type }}">
                <div class="form-text">@if($lead->lead_type == 1) Trực tiếp @else Online @endif</div>
            </div>
            
            <div class="col-md-4 mb-3">
                <label class="form-label">Ngày khách đến lần đầu</label>
                <input type="date" name="first_arrival_date" value="{{ $lead->first_arrival_date }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Tên khách hàng</label>
                <input type="text" name="name" value="{{ $lead->name }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" value="{{ $lead->phone }}" class="form-control">
            </div>
             <label class="form-label">Tỉnh/Thành phố</label>

            <div class="col-md-4 mb-3">
                <label for="province_id" class="form-label">Tỉnh / Thành phố</label>
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
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" value="{{ $lead->address }}" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Zalo</label>
                <input type="text" name="zalo" value="{{ $lead->zalo }}" class="form-control">
            </div>

           <div class="col-md-4 mb-3">
                <label for="customer_type_id" class="form-label">Loại khách hàng</label>
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
                <label class="form-label">Khách hàng mới?</label>
                <select name="is_new_customer" class="form-select">
                    <option value="1" {{ $lead->is_new_customer ? 'selected' : '' }}>Khách Hàng Mới </option>
                    <option value="0" {{ !$lead->is_new_customer ? 'selected' : '' }}>Khách Hàng Cũ</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="customer_source_id" class="form-label">Nguồn khách hàng</label>
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
                <label for="product_category_id" class="form-label">Danh mục sản phẩm</label>
                <select name="product_category_id" id="product_category_id" class="form-control">
                    <option value="">-- Chọn Danh mục sản phẩm --</option>
                    @foreach($productCategories as $productCategorie)
                        <option value="{{ $productCategorie->id }}" 
                            {{ $lead->product_category_id == $productCategorie->id ? 'selected' : '' }}>
                            {{ $productCategorie->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label for="showroom_id" class="form-label">Showroom</label>
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
                <label for="first_customer_status_id" class="form-label">Tình trạng KH ban đầu</label>
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
                <label class="form-label">Ghi chú</label>
                <textarea name="note" class="form-control" rows="2">{{ $lead->note }}</textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label for="sale_receive_customer_info_id" class="form-label">Sale nhận KH</label>
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
                <label for="sale_support_id" class="form-label">Sale hỗ trợ</label>
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
                <label for="current_customer_status_id" class="form-label">Tình trạng KH hiện tại</label>
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
                <label class="form-label">Giá trị đơn hàng</label>
                <input type="number" name="order_value" value="{{ $lead->order_value }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Trạng thái hỗ trợ</label>
                <input type="text" name="support_status_customer_id" value="{{ $lead->supportStatuses }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Nội dung trao đổi</label>
                <textarea name="exchange_content" class="form-control" rows="2">{{ $lead->exchange_content }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Kết quả</label>
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
                        <label class="form-label">Kế hoạch chăm sóc</label>
                        <input type="text" name="take_care_plan[]" value="{{ $care->take_care_plan ?? '' }}" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Ngày chăm sóc</label>
                        <input type="date" name="take_care_date[]" value="{{ $care?->take_care_date ? date('Y-m-d', strtotime($care?->take_care_date)) : '' }}" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kết quả chăm sóc</label>
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
