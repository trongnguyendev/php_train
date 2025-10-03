@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h2">
                <i class="bi bi-eye text-primary"></i> Chi tiết Khách hàng
            </h1>
            <a href="{{ route('leadonline.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Customer Detail -->
    <div class="card fade-in">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>Ngày khách đến xem</th><td>{{ $leadOnline->customer_for_showroom }}</td></tr>
                <tr><th>Tên Khách Hàng</th><td>{{ $leadOnline->name }}</td></tr>
                <tr><th>Số Điện thoại</th><td>{{ $leadOnline->phone }}</td></tr>
                <tr><th>Tỉnh/Thành</th><td>{{ $leadOnline->province?->name }}</td></tr>
                <tr><th>Địa chỉ</th><td>{{ $leadOnline->address }}</td></tr>
                <tr><th>Zalo Feedback</th><td>{{ $leadOnline->zalo_feedback }}</td></tr>
                <tr><th>Khách Đã Đặt Hàng Chưa?</th><td>{{ $leadOnline->typeCustomerYet?->name }}</td></tr>
                <tr><th>Zalo Phân Loại Khách Hàng</th><td>{{ $leadOnline->typeCustomer?->name }}</td></tr>
                <tr><th>Showroom</th><td>{{ $leadOnline->typeShowroom?->name }}</td></tr>
                <tr><th>Danh mục sản phẩm cần tư vấn?</th><td>{{ $leadOnline->cateloryProduct?->name }}</td></tr>
                <tr><th>Tình trạng khách đến đầu tiên</th><td>{{ $leadOnline->statusFirst?->name }}</td></tr>
                <tr><th>Ghi chú</th><td>{{ $leadOnline->note_sale }}</td></tr>
                <tr><th>Sale Nhận Thông Tin</th><td>{{ $leadOnline->salenameInfor?->name }}</td></tr>
                <tr><th>Sale Hỗ Trợ Khách Hàng</th><td>{{ $leadOnline->salenameSupport?->name }}</td></tr>
                <tr><th>Tình Trạng Khách Hàng Hiện Tại</th><td>{{ $leadOnline->currentStatus?->name }}</td></tr>
                <tr><th>Giá Trị Đơn Hàng</th><td>{{ number_format($leadOnline->order_value) }} đ</td></tr>
                <tr><th>Ngày Chăm Khách Lần 1</th><td>{{ $leadOnline->first_care_date}}</td></tr>
                <tr><th>Kết Quả Lần 1</th><td>{{ $leadOnline->result1 }}</td></tr>
                <tr><th>Ngày Chăm Khách Lần 2</th><td>{{ $leadOnline->two_care_date }}</td></tr>
                <tr><th>Kết Quả Lần 2</th><td>{{ $leadOnline->result2}}</td></tr>
                <tr><th>Ngày Chăm Khách Lần 3</th><td>{{ $leadOnline->three_care_date}}</td></tr>
                <tr><th>Kết Quả Lần 3</th><td>{{ $leadOnline->result3}}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
