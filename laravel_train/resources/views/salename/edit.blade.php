@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h3">
                <i class="bi bi-pencil text-warning"></i> Chỉnh sửa Sale
            </h1>
            <a href="{{ route('salename.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('salename.update', $salename) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Tên Sale</label>
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $salename->name) }}" placeholder="Nhập tên Sale">

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save"></i> Cập nhật
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
