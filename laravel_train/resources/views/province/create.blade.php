@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-person-plus-fill text-primary"></i>
                        Thêm Khách hàng mới
                    </h1>
                    <p class="text-muted">Tạo thông tin khách hàng mới trong hệ thống</p>
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
                        Thông tin khách hàng
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Ngày tương tác đầu tiên</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Tên Khách / Tên Pancake</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Nhập tên khách hàng">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="VD: 098xxxxxxx">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="province" class="form-label">Tỉnh/Thành Phố</label>
                                <input type="text" name="province" id="province" class="form-control" value="{{ old('province') }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Địa chỉ chi tiết</label>
                                <textarea name="address" id="address" rows="2" class="form-control">{{ old('address') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type_customer" class="form-label">Phân loại khách hàng</label>
                                <input type="text" name="type_customer" id="type_customer" class="form-control" value="{{ old('type_customer') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="page_source" class="form-label">Nguồn</label>
                                <input type="text" name="page_source" id="page_source" class="form-control" value="{{ old('page_source') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sale_product" class="form-label">Sản phẩm cần tư vấn</label>
                                <input type="text" name="sale_product" id="sale_product" class="form-control" value="{{ old('sale_product') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="first_guest_status" class="form-label">Tình trạng khách đầu tiên</label>
                                <input type="text" name="first_guest_status" id="first_guest_status" class="form-control" value="{{ old('first_guest_status') }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="note" class="form-label">Ghi chú (Sale nhận khách)</label>
                                <textarea name="note" id="note" rows="2" class="form-control">{{ old('note') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sale_infor" class="form-label">Sale nhận thông tin khách</label>
                                <input type="text" name="sale_infor" id="sale_infor" class="form-control" value="{{ old('sale_infor') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="current_guest_status" class="form-label">Tình trạng khách hiện tại</label>
                                <input type="text" name="current_guest_status" id="current_guest_status" class="form-control" value="{{ old('current_guest_status') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="information_exchange" class="form-label">Thông tin trao đổi với KH</label>
                                <textarea name="information_exchange" id="information_exchange" rows="2" class="form-control">{{ old('information_exchange') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="results" class="form-label">Kết quả</label>
                                <input type="text" name="results" id="results" class="form-control" value="{{ old('results') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="take_care_guest_first_one" class="form-label">Ngày sẽ chăm khách lần 1</label>
                                <input type="date" name="take_care_guest_first_one" id="take_care_guest_first_one" class="form-control" value="{{ old('take_care_guest_first_one') }}">
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>
                                Tạo khách hàng
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
                    <p>Điền đầy đủ thông tin khách hàng để thuận tiện cho việc chăm sóc và quản lý.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
