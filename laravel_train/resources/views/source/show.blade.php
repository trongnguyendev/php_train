@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-link-45deg text-info"></i> Chi tiết Nguồn khách</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $source->id }}</p>
            <p><strong>Tên Nguồn:</strong> {{ $source->name }}</p>
            <p><strong>Ngày tạo:</strong> {{ $source->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cập nhật lần cuối:</strong> {{ $source->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    <a href="{{ route('source.index') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Quay lại
    </a>
</div>
@endsection
