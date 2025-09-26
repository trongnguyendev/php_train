@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Chi tiết Danh mục</h1>

    <div class="card">
        <div class="card-body">
            <h4>{{ $category->name }}</h4>
            <p><strong>ID:</strong> {{ $category->id }}</p>
            <p><strong>Ngày tạo:</strong> {{ $category->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cập nhật lần cuối:</strong> {{ $category->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <a href="{{ route('category.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
    <a href="{{ route('category.edit', $category) }}" class="btn btn-warning mt-3">Sửa</a>
</div>
@endsection
