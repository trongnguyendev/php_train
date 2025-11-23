@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-pencil text-warning"></i> Chỉnh sửa Loại Showroom</h1>

    <form action="{{ route('product_categories.update', $productCategory) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên loại showroom</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $productCategory->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-warning">Cập nhật</button>
        <a href="{{ route('product_categories.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
