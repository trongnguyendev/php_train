@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-primary">📋 Danh sách Lead</h1>

    <a href="{{ route('leads.create') }}" class="btn btn-success mb-3">+ Thêm Lead mới</a>

    <!-- form tìm kiếm -->
    <form action="{{ route('leads.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-3 flex-wrap">
    {{-- Ô nhập SĐT --}}
    <input 
        type="text" 
        name="type_phone" 
        class="form-control" 
        placeholder="Nhập số điện thoại..." 
        value="{{ request('type_phone') }}"
        style="max-width: 200px;"
    >

    {{-- Ô chọn ngày --}}
    <input 
        type="date" 
        name="first_arrival_date" 
        class="form-control" 
        value="{{ request('first_arrival_date') }}"
        style="max-width: 200px;"
    >

    {{-- Nút tìm kiếm --}}
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-search"></i> Tìm kiếm
    </button>
    </form>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Ngày đầu tiên</th>
                <th>Tên KH</th>
                <th>Điện thoại</th>
                <th>Tỉnh/Thành</th>
                <th>Địa chỉ</th>
                <th>Zalo</th>
                <th>Loại KH</th>
                <th>Tình trạng KH</th>
                <th>Nguồn KH</th>
                <th>Danh mục SP</th>
                <th>Showroom</th>
                <th>Tình trạng đầu tiên</th>
                <th>Ghi chú</th>
                <th>Sale nhận</th>
                <th>Sale hỗ trợ</th>
                <th>Tình trạng hiện tại</th>
                <th>Giá trị đơn</th>
                <th>Trạng thái hỗ trợ</th>
                <th>Nội dung trao đổi</th>
                <th>Kết quả</th>
                <th>Loại Lead</th>

                {{-- 3 lần chăm sóc --}}
                <th>Kế hoạch chăm sóc 1</th>
                <th>Ngày chăm sóc 1</th>
                <th>Kết quả chăm sóc 1</th>

                <th>Kế hoạch chăm sóc 2</th>
                <th>Ngày chăm sóc 2</th>
                <th>Kết quả chăm sóc 2</th>

                <th>Kế hoạch chăm sóc 3</th>
                <th>Ngày chăm sóc 3</th>
                <th>Kết quả chăm sóc 3</th>

                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leads as $lead)
                @php
                    // Lấy tối đa 3 lần chăm sóc, sắp theo ngày tăng dần
                    $takeCares = $lead->leadTakeCares->sortBy('take_care_date')->values();
                    $care1 = $takeCares->get(0);
                    $care2 = $takeCares->get(1);
                    $care3 = $takeCares->get(2);
                @endphp
                <tr>
                    <td>{{ $lead->id }}</td>
                    <td>{{ $lead->first_arrival_date }}</td>
                    <td>{{ $lead->name }}</td>
                    <td>{{ $lead->phone }}</td>
                    <td>{{ $lead->province->name ?? '' }}</td>
                    <td>{{ $lead->address }}</td>
                    <td>{{ $lead->zalo }}</td>
                    <td>{{ $lead->customerType->name ?? '' }}</td>
                    <td>
                        @if($lead->is_new_customer)
                            <span class="badge bg-success">Mới</span>
                        @else
                            <span class="badge bg-secondary">Cũ</span>
                        @endif
                    </td>
                    <td>{{ $lead->customerSource->name ?? '' }}</td>
                    <td>{{ $lead->productCategory->name ?? '' }}</td>
                    <td>{{ $lead->showroom->name ?? '' }}</td>
                    <td>{{ $lead->firstStatus->name ?? '' }}</td>
                    <td>{{ Str::limit($lead->note, 30) }}</td>
                    <td>{{ $lead->saleReceive->name ?? '' }}</td>
                    <td>{{ $lead->saleSupport->name ?? '' }}</td>
                    <td>{{ $lead->currentStatus->name ?? '' }}</td>
                    <td>{{ number_format($lead->order_value) }}</td>
                    <td>{{ $lead->supportStatus->name ?? '' }}</td>
                    <td>{{ Str::limit($lead->exchange_content, 30) }}</td>
                    <td>{{ $lead->results }}</td>
                    <td>{{ $lead->lead_type }}</td>

                    {{-- Lần chăm sóc 1 --}}
                    <td>{{ $care1->take_care_plan ?? '' }}</td>
                    <td>{{ $care1->take_care_date ?? '' }}</td>
                    <td>{{ $care1->take_care_result ?? '' }}</td>

                    {{-- Lần chăm sóc 2 --}}
                    <td>{{ $care2->take_care_plan ?? '' }}</td>
                    <td>{{ $care2->take_care_date ?? '' }}</td>
                    <td>{{ $care2->take_care_result ?? '' }}</td>

                    {{-- Lần chăm sóc 3 --}}
                    <td>{{ $care3->take_care_plan ?? '' }}</td>
                    <td>{{ $care3->take_care_date ?? '' }}</td>
                    <td>{{ $care3->take_care_result ?? '' }}</td>

                    <td>
                        <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-sm btn-info">Xem</a>
                        <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa Lead này và các chăm sóc liên quan?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Phân trang --}}
    <div class="mt-3">
    </div>
</div>
@endsection
