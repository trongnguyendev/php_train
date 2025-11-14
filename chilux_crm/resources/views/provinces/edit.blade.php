@extends('layouts.app')

@section('content')
@can('update', App\Models\Province::class)
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-pencil text-warning"></i> Chỉnh sửa Tỉnh</h1>

    <form action="{{ route('provinces.update', $province) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên loại showroom</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $province->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-warning">Cập nhật</button>
        <a href="{{ route('provinces.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endcan
@cannot('update', App\Models\Province::class)
<div class="container-fluid">
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle"></i> Bạn không có quyền chỉnh sửa Tỉnh
    </div>
</div>
@endcannot
@endsection
