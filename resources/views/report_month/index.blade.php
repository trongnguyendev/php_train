@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

  <form method="GET" action="" style="display:flex;gap:12px;align-items:end;flex-wrap:wrap">

    {{-- Khoảng ngày 1 --}}
    <div>
        <label style="font-weight: bold;">Từ ngày (1)</label>
        <input type="date"
               name="from_date_1"
               value="{{ request('from_date_1') }}"
               class="form-control form-control-sm">
    </div>

    <div>
        <label style="font-weight: bold;">Đến ngày (1)</label>
        <input type="date"
               name="to_date_1"
               value="{{ request('to_date_1') }}"
               class="form-control form-control-sm">
    </div>

    {{-- Khoảng ngày 2 --}}
    <div>
        <label style="font-weight: bold;">Từ ngày (2)</label>
        <input type="date"
               name="from_date_2"
               value="{{ request('from_date_2') }}"
               class="form-control form-control-sm">
    </div>

    <div>
        <label style="font-weight: bold;">Đến ngày (2)</label>
        <input type="date"
               name="to_date_2"
               value="{{ request('to_date_2') }}"
               class="form-control form-control-sm">
    </div>

    <div>
        <button type="submit" class="btn btn-primary btn-sm">
            Lọc
        </button>
    </div>
   <button
        type="submit"
        formaction="{{ route('report.month.export') }}"
        class="btn btn-success btn-sm">
        <i class="bi bi-file-earmark-excel"></i>
        Xuất Excel
    </button>

</form>
  

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tên Sale</th>
                            <th class="text-end">Tổng số khách hàng</th>
                            <th class="text-end">Tổng số khách hàng mới</th>
                            <th class="text-end">Tổng số khách hàng cũ</th>
                            <th class="text-end">Tổng Tiềm Năng Mới</th>
                            <th class="text-end">Tổng Tiềm Năng Cũ</th>
                            <th class="text-end">Tổng Khách Hàng Tiềm Năng</th>
                            <th class="text-end">Tổng KH Quan Tâm Còn Lại</th>
                            <th class="text-end">Tổng KH mới Đã Chốt</th>
                            <th class="text-end">Tổng KH cũ Đã Chốt</th>
                            <th class="text-end">DS chốt liền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                            <tr>
                                <td>{{ $item->sale_name }}</td>
                                <td class="text-end">{{ $item->total_customers }}</td>
                                <td class="text-end">{{ $item->total_new_customers }}</td>
                                <td class="text-end">{{ $item->total_old_customers }}</td>
                                <td class="text-end">{{ number_format($item->total_new_potential) }}</td>
                                <td class="text-end">{{ number_format($item->total_old_potential) }}</td>
                                <td class="text-end">{{ number_format($item->total_potential) }}</td>
                                <td class="text-end">{{ number_format($item->total_care) }}</td>
                                <td class="text-end">{{ number_format($item->total_new_locked) }}</td>
                                <td class="text-end">{{ number_format($item->total_old_locked) }}</td>
                                <td class="text-end">{{ number_format($item->total_value) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Chưa có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tên Sale</th>
                            <th class="text-end">Tổng số khách hàng</th>
                            <th class="text-end">Tổng số khách hàng mới</th>
                            <th class="text-end">Tổng số khách hàng cũ</th>
                            <th class="text-end">Tổng Tiềm Năng Mới</th>
                            <th class="text-end">Tổng Tiềm Năng Cũ</th>
                            <th class="text-end">Tổng Khách Hàng Tiềm Năng</th>
                            <th class="text-end">Tổng KH Quan Tâm Còn Lại</th>
                            <th class="text-end">Tổng KH mới Đã Chốt</th>
                            <th class="text-end">Tổng KH cũ Đã Chốt</th>
                            <th class="text-end">DS chốt liền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data_prev as $item)
                            <tr>
                                <td>{{ $item->sale_name }}</td>
                                <td class="text-end">{{ $item->total_customers }}</td>
                                <td class="text-end">{{ $item->total_new_customers }}</td>
                                <td class="text-end">{{ $item->total_old_customers }}</td>
                                <td class="text-end">{{ number_format($item->total_new_potential) }}</td>
                                <td class="text-end">{{ number_format($item->total_old_potential) }}</td>
                                <td class="text-end">{{ number_format($item->total_potential) }}</td>
                                <td class="text-end">{{ number_format($item->total_care) }}</td>
                                <td class="text-end">{{ number_format($item->total_new_locked) }}</td>
                                <td class="text-end">{{ number_format($item->total_old_locked) }}</td>
                                <td class="text-end">{{ number_format($item->total_value) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Chưa có dữ liệu</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
