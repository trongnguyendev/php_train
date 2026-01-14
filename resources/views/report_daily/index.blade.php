@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

  

<div class="card">
    <div class="card-header">Báo cáo khách theo ngày: {{ isset($date) ? \Carbon\Carbon::parse($date)->format('d/m/Y') : '' }}</div>
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
@endsection
