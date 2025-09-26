@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h2">
                <i class="bi bi-eye text-primary"></i> Chi tiết Khách hàng
            </h1>
            <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Customer Detail -->
    <div class="card fade-in">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>Ngày khách đến xem</th><td>{{ $customer->customer_for_showroom }}</td></tr>
                <tr><th>Tên Khách Hàng</th><td>{{ $customer->name }}</td></tr>
                <tr><th>Số Điện thoại</th><td>{{ $customer->phone }}</td></tr>
                <tr><th>Tỉnh/Thành</th><td>{{ $customer->province?->name }}</td></tr>
                <tr><th>Địa chỉ</th><td>{{ $customer->address }}</td></tr>
                <tr><th>Zalo Feedback</th><td>{{ $customer->zalo_feedback }}</td></tr>
                <tr><th>Khách Đã Đặt Hàng Chưa?</th><td>{{ $customer->typeCustomerYet?->name }}</td></tr>
                <tr><th>Zalo Phân Loại Khách Hàng</th><td>{{ $customer->typeCustomer?->name }}</td></tr>
                <tr><th>Showroom</th><td>{{ $customer->typeShowroom?->name }}</td></tr>
                <tr><th>Danh mục sản phẩm cần tư vấn?</th><td>{{ $customer->cateloryProduct?->name }}</td></tr>
                <tr><th>Tình trạng khách đến đầu tiên</th><td>{{ $customer->statusFirst?->name }}</td></tr>
                <tr><th>Ghi chú</th><td>{{ $customer->note_sale }}</td></tr>
                <tr><th>Sale Nhận Thông Tin</th><td>{{ $customer->salenameInfor?->name }}</td></tr>
                <tr><th>Sale Hỗ Trợ Khách Hàng</th><td>{{ $customer->salenameSupport?->name }}</td></tr>
                <tr><th>Tình Trạng Khách Hàng Hiện Tại</th><td>{{ $customer->currentStatus?->name }}</td></tr>
                <tr><th>Giá Trị Đơn Hàng</th><td>{{ number_format($customer->order_value) }} đ</td></tr>
                <tr><th>Nguồn khách</th><td>{{ $customer->source?->name }}</td></tr>
                <tr><th>Thời gian tạo</th><td>{{ $customer->created_at->format('d/m/Y H:i') }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
