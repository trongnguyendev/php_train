@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h2"><i class="bi bi-flag-fill text-primary"></i> Quản lý Trạng thái</h1>
            <a href="{{ route('status.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Thêm Trạng thái
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">Danh sách Trạng thái</div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tên Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($statuses as $status)
                        <tr>
                            <td>{{ $status->name }}</td>
                            <td class="text-end">
                                <a href="{{ route('status.show', $status) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('status.edit', $status) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('status.destroy', $status) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa trạng thái này?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">Chưa có trạng thái nào</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
