@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h1 class="h3"><i class="bi bi-headset text-primary"></i> Chi tiết kênh hỗ trợ</h1>
        <a href="{{ route('support-channels.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Tên kênh hỗ trợ:</h5>
            <div class="mb-3">
                <span class="fw-bold">{{ $support_channel->name }}</span>
            </div>
            <a href="{{ route('support-channels.edit', $support_channel) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Sửa
            </a>
        </div>
    </div>
</div>
@endsection
