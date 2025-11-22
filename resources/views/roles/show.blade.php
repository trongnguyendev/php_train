@extends('layouts.app')

@section('content')
@can('view', App\Models\Role::class)
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-eye text-primary"></i>
                        Chi tiết Role: {{ $role->name }}
                    </h1>
                    <p class="text-muted">Thông tin chi tiết về role và permissions</p>
                </div>
                <div>
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i>
                        Chỉnh sửa
                    </a>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Thông tin Role
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">ID:</th>
                            <td><span class="badge bg-secondary">{{ $role->id }}</span></td>
                        </tr>
                        <tr>
                            <th>Tên:</th>
                            <td><strong>{{ $role->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Slug:</th>
                            <td><code class="text-primary">{{ $role->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Mô tả:</th>
                            <td>{{ $role->description ?? 'Không có mô tả' }}</td>
                        </tr>
                        <tr>
                            <th>Ngày tạo:</th>
                            <td>{{ $role->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối:</th>
                            <td>{{ $role->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-people me-2"></i>
                        Users có Role này ({{ $role->users->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($role->users->count() > 0)
                        <ul class="list-group">
                            @foreach($role->users as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted text-center">Chưa có user nào có role này</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="bi bi-key me-2"></i>
                Permissions ({{ $role->permissions->count() }})
            </h5>
        </div>
        <div class="card-body">
            @if($role->permissions->count() > 0)
                <div class="row">
                    @foreach($role->permissions as $permission)
                        <div class="col-md-4 mb-3">
                            <div class="card border">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $permission->name }}</h6>
                                    <code class="text-primary">{{ $permission->slug }}</code>
                                    @if($permission->description)
                                        <p class="card-text mt-2">
                                            <small class="text-muted">{{ $permission->description }}</small>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted text-center">Role này chưa có permission nào</p>
            @endif
        </div>
    </div>
</div>
@endcan
@cannot('view', App\Models\Role::class)
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
                    Tài khoản của bạn không có quyền xem Chi tiết Role.
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

