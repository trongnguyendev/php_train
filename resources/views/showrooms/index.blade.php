@extends('layouts.app')

@section('content')
@can('viewAny', App\Models\Showroom::class)
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h3"><i class="bi bi-building text-primary"></i> Quản lý Loại Showroom</h1>
        <a href="{{ route('showrooms.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Thêm loại showroom
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">Danh sách loại showroom</div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Tên loại</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($showroom as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td class="text-end">
                                <a href="{{ route('showrooms.show', $item) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('showrooms.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('showrooms.destroy', $item) }}" method="POST" class="d-inline">
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
@endcan
@cannot('viewAny', App\Models\Showroom::class)
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center">
                <!-- Icon -->
                <div class="mb-4">
                    <i class="bi bi-shield-lock text-danger" style="font-size: 5rem; opacity: 0.8;"></i>
                </div>
                
                <!-- Content -->
                <h3 class="fw-bold mb-3">Không có quyền truy cập</h3>
                <p class="text-muted mb-4">
                    Tài khoản của bạn không có quyền xem danh sách người dùng.
                </p>
                
                <!-- Action -->
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left me-2"></i>
                    Quay về trang chủ
                </a>
            </div>
        </div>
    </div>
</div>
@endcannot
@endsection
