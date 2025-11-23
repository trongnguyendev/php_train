@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-building text-info"></i> Chi tiết Loại Showroom</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $typeShowroom->id }}</p>
            <p><strong>Tên loại showroom:</strong> {{ $typeShowroom->name }}</p>
            <p><strong>Ngày tạo:</strong> {{ $typeShowroom->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cập nhật lần cuối:</strong> {{ $typeShowroom->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    <a href="{{ route('type_showroom.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
</div>
@endsection
