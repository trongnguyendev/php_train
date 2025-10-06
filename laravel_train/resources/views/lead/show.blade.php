@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h2">
                <i class="bi bi-eye text-primary"></i> Chi tiết Lead
            </h1>
            <a href="{{ route('lead.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <!-- Lead Detail -->
    <div class="card fade-in">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th>Ngày khách đến xem</th><td>{{ $lead->customer_for_showroom }}</td></tr>
                <tr><th>Tên Lead</th><td>{{ $lead->name }}</td></tr>
                <tr><th>Số Điện thoại</th><td>{{ $lead->phone }}</td></tr>
                <tr><th>Tỉnh/Thành</th><td>{{ $lead->province?->name }}</td></tr>
                <tr><th>Địa chỉ</th><td>{{ $lead->address }}</td></tr>
                <tr><th>Zalo Feedback</th><td>{{ $lead->zalo_feedback }}</td></tr>
                <tr><th>Lead Đặt Hàng Chưa?</th><td>{{ $lead->typeCustomerYet?->name }}</td></tr>
                <tr><th>Phân Loại Lead (Zalo)</th><td>{{ $lead->typeCustomer?->name }}</td></tr>
                <tr><th>Showroom</th><td>{{ $lead->typeShowroom?->name }}</td></tr>
                <tr><th>Danh mục sản phẩm cần tư vấn</th><td>{{ $lead->cateloryProduct?->name }}</td></tr>
                <tr><th>Tình trạng lần đầu</th><td>{{ $lead->statusFirst?->name }}</td></tr>
                <tr><th>Ghi chú Sale</th><td>{{ $lead->note_sale }}</td></tr>
                <tr><th>Sale Nhận Thông Tin</th><td>{{ $lead->salenameInfor?->name }}</td></tr>
                <tr><th>Sale Hỗ Trợ</th><td>{{ $lead->salenameSupport?->name }}</td></tr>
                <tr><th>Tình Trạng Hiện Tại</th><td>{{ $lead->currentStatus?->name }}</td></tr>
                <tr><th>Giá Trị Đơn Hàng</th><td>{{ number_format($lead->order_value) }} đ</td></tr>
                <tr><th>Nguồn Lead</th><td>{{ $lead->source?->name }}</td></tr>
                
                <!-- ✅ Thêm 6 trường mới -->
                <tr><th>Ngày chăm sóc 1</th><td>{{ $lead->first_care_date }}</td></tr>
                <tr><th>Kết quả 1</th><td>{{ $lead->result1 }}</td></tr>
                <tr><th>Ngày chăm sóc 2</th><td>{{ $lead->two_care_date }}</td></tr>
                <tr><th>Kết quả 2</th><td>{{ $lead->result2 }}</td></tr>
                <tr><th>Ngày chăm sóc 3</th><td>{{ $lead->three_care_date }}</td></tr>
                <tr><th>Kết quả 3</th><td>{{ $lead->result3 }}</td></tr>

                <tr><th>Thời gian tạo</th><td>{{ $lead->created_at->format('d/m/Y H:i') }}</td></tr>
            </table>
        </div>
    </div>
</div>
@endsection
