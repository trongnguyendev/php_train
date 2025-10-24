@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-plus-circle text-primary"></i> Thêm Phân loại khách hàng</h1>
    <form action="{{ route('customer_sources.store') }}" method="POST">
        @csrf
        <div class="col-md-12 mb-3">
            <label for="name" class="form-label">Phân loại khách hàng</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" placeholder="Ví dụ: Khách hàng cũ">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('customer_sources.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
