@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sửa Danh mục</h1>

    <form action="{{ route('category.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên Danh mục</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('category.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
