@extends('layouts.app')

@section('content')
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center">
                <!-- Icon -->
                <div class="mb-4">
                    <i class="bi bi-shield-lock text-danger" style="font-size: 5rem; opacity: 0.8;"></i>
                </div>
                
                <!-- Content -->
                <h3 class="fw-bold mb-3">Không có quyền truy cập</h3>
                <p class="text-muted mb-4">
                    Tài khoản của bạn không có quyền thực hiện hành động này.
                    @if(isset($exception) && $exception->getMessage())
                        <br><small class="text-danger">{{ $exception->getMessage() }}</small>
                    @endif
                </p>
                
                <!-- Action -->
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>
                        Quay lại
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i class="bi bi-house me-2"></i>
                        Về trang chủ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

