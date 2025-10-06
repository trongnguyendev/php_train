@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h2">
                <i class="bi bi-people-fill text-primary"></i> Quản lý Lead
            </h1>
            <a href="{{ route('lead.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Thêm Lead
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
            <form action="{{ route('lead.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="name" value="{{ request('name') }}" class="form-control" placeholder="Tìm theo tên Lead">
                </div>
                <div class="col-md-4">
                    <select name="status_first_id" class="form-select">
                        <option value="">Chọn Tình Trạng Lead Đầu Tiên</option>
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
                    <a href="{{ route('lead.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Lead Table -->
    <div class="card fade-in">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Ngày tương tác đầu tiên</th>
                        <th>Tên Lead</th>
                        <th>Số Điện thoại</th>
                        <th>Tỉnh/Thành</th>
                        <th>Địa Chỉ</th>
                        <th>Zalo Feedback</th>
                        <th>Khách Đã Đặt Hàng Chưa?</th>
                        <th>Phân Loại Khách Hàng</th>
                        <th>Showroom</th>
                        <th>Sản phẩm tư vấn đầu tiên</th>
                        <th>Tình trạng Lead đầu tiên</th>
                        <th>Ghi Chú</th>
                        <th>Sale Nhận Thông Tin</th>
                        <th>Sale Hỗ Trợ</th>
                        <th>Tình Trạng Lead Hiện Tại</th>
                        <th>Giá Trị Đơn Chốt</th>
                        <th>Lead Đã Được Hỗ Trợ Chưa?</th>

                        <!-- ✅ Thêm 6 cột CS -->
                        <th>Ngày CS1</th>
                        <th>Kết quả CS1</th>
                        <th>Ngày CS2</th>
                        <th>Kết quả CS2</th>
                        <th>Ngày CS3</th>
                        <th>Kết quả CS3</th>

                        <th>Ngày Tạo</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lead as $item)
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
                            <td>{{ $item->category?->name }}</td>
                            <td>{{ $item->statusFirst?->name }}</td>
                            <td>{{ $item->note_sale }}</td>
                            <td>{{ $item->salenameInfor?->name }}</td>
                            <td>{{ $item->salenameSupport?->name }}</td>
                            <td>{{ $item->currentStatus?->name }}</td>
                            <td>{{ number_format($item->order_value) }} đ</td>
                            <td>{{ $item->source?->name }}</td>

                            <!-- ✅ Thêm cột CS -->
                            <td>{{ $item->first_care_date }}</td>
                            <td>{{ $item->result1 }}</td>
                            <td>{{ $item->two_care_date }}</td>
                            <td>{{ $item->result2 }}</td>
                            <td>{{ $item->three_care_date }}</td>
                            <td>{{ $item->result3 }}</td>

                            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('lead.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('lead.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('lead.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa Lead này?')">
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
                            <td colspan="25" class="text-center">Chưa có Lead nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $lead->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
