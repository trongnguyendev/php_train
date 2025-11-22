@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-pencil text-warning"></i> Chỉnh sửa Phân loại khách hàng</h1>

    <form action="{{ route('customer_sources.update', $customerSource) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Phân loại khách hàng</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $customerSource->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-warning">Cập nhật</button>
        <a href="{{ route('customer_sources.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
