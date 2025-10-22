@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary">➕ Thêm mới Lead và 3 lần chăm sóc</h2>

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

    <form action="{{ route('leads.store') }}" method="POST">
        @csrf

        {{-- ========================= --}}
        {{-- THÔNG TIN LEAD --}}
        {{-- ========================= --}}
        <h4 class="text-primary mt-3">📋 Thông tin Lead</h4>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Ngày khách đến lần đầu</label>
                <input type="date" name="first_arrival_date" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Tên khách hàng</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Số điện thoại</label>
                <input type="text" name="phone" class="form-control">
            </div>

            {{-- Province --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Tỉnh/Thành phố</label>
                <select name="province_id" class="form-select">
                    <option value="">-- Chọn tỉnh/thành --</option>
                    @foreach($provinces as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label">Địa chỉ</label>
                <input type="text" name="address" class="form-control">
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Zalo</label>
                <input type="text" name="zalo" class="form-control">
            </div>

            {{-- Customer Type --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Loại khách hàng</label>
                <select name="customer_type_id" class="form-select">
                    <option value="">-- Chọn loại khách --</option>
                    @foreach($customerTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Khách hàng mới?</label>
                <select name="is_new_customer" class="form-select">
                    <option value="1">Có</option>
                    <option value="0">Không</option>
                </select>
            </div>

            {{-- Customer Source --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Nguồn khách hàng</label>
                <select name="customer_source_id" class="form-select">
                    <option value="">-- Chọn nguồn --</option>
                    @foreach($customerSources as $src)
                        <option value="{{ $src->id }}">{{ $src->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Product Category --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Danh mục sản phẩm</label>
                <select name="product_category_id" class="form-select">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($productCategories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Showroom --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Showroom</label>
                <select name="showroom_id" class="form-select">
                    <option value="">-- Chọn showroom --</option>
                    @foreach($showrooms as $sr)
                        <option value="{{ $sr->id }}">{{ $sr->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- First Customer Status --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Tình trạng KH ban đầu</label>
                <select name="first_customer_status_id" class="form-select">
                    <option value="">-- Chọn tình trạng --</option>
                    @foreach($customerStatuses as $st)
                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label">Ghi chú</label>
                <textarea name="note" class="form-control" rows="2"></textarea>
            </div>

            {{-- Sale nhận --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Sale nhận KH</label>
                <select name="sale_receive_customer_info_id" class="form-select">
                    <option value="">-- Chọn sale nhận --</option>
                    @foreach($saleUsers as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Sale hỗ trợ --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Sale hỗ trợ</label>
                <select name="sale_support_id" class="form-select">
                    <option value="">-- Chọn sale hỗ trợ --</option>
                    @foreach($saleUsers as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Current Customer Status --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Tình trạng KH hiện tại</label>
                <select name="current_customer_status_id" class="form-select">
                    <option value="">-- Chọn tình trạng --</option>
                    @foreach($customerStatuses as $st)
                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Giá trị đơn hàng</label>
                <input type="number" name="order_value" class="form-control">
            </div>

            {{-- Support Status --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">Trạng thái hỗ trợ</label>
                <select name="support_status_customer_id" class="form-select">
                    <option value="">-- Chọn trạng thái hỗ trợ --</option>
                    @foreach($supportStatuses as $st)
                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Nội dung trao đổi</label>
                <textarea name="exchange_content" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Kết quả</label>
                <textarea name="results" class="form-control" rows="2"></textarea>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label">Loại Lead</label>
                <input type="text" name="lead_type" class="form-control">
            </div>
        </div>

        <hr class="my-4">

        {{-- ========================= --}}
        {{-- 3 LẦN CHĂM SÓC --}}
        {{-- ========================= --}}
        <h4 class="text-success mb-3">💬 Thông tin chăm sóc khách hàng (3 lần)</h4>

        @for ($i = 1; $i <= 3; $i++)
            <div class="border rounded p-3 mb-3">
                <h6 class="text-secondary">🗓️ Lần chăm sóc {{ $i }}</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kế hoạch chăm sóc</label>
                        <input type="text" name="take_care_plan[]" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Ngày chăm sóc</label>
                        <input type="date" name="take_care_date[]" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kết quả chăm sóc</label>
                        <input type="text" name="take_care_result[]" class="form-control">
                    </div>
                </div>
            </div>
        @endfor

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4">💾 Lưu Lead</button>
        </div>
    </form>
</div>
@endsection
