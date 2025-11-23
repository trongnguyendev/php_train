@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-person-gear text-primary"></i>
                        Gán Roles cho User: {{ $user->name }}
                    </h1>
                    <p class="text-muted">Quản lý roles của người dùng</p>
                </div>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.sync-roles', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-shield-check me-1"></i>Chọn Roles
                    </label>
                    <div class="row">
                        @foreach($roles as $role)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="roles[]" 
                                           value="{{ $role->id }}" 
                                           id="role_{{ $role->id }}"
                                           {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                        <strong>{{ $role->name }}</strong>
                                        <br>
                                        <small class="text-muted"><code>{{ $role->slug }}</code></small>
                                        @if($role->description)
                                            <br>
                                            <small class="text-muted">{{ $role->description }}</small>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Hủy
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Lưu Roles
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

