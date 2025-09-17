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
                        <i class="bi bi-pencil-fill text-warning"></i>
                        Chỉnh sửa Khách hàng
                    </h1>
                    <p class="text-muted">Cập nhật thông tin khách hàng: {{ $customer->name }}</p>
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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                    <form action="{{ route('customer.update', $customer) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                <input type="date" name="start_date" id="start_date"
                                       class="form-control @error('start_date') is-invalid @enderror"
                                       value="{{ old('start_date', $customer->start_date) }}">
                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Tên khách hàng</label>
                                <input type="text" name="name" id="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $customer->name) }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" name="phone" id="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $customer->phone) }}">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="province" class="form-label">Tỉnh/Thành phố</label>
                                <input type="text" name="province" id="province"
                                       class="form-control @error('province') is-invalid @enderror"
                                       value="{{ old('province', $customer->province) }}">
                                @error('province') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" name="address" id="address"
                                       class="form-control @error('address') is-invalid @enderror"
                                       value="{{ old('address', $customer->address) }}">
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type_customer" class="form-label">Loại khách hàng</label>
                                <input type="text" name="type_customer" id="type_customer"
                                       class="form-control @error('type_customer') is-invalid @enderror"
                                       value="{{ old('type_customer', $customer->type_customer) }}">
                                @error('type_customer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="page_source" class="form-label">Nguồn trang</label>
                                <input type="text" name="page_source" id="page_source"
                                       class="form-control @error('page_source') is-invalid @enderror"
                                       value="{{ old('page_source', $customer->page_source) }}">
                                @error('page_source') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sale_product" class="form-label">Sản phẩm quan tâm</label>
                                <input type="text" name="sale_product" id="sale_product"
                                       class="form-control @error('sale_product') is-invalid @enderror"
                                       value="{{ old('sale_product', $customer->sale_product) }}">
                                @error('sale_product') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="first_guest_status" class="form-label">Trạng thái khách lần đầu</label>
                                <input type="text" name="first_guest_status" id="first_guest_status"
                                       class="form-control @error('first_guest_status') is-invalid @enderror"
                                       value="{{ old('first_guest_status', $customer->first_guest_status) }}">
                                @error('first_guest_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="note" class="form-label">Ghi chú</label>
                                <textarea name="note" id="note" rows="3"
                                          class="form-control @error('note') is-invalid @enderror">{{ old('note', $customer->note) }}</textarea>
                                @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="sale_infor" class="form-label">Thông tin Sale</label>
                                <input type="text" name="sale_infor" id="sale_infor"
                                       class="form-control @error('sale_infor') is-invalid @enderror"
                                       value="{{ old('sale_infor', $customer->sale_infor) }}">
                                @error('sale_infor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="current_guest_status" class="form-label">Trạng thái hiện tại</label>
                                <input type="text" name="current_guest_status" id="current_guest_status"
                                       class="form-control @error('current_guest_status') is-invalid @enderror"
                                       value="{{ old('current_guest_status', $customer->current_guest_status) }}">
                                @error('current_guest_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="information_exchange" class="form-label">Trao đổi thông tin</label>
                                <textarea name="information_exchange" id="information_exchange" rows="3"
                                          class="form-control @error('information_exchange') is-invalid @enderror">{{ old('information_exchange', $customer->information_exchange) }}</textarea>
                                @error('information_exchange') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="results" class="form-label">Kết quả</label>
                                <input type="text" name="results" id="results"
                                       class="form-control @error('results') is-invalid @enderror"
                                       value="{{ old('results', $customer->results) }}">
                                @error('results') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="take_care_guest_first_one" class="form-label">Người chăm sóc đầu tiên</label>
                                <input type="date" name="take_care_guest_first_one" id="take_care_guest_first_one"
                                       class="form-control @error('take_care_guest_first_one') is-invalid @enderror"
                                       value="{{ old('take_care_guest_first_one', $customer->take_care_guest_first_one) }}">
                                @error('take_care_guest_first_one') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>
                                Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-2"></i>
                                Cập nhật thông tin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar (Current Info) -->
        <div class="col-lg-4">
            <div class="card fade-in">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Thông tin hiện tại
                    </h5>
                </div>
                <div class="card-body">
                    <p><strong>ID:</strong> {{ $customer->id }}</p>
                    <p><strong>Ngày tạo:</strong> {{ $customer->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Cập nhật lần cuối:</strong> {{ $customer->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection