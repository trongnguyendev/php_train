@extends('layouts.app')

@section('content')
<div class="container-fluid px-4"> 
    <h1 class="h3 mb-4">
        <i class="bi bi-building text-info"></i>
        <span class="text-primary fw-bold">Chi tiết Lead</span>
        @if($lead->lead_type == 2)
            <span class="badge bg-info ms-2">Online</span>
        @elseif($lead->lead_type == 1)
            <span class="badge bg-warning ms-2">Trực tiếp</span>
        @endif
    </h1>
    
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            @if($lead->lead_type == 1)
            <p><strong>Mã Khách Hàng:</strong> {{ $lead->customerCode->customer_code ?? 'N/A' }}</p>
            <p><strong>Mã đơn hàng:</strong> {{ $lead->order_code }}</p>
            <p><strong>Ngày tương tác đầu tiên:</strong> {{ $lead->first_interaction_date }}</p>
            <p><strong>Tên khách hàng:</strong> {{ $lead->name }}</p>
            <p>
                <strong>Số điện thoại:</strong> 
                {{ is_array($phones) ? implode(', ', $phones) : $lead->phones->pluck('phone')->implode(', ') ?? '-' }}
            </p>
            <p><strong>Tỉnh/Thành phố:</strong> {{ $lead->province->name ?? '' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $lead->address }}</p>
            <p><strong>Zalo:</strong> {{ $lead->zalo }}</p>
            <p><strong>Phân Loại khách hàng:</strong> {{ $lead->customerType->name ?? '' }}</p>
            <p><strong>Danh mục sản phẩm:</strong> {{ $lead->productCategories->pluck('name')->implode(', ') }}</p>
            <p><strong>Showroom:</strong> {{ $lead->showroom->name ?? '' }}</p>
            <p><strong>Ghi chú sale nhận khách:</strong> {{ $lead->note }}</p>
            <p><strong>Sale nhận KH:</strong> {{ $lead->saleInformation->name ?? '' }}</p>
            <p><strong>Tình trạng KH hiện tại:</strong> {{ $lead->currentStatus->name ?? '' }}</p>
            <p><strong>Giá trị đơn chốt được:</strong> {{ number_format($lead->order_value) }}</p>
            <p><strong>KH đã được hỗ trợ trước qua kênh nào?:</strong> {{ $lead->supportedChannel ? $lead->supportedChannel->name : '' }}</p>
            <p><strong>Chuyển sang TMDT:</strong> {{ $lead->tmdt }}</p>
            @endif
            
            @if($lead->lead_type == 2)
            <p><strong>Mã Khách Hàng:</strong> {{ $lead->customerCode->customer_code ?? 'N/A' }}</p>
            <p><strong>Mã đơn hàng:</strong> {{ $lead->order_code }}</p>
            <p><strong>Ngày tương tác đầu tiên:</strong> {{ $lead->first_interaction_date }}</p>
            <p><strong>Tên khách hàng:</strong> {{ $lead->name }}</p>
            <p>
                <strong>Số điện thoại:</strong> 
                {{ is_array($phones) ? implode(', ', $phones) : $lead->phones->pluck('phone')->implode(', ') ?? '-' }}
            </p>
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
            <p><strong>Giá trị đơn chốt được:</strong> {{ number_format($lead->order_value) }}</p>
            <p><strong>Thông tin trao đổi với KH:</strong> {{ $lead->customer_discussion_details ?? '' }}</p>
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

    @if($lead->customerCode)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white fw-bold py-3">
            <i class="bi bi-list-stars text-warning me-1"></i> 
            Danh sách tất cả đơn hàng của khách hàng này (Mã khách: {{ $lead->customerCode->customer_code }})
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped mb-0 text-nowrap align-middle small">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Hành động</th>
                            <th class="text-center">Chỉnh sửa</th> <th>Mã Đơn Hàng</th>
                            <th>Loại Lead</th>
                            <th>Ngày tương tác đầu tiên</th>
                            <th>Tên khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Tỉnh/Thành phố</th>
                            <th>Địa chỉ</th>
                            <th>Zalo</th>
                            <th>Phân loại KH</th>
                            <th>Danh mục sản phẩm</th>
                            <th>Showroom / Nguồn</th>
                            <th>Tình trạng KH đầu / Kênh hỗ trợ</th>
                            <th>Ghi chú sale</th>
                            <th>Sale nhận KH</th>
                            <th>Sale hỗ trợ</th>
                            <th>Tình trạng hiện tại</th>
                            <th>Giá trị đơn</th>
                            <th>Chuyển TMDT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lead->customerCode->leads as $allOrder)
                            <tr class="{{ $allOrder->id == $lead->id ? 'table-warning fw-bold' : '' }}">
                                <td class="text-center">
                                    @if($allOrder->id != $lead->id)
                                        <a href="{{ route('leads.show', $allOrder->id) }}" class="btn btn-sm btn-primary py-0 px-2">
                                            Xem
                                        </a>
                                    @else
                                        <span class="badge bg-dark text-white">Đang xem</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('leads.edit', $allOrder->id) }}" class="btn btn-sm btn-warning py-0 px-2">
                                        <i class="bi bi-pencil-square"></i> Sửa
                                    </a>
                                </td>

                                <td>{{ $allOrder->order_code }}</td>
                                <td>
                                    @if($allOrder->lead_type == 2)
                                        <span class="badge bg-info text-dark">Online</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Trực tiếp</span>
                                    @endif
                                </td>
                                <td>{{ $allOrder->first_interaction_date }}</td>
                                <td>{{ $allOrder->name }}</td>
                                <td>{{ $allOrder->phones->pluck('phone')->implode(', ') ?: '-' }}</td>
                                <td>{{ $allOrder->province->name ?? '-' }}</td>
                                <td>{{ $allOrder->address ?? '-' }}</td>
                                <td>{{ $allOrder->zalo ?? '-' }}</td>
                                <td>{{ $allOrder->customerType->name ?? '-' }}</td>
                                <td>{{ $allOrder->productCategories->pluck('name')->implode(', ') ?: '-' }}</td>
                                <td>
                                    @if($allOrder->lead_type == 1)
                                        {{ $allOrder->showroom->name ?? '-' }} (SR)
                                    @else
                                        {{ $allOrder->customerSource->name ?? '-' }} (Nguồn)
                                    @endif
                                </td>
                                <td>
                                    @if($allOrder->lead_type == 1)
                                        {{ $allOrder->supportedChannel->name ?? '-' }}
                                    @else
                                        {{ $allOrder->firstStatus->name ?? '-' }}
                                    @endif
                                </td>
                                <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis;">{{ $allOrder->note ?? '-' }}</td>
                                <td>{{ $allOrder->saleInformation->name ?? '-' }}</td>
                                <td>{{ $allOrder->saleSupport->name ?? '-' }}</td>
                                <td>{{ $allOrder->currentStatus->name ?? '-' }}</td>
                                <td class="text-danger fw-bold">{{ number_format($allOrder->order_value) }} đ</td>
                                <td>{{ $allOrder->tmdt ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="20" class="text-center text-muted p-3">Không có đơn hàng nào khác.</td> </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <div class="mt-2 mb-4">
        
        <a href="{{ route('leads.index', request()->query()) }}">← Quay lại danh sách</a>
        <a href="{{ route('leads.edit', $lead->id) . '?' . http_build_query(request()->query()) }}" class="btn btn-warning ms-1"><i class="bi bi-pencil-square"></i> Sửa đơn hiện tại</a>
        
    </div>
</div>
@endsection