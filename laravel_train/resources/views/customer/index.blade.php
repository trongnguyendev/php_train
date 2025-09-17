@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-people-fill text-primary"></i>
                        Quản lý Khách hàng
                    </h1>
                    <p class="text-muted">Quản lý tất cả khách hàng trong hệ thống</p>
                </div>
                <a href="{{ route('customer.create') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-person-plus-fill"></i>
                    Thêm Khách hàng mới
                </a>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong>Thành công!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Customer Table -->
    <div class="card fade-in">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-table me-2"></i>
                Danh sách Khách hàng
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Ngày tương tác đầu tiên</th>
                            <th>Tên Khách/Tên Pancake</th>
                            <th>SDT</th>
                            <th>Tỉnh/Thành Phố</th>
                            <th>Địa chỉ chi tiết</th>
                            <th>Phân loại khách hàng</th>
                            <th>Nguồn</th>
                            <th>Sản phẩm cần tư vấn</th>
                            <th>Tình trạng khách đầu tiên</th>
                            <th>Ghi chú</th>
                            <th>Sale nhận thông tin</th>
                            <th>Tình trạng khách hiện tại</th>
                            <th>Thông tin trao đổi với KH</th>
                            <th>Kết quả</th>
                            <th>Ngày sẽ chăm khách lần 1</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customer as $customer)
                            <tr>
                                <td>{{ $customer->start_date }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ $customer->province }}</td>
                                <td>{{ $customer->address }}</td>
                                <td>{{ $customer->type_customer }}</td>
                                <td>{{ $customer->page_source }}</td>
                                <td>{{ $customer->sale_product }}</td>
                                <td>{{ $customer->first_guest_status }}</td>
                                <td>{{ $customer->note }}</td>
                                <td>{{ $customer->sale_infor }}</td>
                                <td>{{ $customer->current_guest_status }}</td>
                                <td>{{ $customer->information_exchange }}</td>
                                <td>{{ $customer->results }}</td>
                                <td>{{ $customer->take_care_guest_first_one }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('customer.show', $customer) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('customer.edit', $customer) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('customer.destroy', $customer) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('⚠️ Bạn có chắc chắn muốn xóa khách hàng này?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="17" class="text-center py-5">
                                    <i class="bi bi-emoji-frown display-1 text-muted"></i>
                                    <h4 class="mt-3">Chưa có khách hàng nào</h4>
                                    <a href="{{ route('customer.create') }}" class="btn btn-primary">
                                        <i class="bi bi-person-plus-fill me-2"></i> Tạo khách hàng đầu tiên
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
