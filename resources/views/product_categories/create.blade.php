@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-plus-circle text-primary"></i> Thêm Danh Mục</h1>
    <form action="{{ route('product_categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên loại showroom</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" placeholder="Ví dụ: Showroom chính, Chi nhánh, Đại lý">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('showrooms.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
