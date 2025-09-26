@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h2">
                <i class="bi bi-people-fill text-primary"></i> Quản lý Khách hàng
            </h1>
            <a href="{{ route('customer.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Thêm Khách hàng
            </a>
        </div>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Customer Table -->
    <div class="card fade-in">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Ngày khách đến xem</th>
                        <th>Tên Khách Hàng</th>
                        <th>Số Điện thoại</th>
                        <th>Tỉnh/Thành</th>
                        <th>Địa Chỉ</th>
                        <th>Zalo Feedback</th>
                        <th>Khách Đã Đặt Hàng Chưa?</th>
                        <th>Zalo Phân Loại Khách Hàng</th>
                        <th>Showroom</th>
                        <th>Danh mục sản phẩm cần tư vấn?</th>
                        <th>Tình trạng khách đến đầu tiên</th>
                        <th>Ghi Chú</th>
                        <th>Sale Nhận Thông Tin</th>
                        <th>Sale Hỗ Trợ Khách Hàng</th>
                        <th>Tình Trạng Khách Hàng Hiện Tại</th>
                        <th>Giá Trị Đơn Hàng</th>
                        <th>Khách Hàng Đã Được Hỗ Trợ Chưa?</th>
                        <th>Thời Gian Tạo</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customer as $customer)
                        <tr>
                            <td>{{ $customer->customer_for_showroom }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->province?->name }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>{{ $customer->zalo_feedback }}</td>
                            <td>{{ $customer->typeCustomerYet?->name }}</td>
                            <td>{{ $customer->typeCustomer?->name }}</td>
                            <td>{{ $customer->typeShowroom?->name }}</td>
                            <td>{{ $customer->cateloryProduct?->name }}</td>
                            <td>{{ $customer->statusFirst?->name }}</td>
                            <td>{{ $customer->note_sale }}</td>
                            <td>{{ $customer->salenameInfor?->name }}</td>
                            <td>{{ $customer->salenameSupport?->name }}</td>
                            <td>{{ $customer->currentStatus?->name }}</td>
                            <td>{{ number_format($customer->order_value) }} đ</td>
                            <td>{{ $customer->source?->name }}</td>
                            <td>{{ $customer->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('customer.show', $customer->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="19" class="text-center">Chưa có khách hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
