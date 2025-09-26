@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 mb-4"><i class="bi bi-flag text-info"></i> Chi tiết Trạng thái</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $status->id }}</p>
            <p><strong>Tên Trạng thái:</strong> {{ $status->name }}</p>
            <p><strong>Ngày tạo:</strong> {{ $status->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Cập nhật lần cuối:</strong> {{ $status->updated_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    <a href="{{ route('status.index') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Quay lại
    </a>
</div>
@endsection
