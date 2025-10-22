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

            <div class="col-md-4 mb-3">
                <label class="form-label">Tỉnh/Thành phố</label>
                <input type="text" name="province_id" value="{{ $lead->province_id }}" class="form-control">
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
                <label class="form-label">Loại khách hàng</label>
                <input type="text" name="customer_type_id" value="{{ $lead->customer_type_id }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Khách hàng mới?</label>
                <select name="is_new_customer" class="form-select">
                    <option value="1" {{ $lead->is_new_customer ? 'selected' : '' }}>Có</option>
                    <option value="0" {{ !$lead->is_new_customer ? 'selected' : '' }}>Không</option>
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Nguồn khách hàng</label>
                <input type="text" name="customer_source_id" value="{{ $lead->customer_source_id }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Danh mục sản phẩm</label>
                <input type="text" name="product_category_id" value="{{ $lead->product_category_id }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Showroom</label>
                <input type="text" name="showroom_id" value="{{ $lead->showroom_id }}" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Tình trạng KH ban đầu</label>
                <input type="text" name="first_customer_status_id" value="{{ $lead->first_customer_status_id }}" class="form-control">
            </div>
            <div class="col-md-8 mb-3">
                <label class="form-label">Ghi chú</label>
                <textarea name="note" class="form-control" rows="2">{{ $lead->note }}</textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Sale nhận KH</label>
                <input type="text" name="sale_receive_customer_info_id" value="{{ $lead->sale_receive_customer_info_id }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Sale hỗ trợ</label>
                <input type="text" name="sale_support_id" value="{{ $lead->sale_support_id }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Tình trạng KH hiện tại</label>
                <input type="text" name="current_customer_status_id" value="{{ $lead->current_customer_status_id }}" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Giá trị đơn hàng</label>
                <input type="number" name="order_value" value="{{ $lead->order_value }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Trạng thái hỗ trợ</label>
                <input type="text" name="support_status_customer_id" value="{{ $lead->support_status_customer_id }}" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Nội dung trao đổi</label>
                <textarea name="exchange_content" class="form-control" rows="2">{{ $lead->exchange_content }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Kết quả</label>
                <textarea name="results" class="form-control" rows="2">{{ $lead->results }}</textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Loại Lead</label>
                <input type="text" name="lead_type" value="{{ $lead->lead_type }}" class="form-control">
            </div>
        </div>

        <hr class="my-4">

        {{-- ========================= --}}
        {{-- 3 LẦN CHĂM SÓC --}}
        {{-- ========================= --}}
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
                        <input type="date" name="take_care_date[]" value="{{ $care->take_care_date ?? '' }}" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kết quả chăm sóc</label>
                        <input type="text" name="take_care_result[]" value="{{ $care->take_care_result ?? '' }}" class="form-control">
                    </div>
                </div>
            </div>
        @endfor

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-warning px-4">💾 Cập nhật Lead</button>
        </div>
    </form>
</div>
@endsection
