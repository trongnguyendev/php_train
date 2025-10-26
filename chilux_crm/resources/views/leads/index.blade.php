@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}" class="text-decoration-none">
            <i class="bi bi-house-door"></i> Trang chủ
        </a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
        <i class="bi bi-people"></i> Danh sách Lead
    </li>
@endsection

@section('content')

<!-- Main Content Card -->
<div class="card">
    <div class="card-header bg-white border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">
                    DANH SÁCH LEAD
                </h5>
            </div>
            <a href="{{ route('leads.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Thêm Lead mới
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card-body border-bottom bg-light">
        <form action="{{ route('leads.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="type_phone" class="form-label">
                    <i class="bi bi-telephone me-1"></i>Số điện thoại
                </label>
                <input 
                    type="text" 
                    name="type_phone" 
                    id="type_phone"
                    class="form-control" 
                    placeholder="Nhập số điện thoại..." 
                    value="{{ request('type_phone') }}"
                >
            </div>
            
            <div class="col-md-3">
                <label for="lead_type" class="form-label">
                    <i class="bi bi-tag me-1"></i>Loại Lead
                </label>
                <select name="lead_type" id="lead_type" class="form-select">
                    <option value="">-- Tất cả loại --</option>
                    <option value="1" {{ request('lead_type') == '1' ? 'selected' : '' }}>Trực tiếp</option>
                    <option value="2" {{ request('lead_type') == '2' ? 'selected' : '' }}>Online</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="first_arrival_date" class="form-label">
                    <i class="bi bi-calendar me-1"></i>Ngày đầu tiên
                </label>
                <input 
                    type="date" 
                    name="first_arrival_date" 
                    id="first_arrival_date"
                    class="form-control" 
                    value="{{ request('first_arrival_date') }}"
                >
            </div>

            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>Tìm kiếm
                    </button>
                    <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise me-1"></i>Làm mới
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="card-body p-0">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($leads->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th width="220">Ngày</th>
                            <th width="200">Tên KH</th>
                            <th width="250">Điện thoại</th>
                            <th width="250">Zalo</th>
                            <th width="200">Tỉnh/Thành</th>
                            <th width="200">Loại KH</th>
                            <th width="300">Tình trạng</th>
                            <th width="300">Nguồn KH</th>
                            <th width="300">Showroom</th>
                            <th width="250">Giá trị đơn</th>
                            <th width="300">Sale nhận</th>
                            <th width="200">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#{{ $lead->id }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($lead->first_arrival_date)->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary-light rounded-circle d-flex align-items-center justify-content-center me-2">
                                            <i class="bi bi-person text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $lead->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="tel:{{ $lead->phone }}" class="text-decoration-none">
                                        <i class="bi bi-chat-dots me-1"></i>{{ $lead->zalo }}
                                    </a>
                                </td>
                                <td>
                                    <a href="tel:{{ $lead->phone }}" class="text-decoration-none">
                                        <i class="bi bi-telephone me-1"></i>{{ $lead->phone }}
                                    </a>
                                </td>
                                <td>
                                    <small>{{ $lead->province->name ?? '-' }}</small>
                                </td>
                                <td>
                                    @if($lead->customerType)
                                        <span class="badge bg-info">{{ $lead->customerType->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lead->is_new_customer)
                                        <span class="badge bg-success">Mới</span>
                                    @else
                                        <span class="badge bg-secondary">Cũ</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lead->customerSource)
                                        <small>{{ $lead->customerSource->name }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lead->showroom)
                                        <small>{{ $lead->showroom->name }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lead->order_value)
                                        <span class="fw-medium text-success">{{ number_format($lead->order_value) }}đ</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lead->saleReceive)
                                        <small>{{ $lead->saleReceive->name }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('leads.show', $lead->id) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="Xem chi tiết">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('leads.edit', $lead->id) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Chỉnh sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Xóa"
                                                onclick="confirmDelete({{ $lead->id }})">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Hidden Delete Form -->
                                    <form id="delete-form-{{ $lead->id }}" 
                                          action="{{ route('leads.destroy', $lead->id) }}" 
                                          method="POST" 
                                          class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h5 class="mt-3 text-muted">Không có lead nào</h5>
                <p class="text-muted">Chưa có lead nào được tạo hoặc không tìm thấy kết quả phù hợp.</p>
                <a href="{{ route('leads.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tạo Lead đầu tiên
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                    Xác nhận xóa Lead
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa Lead này và tất cả dữ liệu chăm sóc liên quan?</p>
                <p class="text-muted small">Hành động này không thể hoàn tác.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa Lead</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(leadId) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    
    confirmBtn.onclick = function() {
        document.getElementById('delete-form-' + leadId).submit();
    };
    
    modal.show();
}

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>
@endpush
