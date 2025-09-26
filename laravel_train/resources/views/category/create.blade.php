@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thêm Danh mục</h1>

    <form action="{{ route('category.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên Danh mục</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('category.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
