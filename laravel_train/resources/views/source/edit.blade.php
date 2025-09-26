@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-pencil text-warning"></i> Chỉnh sửa Nguồn khách</h1>
    <form action="{{ route('source.update', $source) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên Nguồn</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $source->name) }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-warning">
            <i class="bi bi-save"></i> Cập nhật
        </button>
        <a href="{{ route('source.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
