@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="fas fa-user-plus me-2"></i>Thêm Lead mới</h4>
        <a href="{{ route('lead.index') }}" class="btn btn-light border">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold">
            <i class="fas fa-info-circle me-2"></i>Thông tin Lead
        </div>

        <div class="card-body">
            <form action="{{ route('lead.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <label for="date_first" class="form-label">Ngày tương tác đầu tiên</label>
                        <input type="date" name="date_first" id="date_first" class="form-control">
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="name" class="form-label">Tên Lead / Tên Pancake</label>
                        <input type="text" name="name" id="name" placeholder="Nhập tên lead" class="form-control">
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" placeholder="VD: 098xxxxxxx" class="form-control">
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="province_id" class="form-label">Tỉnh/TP</label>
                        <select name="province_id" id="province_id" class="form-select">
                            <option value="">-- Chọn Tỉnh/TP --</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="da_dat_hang_chua" class="form-label">Khách đã đặt hàng chưa?</label>
                        <select name="da_dat_hang_chua" id="da_dat_hang_chua" class="form-select">
                            <option value="">-- Chọn tình trạng lead --</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="type_customer_id" class="form-label">Phân loại Lead</label>
                        <select name="type_customer_id" id="type_customer_id" class="form-select">
                            <option value="">-- Chọn phân loại lead --</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="showroom_id" class="form-label">Showroom nào?</label>
                        <select name="showroom_id" id="showroom_id" class="form-select">
                            <option value="">-- Chọn showroom --</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="category_product_id" class="form-label">Sản phẩm cần tư vấn đầu tiên</label>
                        <select name="category_product_id" id="category_product_id" class="form-select">
                            <option value="">-- Chọn danh mục sản phẩm --</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-4">
                        <label for="status_first_id" class="form-label">Tình trạng Lead đầu tiên</label>
                        <select name="status_first_id" id="status_first_id" class="form-select">
                            <option value="">-- Chọn tình trạng đầu tiên --</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="address" class="form-label">Địa chỉ chi tiết</label>
                        <textarea name="address" id="address" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="zalo_feedback" class="form-label">Zalo Feedback</label>
                        <input type="text" name="zalo_feedback" id="zalo_feedback" class="form-control">
                    </div>

                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Lưu Lead
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
