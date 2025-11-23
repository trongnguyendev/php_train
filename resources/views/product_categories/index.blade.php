@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h3"><i class="bi bi-building text-primary"></i> Quản lý Loại Danh mục sản phẩm</h1>
        <a href="{{ route('product_categories.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm danh mục sản phẩm
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">Danh Sách Danh mục sản phẩm</div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tên loại</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productCategory as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td class="text-end">
                                <a href="{{ route('product_categories.show', $item) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('product_categories.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('product_categories.destroy', $item) }}" method="POST" class="d-inline">
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
