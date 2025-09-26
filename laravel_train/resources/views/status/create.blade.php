@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-plus-circle text-primary"></i> Thêm Trạng thái</h1>
    <form action="{{ route('status.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên Trạng thái</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" placeholder="Nhập tên trạng thái">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Lưu
        </button>
        <a href="{{ route('status.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
