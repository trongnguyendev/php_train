@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4">
        <i class="bi bi-building text-info"></i>
        <span class="text-primary fw-bold">Chi tiết Lead</span>
        @if($lead->lead_type == 2)
            <span class="badge bg-info ms-2">Online</span>
        @elseif($lead->lead_type == 1)
            <span class="badge bg-warning ms-2">Trực tiếp</span>
        @endif
    </h1>
    <div class="card shadow-sm">
        <div class="card-body">
            @if($lead->lead_type == 1)
            <p><strong>ID:</strong> {{ $lead->id }}</p>
            <p><strong>Ngày tương tác đầu tiên:</strong> {{ $lead->first_interaction_date }}</p>
            <p><strong>Tên khách hàng:</strong> {{ $lead->name }}</p>
            <p><strong>Số điện thoại:</strong> {{ $lead->phone }}</p>
            <p><strong>Tỉnh/Thành phố:</strong> {{ $lead->province->name ?? '' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $lead->address }}</p>
            <p><strong>Zalo:</strong> {{ $lead->zalo }}</p>
            <p><strong>Phân Loại khách hàng:</strong> {{ $lead->customerType->name ?? '' }}</p>
            <p><strong>Danh mục sản phẩm:</strong> {{ $lead->productCategories->pluck('name')->implode(', ') }}</p>
            <p><strong>Showroom:</strong> {{ $lead->showroom->name ?? '' }}</p>
            <p><strong>Ghi chú sale nhận khách:</strong> {{ $lead->note }}</p>
            <p><strong>Sale nhận KH:</strong> {{ $lead->saleInformation->name ?? '' }}</p>
            <p><strong>Tình trạng KH hiện tại:</strong> {{ $lead->currentStatus->name ?? '' }}</p>
            <p><strong>Giá trị đơn chốt được:</strong> {{ $lead->order_value }}</p>
            <p><strong>Trạng thái hỗ trợ:</strong> {{ $lead->supportStatusCustomer->name ?? '' }}</p>
            <p><strong>KH đã được hỗ trợ trước qua kênh nào?:</strong> {{ $lead->supportedChannel ? $lead->supportedChannel->name : '' }}</p>
            <p><strong>Chuyển sang TMDT:</strong> {{ $lead->tmdt }}</p>
            @endif
            
            @if($lead->lead_type == 2)
            <p><strong>ID:</strong> {{ $lead->id }}</p>
            <p><strong>Ngày tương tác đầu tiên:</strong> {{ $lead->first_interaction_date }}</p>
            <p><strong>Tên khách hàng:</strong> {{ $lead->name }}</p>
            <p><strong>Số điện thoại:</strong> {{ $lead->phone }}</p>
            <p><strong>Tỉnh/Thành phố:</strong> {{ $lead->province->name ?? '' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $lead->address }}</p>
            <p><strong>Zalo:</strong> {{ $lead->zalo }}</p>
            <p><strong>Phân Loại khách hàng:</strong> {{ $lead->customerType->name ?? '' }}</p>
            <p><strong>Nguồn:</strong> {{ $lead->customerSource->name ?? '' }}</p>
            <p><strong>Danh mục sản phẩm:</strong> {{ $lead->productCategories->pluck('name')->implode(', ') }}</p>
            <p><strong>Tình trạng KH ban đầu:</strong> {{ $lead->firstStatus->name ?? '' }}</p>
            <p><strong>Ghi chú sale nhận khách:</strong> {{ $lead->note }}</p>
            <p><strong>Sale nhận KH:</strong> {{ $lead->saleInformation->name ?? '' }}</p>
            <p><strong>Sale hỗ trợ:</strong> {{ $lead->saleSupport->name ?? '' }}</p>
            <p><strong>Tình trạng KH hiện tại:</strong> {{ $lead->currentStatus->name ?? '' }}</p>
            <p><strong>Thông tin trao đổi với KH:</strong> {{ $lead->customer_discussion_details->name ?? '' }}</p>
            <p><strong>Chuyển sang TMDT:</strong> {{ $lead->tmdt }}</p>
            <hr>
            <h5>Thông tin chăm sóc khách hàng</h5>
            @foreach($lead->leadTakeCares->take(3) as $care)
                <div class="mb-2">
                    <strong>Kế hoạch:</strong> {{ $care->take_care_plan }}<br>
                    <strong>Ngày:</strong> {{ $care->take_care_date }}<br>
                    <strong>Kết quả:</strong> {{ $care->take_care_result }}
                </div>
            @endforeach
            @endif

        </div>
    </div>
    <a href="{{ route('leads.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection
