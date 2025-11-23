@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-pencil text-primary"></i>
                        Chỉnh sửa Role
                    </h1>
                    <p class="text-muted">Cập nhật thông tin role</p>
                </div>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('roles.update', $role) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-tag me-1"></i>Tên Role <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $role->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug" class="form-label">
                                <i class="bi bi-link-45deg me-1"></i>Slug <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug', $role->slug) }}" 
                                   required>
                            <small class="form-text text-muted">Ví dụ: admin, manager, staff</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">
                        <i class="bi bi-file-text me-1"></i>Mô tả
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="3">{{ old('description', $role->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-key me-1"></i>Permissions
                    </label>
                    <div class="row">
                        @foreach($permissions as $permission)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           name="permissions[]" 
                                           value="{{ $permission->id }}" 
                                           id="permission_{{ $permission->id }}"
                                           {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                        <strong>{{ $permission->name }}</strong>
                                        <br>
                                        <small class="text-muted"><code>{{ $permission->slug }}</code></small>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Hủy
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i>Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

