@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('lead.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-person-plus-fill text-primary"></i>
                        Thêm Lead mới
                    </h1>
                    <p class="text-muted">Tạo thông tin Lead mới trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Alert -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Có lỗi xảy ra:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form Card -->
            <div class="card fade-in">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-person-fill me-2"></i>
                        Thông tin Lead
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('lead.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Các trường cũ -->
                            <div class="col-md-6 mb-3">
                                <label for="lead_for_showroom" class="form-label">Ngày tương tác đầu tiên</label>
                                <input type="date" name="lead_for_showroom" id="lead_for_showroom" class="form-control" value="{{ old('lead_for_showroom') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Tên Lead / Tên Pancake</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Nhập tên lead">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="number" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="VD: 098xxxxxxx">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="province_id" class="form-label">Tỉnh/TP</label>
                                <select name="province_id" id="province_id" class="form-select">
                                    <option value="">-- Chọn Tỉnh/TP --</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" 
                                            {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Địa chỉ chi tiết</label>
                                <textarea name="address" id="address" rows="2" class="form-control">{{ old('address') }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="zalo_feedback" class="form-label">Zalo Feedback</label>
                                <input type="number" name="zalo_feedback" id="zalo_feedback" class="form-control" value="{{ old('zalo_feedback') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type_customer_yet_id" class="form-label">Khách Đã Đặt Hàng Chưa?</label>
                                <select name="type_customer_yet_id" id="type_customer_yet_id" class="form-select">
                                    <option value="">-- Chọn tình trạng lead --</option>
                                    @foreach($typeCustomer as $typeCus)
                                        <option value="{{ $typeCus->id }}" 
                                            {{ old('type_customer_yet_id') == $typeCus->id ? 'selected' : '' }}>
                                            {{ $typeCus->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type_customer_id" class="form-label">Phân Loại Lead</label>
                                <select name="type_customer_id" id="type_customer_id" class="form-select">
                                    <option value="">-- Chọn Phân Loại Lead --</option>
                                    @foreach($typeCustomer as $typeCus)
                                        <option value="{{ $typeCus->id }}" 
                                            {{ old('type_customer_id') == $typeCus->id ? 'selected' : '' }}>
                                            {{ $typeCus->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="type_showroom_id" class="form-label">Showroom nào?</label>
                                <select name="type_showroom_id" id="type_showroom_id" class="form-select">
                                    <option value="">-- Chọn Showroom --</option>
                                    @foreach($typeShowroom as $typeShow)
                                        <option value="{{ $typeShow->id }}" 
                                            {{ old('type_showroom_id') == $typeShow->id ? 'selected' : '' }}>
                                            {{ $typeShow->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type_category_id" class="form-label">Sản Phẩm Cần Tư Vấn Đầu Tiên</label>
                                <select name="type_category_id" id="type_category_id" class="form-select">
                                    <option value="">-- Chọn Danh Mục Sản Phẩm --</option>
                                    @foreach($category as $cate)
                                        <option value="{{ $cate->id }}" 
                                            {{ old('type_category_id') == $cate->id ? 'selected' : '' }}>
                                            {{ $cate->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status_first_id" class="form-label">Tình Trạng Lead Đầu Tiên</label>
                                <select name="status_first_id" id="status_first_id" class="form-select">
                                    <option value="">-- Chọn Tình Trạng Đầu Tiên --</option>
                                    @foreach($status as $statusfrist)
                                        <option value="{{ $statusfrist->id }}" 
                                            {{ old('status_first_id') == $statusfrist->id ? 'selected' : '' }}>
                                            {{ $statusfrist->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="note_sale" class="form-label">Ghi Chú</label>
                                <input type="text" name="note_sale" id="note_sale" class="form-control" value="{{ old('note_sale') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="salename_infor_id" class="form-label">Sale Nhận Lead</label>
                                <select name="salename_infor_id" id="salename_infor_id" class="form-select">
                                    <option value="">-- Chọn Sale Nhận Lead --</option>
                                    @foreach($salename as $saleinfor)
                                        <option value="{{ $saleinfor->id }}" 
                                            {{ old('salename_infor_id') == $saleinfor->id ? 'selected' : '' }}>
                                            {{ $saleinfor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="salename_support_id" class="form-label">Sale Hỗ Trợ Lead</label>
                                <select name="salename_support_id" id="salename_support_id" class="form-select">
                                    <option value="">-- Chọn Sale Hỗ Trợ Lead --</option>
                                    @foreach($salename as $salesupport)
                                        <option value="{{ $salesupport->id}}" 
                                            {{ old('salename_support_id') == $salesupport->id ? 'selected' : '' }}>
                                            {{ $salesupport->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="current_status_id" class="form-label">Tình Trạng Hiện Tại</label>
                                <select name="current_status_id" id="current_status_id" class="form-select">
                                    <option value="">-- Chọn Tình Trạng Hiện Tại --</option>
                                    @foreach($status as $statuscurrent)
                                        <option value="{{ $statuscurrent->id }}" 
                                            {{ old('current_status_id') == $statuscurrent->id ? 'selected' : '' }}>
                                            {{ $statuscurrent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="order_value" class="form-label">Giá trị đơn chốt được</label>
                                <input type="number" name="order_value" id="order_value" class="form-control" value="{{ old('order_value') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="source_id" class="form-label">Nguồn Lead</label>
                                <select name="source_id" id="source_id" class="form-select">
                                    <option value="">-- Chọn Nguồn Lead --</option>
                                    @foreach($source as $src)
                                        <option value="{{ $src->id }}" 
                                            {{ old('source_id') == $src->id ? 'selected' : '' }}>
                                            {{ $src->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- ✅ Thêm 6 trường mới -->
                            <div class="col-md-4 mb-3">
                                <label for="first_care_date" class="form-label">Ngày chăm sóc 1</label>
                                <input type="date" name="first_care_date" id="first_care_date" class="form-control" value="{{ old('first_care_date') }}">
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="result1" class="form-label">Kết quả chăm sóc 1</label>
                                <input type="text" name="result1" id="result1" class="form-control" value="{{ old('result1') }}" placeholder="Nhập kết quả chăm sóc lần 1">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="two_care_date" class="form-label">Ngày chăm sóc 2</label>
                                <input type="date" name="two_care_date" id="two_care_date" class="form-control" value="{{ old('two_care_date') }}">
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="result2" class="form-label">Kết quả chăm sóc 2</label>
                                <input type="text" name="result2" id="result2" class="form-control" value="{{ old('result2') }}" placeholder="Nhập kết quả chăm sóc lần 2">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="three_care_date" class="form-label">Ngày chăm sóc 3</label>
                                <input type="date" name="three_care_date" id="three_care_date" class="form-control" value="{{ old('three_care_date') }}">
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="result3" class="form-label">Kết quả chăm sóc 3</label>
                                <input type="text" name="result3" id="result3" class="form-control" value="{{ old('result3') }}" placeholder="Nhập kết quả chăm sóc lần 3">
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('lead.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Tạo Lead
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Tips Card -->
            <div class="card fade-in">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightbulb me-2"></i>
                        Ghi chú
                    </h5>
                </div>
                <div class="card-body">
                    <p>Điền đầy đủ thông tin Lead để thuận tiện cho việc chăm sóc và quản lý.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
