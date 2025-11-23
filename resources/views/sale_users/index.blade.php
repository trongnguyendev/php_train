@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h3"><i class="bi bi-building text-primary"></i> Quản lý Loại Danh mục Sale</h1>
        <a href="{{ route('sale_users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm danh sách Sale
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">Danh Sách Sale</div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tên loại</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($saleUsers as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td class="text-end">
                                <a href="{{ route('sale_users.show', $item) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('sale_users.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('sale_users.destroy', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa loại showroom này?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Chưa có loại showroom nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
