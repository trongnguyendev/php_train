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
                        <i class="bi bi-pencil-square text-warning"></i>
                        Chỉnh sửa Lead
                    </h1>
                    <p class="text-muted">Cập nhật thông tin Lead trong hệ thống</p>
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
                    <form action="{{ route('lead.update', $lead->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Các trường thông tin lead -->
                            <div class="col-md-6 mb-3">
                                <label for="customer_for_showroom" class="form-label">Ngày tương tác đầu tiên</label>
                                <input type="date" name="customer_for_showroom" id="customer_for_showroom" class="form-control" value="{{ old('customer_for_showroom', $lead->customer_for_showroom) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Tên Lead / Tên Pancake</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $lead->name) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="number" name="phone" id="phone" class="form-control" value="{{ old('phone', $lead->phone) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="province_id" class="form-label">Tỉnh/TP</label>
                                <select name="province_id" id="province_id" class="form-select">
                                    <option value="">-- Chọn Tỉnh/TP --</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" 
                                            {{ old('province_id', $lead->province_id) == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Địa chỉ chi tiết</label>
                                <textarea name="address" id="address" rows="2" class="form-control">{{ old('address', $lead->address) }}</textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="zalo_feedback" class="form-label">Zalo Feedback</label>
                                <input type="text" name="zalo_feedback" id="zalo_feedback" class="form-control" value="{{ old('zalo_feedback', $lead->zalo_feedback) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type_customer_yet_id" class="form-label">Khách Đã Đặt Hàng Chưa?</label>
                                <select name="type_customer_yet_id" id="type_customer_yet_id" class="form-select">
                                    <option value="">-- Chọn tình trạng khách hàng --</option>
                                    @foreach($typeCustomer as $typeCus)
                                        <option value="{{ $typeCus->id }}" 
                                            {{ old('type_customer_yet_id', $lead->type_customer_yet_id) == $typeCus->id ? 'selected' : '' }}>
                                            {{ $typeCus->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type_customer_id" class="form-label">Phân Loại Khách Hàng</label>
                                <select name="type_customer_id" id="type_customer_id" class="form-select">
                                    <option value="">-- Chọn Phân Loại Khách Hàng --</option>
                                    @foreach($typeCustomer as $typeCus)
                                        <option value="{{ $typeCus->id }}" 
                                            {{ old('type_customer_id', $lead->type_customer_id) == $typeCus->id ? 'selected' : '' }}>
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
                                            {{ old('type_showroom_id', $lead->type_showroom_id) == $typeShow->id ? 'selected' : '' }}>
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
                                            {{ old('type_category_id', $lead->type_category_id) == $cate->id ? 'selected' : '' }}>
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
                                            {{ old('status_first_id', $lead->status_first_id) == $statusfrist->id ? 'selected' : '' }}>
                                            {{ $statusfrist->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="note_sale" class="form-label">Ghi Chú</label>
                                <input type="text" name="note_sale" id="note_sale" class="form-control" value="{{ old('note_sale', $lead->note_sale) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="salename_infor_id" class="form-label">Sale Nhận Thông Tin Lead</label>
                                <select name="salename_infor_id" id="salename_infor_id" class="form-select">
                                    <option value="">-- Chọn Sale Nhận Thông Tin --</option>
                                    @foreach($salename as $saleinfor)
                                        <option value="{{ $saleinfor->id }}" 
                                            {{ old('salename_infor_id', $lead->salename_infor_id) == $saleinfor->id ? 'selected' : '' }}>
                                            {{ $saleinfor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="salename_support_id" class="form-label">Sale Hỗ Trợ Lead</label>
                                <select name="salename_support_id" id="salename_support_id" class="form-select">
                                    <option value="">-- Chọn Sale Hỗ Trợ --</option>
                                    @foreach($salename as $salesupport)
                                        <option value="{{ $salesupport->id}}" 
                                            {{ old('salename_support_id', $lead->salename_support_id) == $salesupport->id ? 'selected' : '' }}>
                                            {{ $salesupport->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="current_status_id" class="form-label">Tình Trạng Lead Hiện Tại</label>
                                <select name="current_status_id" id="current_status_id" class="form-select">
                                    <option value="">-- Chọn Tình Trạng Hiện Tại --</option>
                                    @foreach($status as $statuscurrent)
                                        <option value="{{ $statuscurrent->id }}" 
                                            {{ old('current_status_id', $lead->current_status_id) == $statuscurrent->id ? 'selected' : '' }}>
                                            {{ $statuscurrent->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="order_value" class="form-label">Giá trị đơn chốt được</label>
                                <input type="number" name="order_value" id="order_value" class="form-control" value="{{ old('order_value', $lead->order_value) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="customer_support_yet_id" class="form-label">Lead Đã Được Hỗ Trợ Chưa?</label>
                                <select name="customer_support_yet_id" id="customer_support_yet_id" class="form-select">
                                    <option value="">-- Chọn Tình Trạng Hỗ Trợ --</option>
                                    @foreach($source as $src)
                                        <option value="{{ $src->id }}" 
                                            {{ old('customer_support_yet_id', $lead->customer_support_yet_id) == $src->id ? 'selected' : '' }}>
                                            {{ $src->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- ✅ Thêm 6 trường chăm sóc -->
                            <hr class="my-4">
                            <h5 class="text-primary mb-3"><i class="bi bi-chat-dots"></i> Thông tin chăm sóc khách hàng</h5>

                            <div class="col-md-4 mb-3">
                                <label for="first_care_date" class="form-label">Ngày CS1</label>
                                <input type="date" name="first_care_date" id="first_care_date" class="form-control" value="{{ old('first_care_date', $lead->first_care_date) }}">
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="result1" class="form-label">Kết quả CS1</label>
                                <input type="text" name="result1" id="result1" class="form-control" value="{{ old('result1', $lead->result1) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="two_care_date" class="form-label">Ngày CS2</label>
                                <input type="date" name="two_care_date" id="two_care_date" class="form-control" value="{{ old('two_care_date', $lead->two_care_date) }}">
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="result2" class="form-label">Kết quả CS2</label>
                                <input type="text" name="result2" id="result2" class="form-control" value="{{ old('result2', $lead->result2) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="three_care_date" class="form-label">Ngày CS3</label>
                                <input type="date" name="three_care_date" id="three_care_date" class="form-control" value="{{ old('three_care_date', $lead->three_care_date) }}">
                            </div>

                            <div class="col-md-8 mb-3">
                                <label for="result3" class="form-label">Kết quả CS3</label>
                                <input type="text" name="result3" id="result3" class="form-control" value="{{ old('result3', $lead->result3) }}">
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('lead.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-2"></i>
                                Cập nhật Lead
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Tips Card -->
            <div class="card fade-in">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightbulb me-2"></i>
                        Lưu ý
                    </h5>
                </div>
                <div class="card-body">
                    <p>Hãy kiểm tra kỹ thông tin Lead trước khi lưu. Dữ liệu sẽ được cập nhật trực tiếp vào hệ thống.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
