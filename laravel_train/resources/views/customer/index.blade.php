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

    <!-- Search Form -->
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('customer.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Tìm theo tên khách hàng">
                </div>
                <div class="col-md-4">
                    <select name="status_first_id" class="form-select">
                        <option value="">Chọn Tình Trạng Khách Đến Đầu Tiên</option>
                        @foreach($statusList as $status)
                            <option value="{{ $status->id }}" @selected(request('status_first_id') == $status->id)>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                    <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

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
                    @forelse($customer as $item)
                        <tr>
                            <td>{{ $item->customer_for_showroom }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->phone }}</td>
                            <td>{{ $item->province?->name }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->zalo_feedback }}</td>
                            <td>{{ $item->typeCustomerYet?->name }}</td>
                            <td>{{ $item->typeCustomer?->name }}</td>
                            <td>{{ $item->typeShowroom?->name }}</td>
                            <td>{{ $item->cateloryProduct?->name }}</td>
                            <td>{{ $item->statusFirst?->name }}</td>
                            <td>{{ $item->note_sale }}</td>
                            <td>{{ $item->salenameInfor?->name }}</td>
                            <td>{{ $item->salenameSupport?->name }}</td>
                            <td>{{ $item->currentStatus?->name }}</td>
                            <td>{{ number_format($item->order_value) }} đ</td>
                            <td>{{ $item->source?->name }}</td>
                            @if ($item?->created_at)
                            <td>{{ $item?->created_at->format('d/m/Y H:i') }}</td>
                            @endif
                            <td class="text-center">
                                <a href="{{ route('customer.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('customer.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('customer.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
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

            <!-- Pagination -->
            <div class="mt-3">
                {{ $customer->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
