@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h3">
                <i class="bi bi-plus-circle text-primary"></i> Thêm Tỉnh Mới
            </h1>
            <a href="{{ route('province.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('province.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Tên Tỉnh/Thành phố</label>
                    <input type="text" name="name" id="name" 
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" placeholder="Nhập tên tỉnh thành">

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Lưu
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
