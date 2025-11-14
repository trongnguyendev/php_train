@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-eye text-primary"></i>
                        Chi tiết Permission: {{ $permission->name }}
                    </h1>
                    <p class="text-muted">Thông tin chi tiết về permission và các roles có permission này</p>
                </div>
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Thông tin Permission
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">ID:</th>
                            <td><span class="badge bg-secondary">{{ $permission->id }}</span></td>
                        </tr>
                        <tr>
                            <th>Tên:</th>
                            <td><strong>{{ $permission->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Slug:</th>
                            <td><code class="text-primary">{{ $permission->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Mô tả:</th>
                            <td>{{ $permission->description ?? 'Không có mô tả' }}</td>
                        </tr>
                        <tr>
                            <th>Ngày tạo:</th>
                            <td>{{ $permission->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Cập nhật lần cuối:</th>
                            <td>{{ $permission->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>
                        Roles có Permission này ({{ $permission->roles->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($permission->roles->count() > 0)
                        <ul class="list-group">
                            @foreach($permission->roles as $role)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $role->name }}</strong>
                                        <br>
                                        <small class="text-muted"><code>{{ $role->slug }}</code></small>
                                    </div>
                                    <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted text-center">Chưa có role nào có permission này</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

