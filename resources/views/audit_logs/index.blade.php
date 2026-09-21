@php
    $fieldLabels = [
        'customer_id'                  => 'ID Khách hàng',
        'order_code'                   => 'Mã đơn hàng',
        'first_interaction_date'       => 'Ngày tương tác đầu',
        'name'                         => 'Tên khách hàng',
        'province_id'                  => 'Tỉnh/Thành phố',
        'address'                      => 'Địa chỉ',
        'zalo'                         => 'Zalo',
        'customer_type_id'             => 'Loại khách hàng',
        'showroom_id'                  => 'Showroom',
        'product_categories_id'        => 'Danh mục sản phẩm',
        'first_customer_status_id'     => 'Tình trạng ban đầu',
        'note'                         => 'Ghi chú',
        'sale_information_id'          => 'Sale nhận KH',
        'sale_support_id'              => 'Sale hỗ trợ',
        'current_customer_status_id'   => 'Tình trạng hiện tại',
        'order_value'                  => 'Giá trị đơn',
        'support_channel_id'           => 'Kênh hỗ trợ',
        'source_id'                    => 'Nguồn',
        'customer_discussion_details'  => 'Chi tiết trao đổi',
        'tmdt'                         => 'Chuyển TMDT',
        'lead_type'                    => 'Loại Lead',
        'old_lead_type'                => 'Loại Lead cũ',
        'created_by'                   => 'Người tạo',
    ];

    // Khởi tạo $maps an toàn nếu Controller chưa truyền sang
    $maps = $maps ?? [];

    // Số bộ lọc đang bật
    $activeFilters = collect(['user_id', 'event', 'date_from', 'date_to', 'search'])
        ->filter(fn ($k) => request()->filled($k))
        ->count();

    $formatAuditValue = function ($field, $value) use ($maps) {
        if (is_null($value) || $value === '') return '<span class="audit-empty-val">—</span>';
        if (is_bool($value)) return $value ? 'Có' : 'Không';

        // Map ID sang Tên tương ứng
        if ($field === 'province_id') {
            return e($maps['province_id'][$value] ?? $value);
        }
        if ($field === 'customer_type_id') {
            return e($maps['customer_type_id'][$value] ?? $value);
        }
        if ($field === 'source_id') {
            return e($maps['source_id'][$value] ?? $value);
        }
        if ($field === 'product_categories_id') {
            return e($maps['product_categories_id'][$value] ?? $value);
        }
        if ($field === 'showroom_id') {
            return e($maps['showroom_id'][$value] ?? $value);
        }
        if (in_array($field, ['first_customer_status_id', 'current_customer_status_id'])) {
            return e($maps['customer_status_id'][$value] ?? $value);
        }
        if (in_array($field, ['sale_information_id', 'sale_support_id', 'created_by'])) {
            return e($maps['users'][$value] ?? $value);
        }
        if ($field === 'support_channel_id') {
            return e($maps['support_channel_id'][$value] ?? $value);
        }
        if ($field === 'customer_id') {
            return e($maps['customer_id'][$value] ?? $value);
        }

        // Định dạng tiền tệ
        if ($field === 'order_value' && is_numeric($value)) {
            return number_format($value, 0, ',', '.') . ' đ';
        }

        if (is_array($value)) {
            return e(implode(', ', array_map(function ($item) {
                if (is_array($item)) return json_encode($item, JSON_UNESCAPED_UNICODE);
                return (string) $item;
            }, $value)));
        }

        return e((string) $value);
    };
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* =====================================================
       DESIGN TOKENS
       ===================================================== */
    .audit-scope {
        --au-font: 'Be Vietnam Pro', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;

        --au-ink: #0f172a;
        --au-text: #334155;
        --au-muted: #64748b;
        --au-soft: #94a3b8;
        --au-line: #e8edf3;
        --au-line-strong: #d5dde8;
        --au-bg: #f6f8fb;
        --au-surface: #ffffff;

        --au-accent: #4f46e5;
        --au-accent-hover: #4338ca;
        --au-accent-soft: #eef2ff;
        --au-ring: rgba(79, 70, 229, .18);

        --au-del-bg: #fee2e2;
        --au-del-text: #b91c1c;
        --au-add-bg: #dcfce7;
        --au-add-text: #15803d;

        --au-radius-lg: 16px;
        --au-radius-md: 10px;
        --au-radius-sm: 8px;

        --au-shadow-sm: 0 1px 2px rgba(15, 23, 42, .05);
        --au-shadow-md: 0 1px 3px rgba(15, 23, 42, .06), 0 12px 32px -8px rgba(15, 23, 42, .10);

        --au-user-w: 250px;
        --au-type-w: 118px;

        font-family: var(--au-font);
        color: var(--au-text);
    }

    .audit-scope *,
    .audit-scope *::before,
    .audit-scope *::after {
        box-sizing: border-box;
    }

    /* =====================================================
       FILTER FORM
       ===================================================== */
    .audit-filter {
        margin-bottom: 20px;
        background: var(--au-surface);
        border: 1px solid var(--au-line);
        border-radius: var(--au-radius-lg);
        box-shadow: var(--au-shadow-sm);
        overflow: hidden;
    }

    .audit-filter-head {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 20px;
        border-bottom: 1px solid var(--au-line);
        background: linear-gradient(180deg, #fcfdff 0%, #f8fafc 100%);
    }

    .audit-filter-head .audit-filter-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: var(--au-accent-soft);
        color: var(--au-accent);
        font-size: .9rem;
    }

    .audit-filter-title {
        margin: 0;
        font-size: .9rem;
        font-weight: 600;
        color: var(--au-ink);
    }

    .audit-filter-badge {
        padding: 2px 9px;
        border-radius: 999px;
        background: var(--au-accent);
        color: #fff;
        font-size: .7rem;
        font-weight: 600;
        line-height: 1.5;
    }

    .audit-filter-body {
        padding: 18px 20px 20px;
    }

    .audit-filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px 16px;
        align-items: end;
    }

    .audit-field-wide {
        grid-column: span 2;
    }

    .audit-field-label {
        display: block;
        margin-bottom: 6px;
        font-size: .75rem;
        font-weight: 600;
        color: var(--au-muted);
    }

    .audit-field-control {
        position: relative;
    }

    .audit-field-control > i {
        position: absolute;
        top: 50%;
        left: 13px;
        transform: translateY(-50%);
        font-size: .9rem;
        color: var(--au-soft);
        pointer-events: none;
        transition: color .15s ease;
    }

    .audit-scope .audit-input {
        display: block;
        width: 100%;
        height: 42px;
        padding: 0 14px 0 38px;
        font-family: var(--au-font);
        font-size: .85rem;
        color: var(--au-ink);
        background-color: var(--au-bg);
        border: 1px solid transparent;
        border-radius: var(--au-radius-md);
        outline: none;
        transition: background-color .15s ease, border-color .15s ease, box-shadow .15s ease;
    }

    .audit-scope select.audit-input {
        padding-right: 34px;
        cursor: pointer;
    }

    .audit-scope .audit-input::placeholder {
        color: var(--au-soft);
    }

    .audit-scope .audit-input:hover {
        border-color: var(--au-line-strong);
    }

    .audit-scope .audit-input:focus {
        background-color: var(--au-surface);
        border-color: var(--au-accent);
        box-shadow: 0 0 0 4px var(--au-ring);
    }

    .audit-field-control:focus-within > i {
        color: var(--au-accent);
    }

    .audit-filter-actions {
        display: flex;
        gap: 8px;
    }

    .audit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        height: 42px;
        padding: 0 18px;
        font-family: var(--au-font);
        font-size: .85rem;
        font-weight: 600;
        line-height: 1;
        text-decoration: none;
        white-space: nowrap;
        border: 1px solid transparent;
        border-radius: var(--au-radius-md);
        cursor: pointer;
        transition: background-color .15s ease, border-color .15s ease, box-shadow .15s ease, transform .1s ease;
    }

    .audit-btn:active {
        transform: translateY(1px);
    }

    .audit-btn:focus-visible {
        outline: none;
        box-shadow: 0 0 0 4px var(--au-ring);
    }

    .audit-btn-primary {
        color: #fff;
        background: var(--au-accent);
        box-shadow: 0 1px 2px rgba(79, 70, 229, .35);
    }

    .audit-btn-primary:hover {
        color: #fff;
        background: var(--au-accent-hover);
    }

    .audit-btn-ghost {
        color: var(--au-text);
        background: var(--au-surface);
        border-color: var(--au-line-strong);
    }

    .audit-btn-ghost:hover {
        color: var(--au-ink);
        background: var(--au-bg);
    }

    /* =====================================================
       CARD
       ===================================================== */
    .audit-card {
        background: var(--au-surface);
        border: 1px solid var(--au-line);
        border-radius: var(--au-radius-lg);
        box-shadow: var(--au-shadow-md);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .audit-card-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 16px 22px;
        border-bottom: 1px solid var(--au-line);
    }

    .audit-card-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: var(--au-ink);
    }

    .audit-title-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        font-size: 1.05rem;
        box-shadow: 0 4px 10px -2px rgba(79, 70, 229, .45);
    }

    .audit-card-sub {
        display: block;
        margin-top: 1px;
        font-size: .75rem;
        font-weight: 400;
        color: var(--au-muted);
    }

    .audit-header-right {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px 18px;
    }

    .audit-count {
        padding: 5px 12px;
        border-radius: 999px;
        background: var(--au-accent-soft);
        color: var(--au-accent);
        font-size: .76rem;
        font-weight: 600;
    }

    .audit-legend {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: .76rem;
        color: var(--au-muted);
    }

    .audit-legend-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .audit-legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 3px;
    }

    .audit-legend-dot.is-old { background: var(--au-del-bg); box-shadow: inset 0 0 0 1px #fca5a5; }
    .audit-legend-dot.is-new { background: var(--au-add-bg); box-shadow: inset 0 0 0 1px #86efac; }

    /* =====================================================
       TABLE
       ===================================================== */
    .audit-table-wrapper {
        max-height: 72vh;
        overflow: auto;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }

    .audit-table-wrapper::-webkit-scrollbar { width: 10px; height: 10px; }
    .audit-table-wrapper::-webkit-scrollbar-track { background: transparent; }
    .audit-table-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border: 2px solid var(--au-surface);
        border-radius: 999px;
    }
    .audit-table-wrapper::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

    .audit-scope .audit-table {
        width: 100%;
        margin: 0;
        font-size: .83rem;
        color: var(--au-text);
        border-collapse: separate;
        border-spacing: 0;
    }

    .audit-scope .audit-table th,
    .audit-scope .audit-table td {
        vertical-align: middle;
        background-clip: padding-box;
    }

    /* Header */
    .audit-scope .audit-table thead th {
        position: sticky;
        top: 0;
        z-index: 3;
        padding: 13px 16px;
        background: #f8fafc;
        border-bottom: 1px solid var(--au-line-strong);
        font-size: .74rem;
        font-weight: 600;
        color: var(--au-muted);
        text-align: left;
        white-space: nowrap;
    }

    /* Cột cố định */
    .audit-user-col,
    .audit-type-col {
        position: sticky;
        z-index: 2;
    }

    .audit-scope .audit-table thead th.audit-user-col,
    .audit-scope .audit-table thead th.audit-type-col {
        z-index: 5;
    }

    .audit-user-col {
        left: 0;
        width: var(--au-user-w);
        min-width: var(--au-user-w);
        max-width: var(--au-user-w);
        padding: 14px 18px;
        background: #fbfcfe;
        border-right: 1px solid var(--au-line);
        border-bottom: 1px solid var(--au-line-strong);
    }

    .audit-scope .audit-table thead th.audit-user-col { background: #f8fafc; border-bottom: 1px solid var(--au-line-strong); }

    .audit-type-col {
        left: var(--au-user-w);
        width: var(--au-type-w);
        min-width: var(--au-type-w);
        padding: 10px 12px;
        text-align: center;
        background: var(--au-surface);
        border-right: 1px solid var(--au-line);
        box-shadow: 8px 0 12px -8px rgba(15, 23, 42, .12);
    }

    .audit-scope .audit-table thead th.audit-type-col { background: #f8fafc; }

    /* Người thực hiện */
    .audit-user {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .audit-avatar {
        flex: 0 0 auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 12px;
        font-size: .9rem;
        font-weight: 700;
    }

    .audit-avatar.c0 { background: #e0e7ff; color: #4338ca; }
    .audit-avatar.c1 { background: #d1fae5; color: #047857; }
    .audit-avatar.c2 { background: #fef3c7; color: #b45309; }
    .audit-avatar.c3 { background: #ffe4e6; color: #be123c; }
    .audit-avatar.c4 { background: #e0f2fe; color: #0369a1; }
    .audit-avatar.c5 { background: #ede9fe; color: #6d28d9; }

    .audit-user-name {
        font-weight: 600;
        color: var(--au-ink);
        line-height: 1.3;
        word-break: break-word;
    }

    .audit-user-time {
        display: flex;
        flex-wrap: wrap;
        gap: 2px 10px;
        margin-top: 3px;
        font-size: .73rem;
        color: var(--au-muted);
    }

    .audit-user-time i {
        margin-right: 3px;
        color: var(--au-soft);
    }

    .audit-user-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 7px;
    }

    .audit-user-id {
        font-size: .7rem;
        color: var(--au-soft);
    }

    /* Event badge */
    .audit-event {
        padding: 2px 9px;
        border-radius: 999px;
        background: #f1f5f9;
        color: #475569;
        font-size: .68rem;
        font-weight: 600;
    }

    .audit-event.is-created { background: #dcfce7; color: #166534; }
    .audit-event.is-updated { background: #fef3c7; color: #92400e; }
    .audit-event.is-deleted { background: #fee2e2; color: #991b1b; }

    /* Cell */
    .audit-scope .audit-table tbody td.audit-cell {
        min-width: 140px;
        max-width: 280px;
        padding: 12px 16px;
        background: var(--au-surface);
        white-space: normal;
        word-break: break-word;
        line-height: 1.45;
        color: var(--au-muted);
    }

    .audit-row-old td.audit-cell { padding-bottom: 6px; }
    .audit-row-new td.audit-cell { padding-top: 6px; color: var(--au-text); }

    /* Đường kẻ phân cách giữa các log */
    .audit-group > tr:last-child > td {
        border-bottom: 1px solid var(--au-line-strong);
    }

    /* Hover theo nhóm */
    .audit-group:hover td.audit-cell,
    .audit-group:hover td.audit-type-col {
        background-color: #fafbff;
    }

    /* Giá trị (chip) */
    .audit-val {
        display: inline-block;
        max-width: 100%;
        padding: 2px 0;
    }

    .audit-changed-old .audit-val,
    .audit-changed-new .audit-val {
        padding: 3px 10px;
        border-radius: var(--au-radius-sm);
    }

    .audit-changed-old .audit-val {
        background: var(--au-del-bg);
        color: var(--au-del-text);
    
        text-decoration-color: rgba(185, 28, 28, .5);
    }

    .audit-changed-new .audit-val {
        background: var(--au-add-bg);
        color: var(--au-add-text);
        font-weight: 600;
    }

    .audit-changed-old .audit-empty-val,
    .audit-changed-new .audit-empty-val {
        text-decoration: none;
    }

    .audit-empty-val {
        color: #cbd5e1;
    }

    /* Badge trạng thái */
    .audit-badge-old,
    .audit-badge-new {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 11px;
        border-radius: 999px;
        font-size: .72rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .audit-badge-old::before,
    .audit-badge-new::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .audit-badge-old { background: #f1f5f9; color: #64748b; }
    .audit-badge-new { background: var(--au-accent-soft); color: var(--au-accent); }

    /* Trạng thái rỗng */
    .audit-empty {
        padding: 64px 20px;
        text-align: center;
        color: var(--au-muted);
    }

    .audit-empty-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        margin-bottom: 14px;
        border-radius: 20px;
        background: var(--au-bg);
        color: var(--au-soft);
        font-size: 1.8rem;
    }

    .audit-empty-title {
        margin: 0 0 4px;
        font-size: .95rem;
        font-weight: 600;
        color: var(--au-ink);
    }

    .audit-empty-text {
        margin: 0;
        font-size: .82rem;
    }

    /* =====================================================
       RESPONSIVE / A11Y
       ===================================================== */
    @media (max-width: 991.98px) {
        .audit-field-wide { grid-column: auto; }
        .audit-legend { display: none; }
    }

    @media (max-width: 575.98px) {
        .audit-scope { --au-user-w: 200px; --au-type-w: 100px; }
        .audit-card-header,
        .audit-filter-head,
        .audit-filter-body { padding-left: 14px; padding-right: 14px; }
        .audit-filter-actions .audit-btn { flex: 1; }
    }

    @media (prefers-reduced-motion: reduce) {
        .audit-scope * { transition: none !important; }
    }
</style>

<div class="audit-scope">

    {{-- ================= FORM LỌC ================= --}}
    <form method="GET" action="{{ url()->current() }}" class="audit-filter">
        <div class="audit-filter-head">
            <span class="audit-filter-icon"><i class="bi bi-funnel"></i></span>
            <h6 class="audit-filter-title">Bộ lọc</h6>
            @if($activeFilters > 0)
                <span class="audit-filter-badge">{{ $activeFilters }} đang áp dụng</span>
            @endif
        </div>

        <div class="audit-filter-body">
            <div class="audit-filter-grid">
                <!-- Người thực hiện -->
                <div>
                    <label class="audit-field-label" for="af-user">Người thực hiện</label>
                    <div class="audit-field-control">
                        <i class="bi bi-person"></i>
                        <select id="af-user" name="user_id" class="audit-input form-select">
                            <option value="">Tất cả người dùng</option>
                            @foreach($users as $id => $name)
                                <option value="{{ $id }}" {{ request('user_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Hành động -->
                <div>
                    <label class="audit-field-label" for="af-event">Hành động</label>
                    <div class="audit-field-control">
                        <i class="bi bi-lightning-charge"></i>
                        <select id="af-event" name="event" class="audit-input form-select">
                            <option value="">Tất cả hành động</option>
                            <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Thêm mới (Created)</option>
                            <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Cập nhật (Updated)</option>
                            <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Xóa (Deleted)</option>
                        </select>
                    </div>
                </div>

                <!-- Từ ngày -->
                <div>
                    <label class="audit-field-label" for="af-from">Từ ngày</label>
                    <div class="audit-field-control">
                        <i class="bi bi-calendar-event"></i>
                        <input id="af-from" type="date" name="date_from" class="audit-input form-control" value="{{ request('date_from') }}">
                    </div>
                </div>

                <!-- Đến ngày -->
                <div>
                    <label class="audit-field-label" for="af-to">Đến ngày</label>
                    <div class="audit-field-control">
                        <i class="bi bi-calendar-check"></i>
                        <input id="af-to" type="date" name="date_to" class="audit-input form-control" value="{{ request('date_to') }}">
                    </div>
                </div>

                <!-- Tìm kiếm từ khóa -->
                <div class="audit-field-wide">
                    <label class="audit-field-label" for="af-search">Từ khóa</label>
                    <div class="audit-field-control">
                        <i class="bi bi-search"></i>
                        <input id="af-search" type="text" name="search" class="audit-input form-control" value="{{ request('search') }}" placeholder="Tìm trong giá trị thay đổi...">
                    </div>
                </div>

                <!-- Nút bấm -->
                <div class="audit-filter-actions">
                    <button type="submit" class="audit-btn audit-btn-primary">
                        <i class="bi bi-funnel-fill"></i> Lọc
                    </button>
                    <a href="{{ url()->current() }}" class="audit-btn audit-btn-ghost">
                        <i class="bi bi-x-lg"></i> Xóa lọc
                    </a>
                </div>
            </div>
        </div>
    </form>

    {{-- ================= LỊCH SỬ ================= --}}
    <div class="audit-card">
        <div class="audit-card-header">
            <h6 class="audit-card-title">
                <span class="audit-title-icon"><i class="bi bi-clock-history"></i></span>
                <span>
                    Lịch sử chỉnh sửa chi tiết
                    <span class="audit-card-sub">So sánh giá trị trước và sau mỗi lần thay đổi</span>
                </span>
            </h6>

            @if(!empty($auditLogs) && count($auditLogs) > 0)
                <div class="audit-header-right">
                    <div class="audit-legend">
                        <span class="audit-legend-item"><span class="audit-legend-dot is-old"></span>Giá trị cũ</span>
                        <span class="audit-legend-item"><span class="audit-legend-dot is-new"></span>Giá trị mới</span>
                    </div>
                    <span class="audit-count">{{ count($auditLogs) }} lần chỉnh sửa</span>
                </div>
            @endif
        </div>

        <div class="p-0">
            @if(!empty($auditLogs) && count($auditLogs) > 0)
                <div class="audit-table-wrapper">
                    <table class="audit-table">
                        <thead>
                            <tr>
                                <th class="audit-user-col">Người thực hiện / Thời gian</th>
                                <th class="audit-type-col">Trạng thái</th>
                                @foreach($fieldLabels as $fieldKey => $fieldLabel)
                                    <th>{{ $fieldLabel }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        @foreach($auditLogs as $log)
                            @php
                                $oldValues = $log->old_values ?? [];
                                $newValues = $log->new_values ?? [];
                                $userName  = $log->user->name ?? 'Hệ thống';
                                $initial   = mb_strtoupper(mb_substr($userName, 0, 1));
                                $avatarCls = 'c' . (((int) ($log->user_id ?? 0)) % 6);
                            @endphp

                            <tbody class="audit-group">
                                {{-- DÒNG 1: BAN ĐẦU (GIÁ TRỊ CŨ) --}}
                                <tr class="audit-row-old">
                                    <td rowspan="2" class="audit-user-col">
                                        <div class="audit-user">
                                            <span class="audit-avatar {{ $avatarCls }}">{{ $initial }}</span>
                                            <div>
                                                <div class="audit-user-name">{{ $userName }}</div>
                                                <div class="audit-user-time">
                                                    <span><i class="bi bi-calendar3"></i>{{ $log->created_at->format('d/m/Y') }}</span>
                                                    <span><i class="bi bi-clock"></i>{{ $log->created_at->format('H:i:s') }}</span>
                                                </div>
                                                <div class="audit-user-meta">
                                                    <span class="audit-user-id">ID #{{ $log->user_id ?? 'N/A' }}</span>
                                                    @if(!empty($log->event))
                                                        <span class="audit-event is-{{ $log->event }}">{{ ucfirst($log->event) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="audit-type-col">
                                        <span class="audit-badge-old">Ban đầu</span>
                                    </td>

                                    @foreach($fieldLabels as $fieldKey => $fieldLabel)
                                        @php
                                            $oldVal = $oldValues[$fieldKey] ?? null;
                                            $newVal = $newValues[$fieldKey] ?? null;

                                            $isChanged = array_key_exists($fieldKey, $oldValues) || array_key_exists($fieldKey, $newValues);
                                            if ($isChanged && $oldVal === $newVal) {
                                                $isChanged = false;
                                            }
                                        @endphp
                                        <td class="audit-cell {{ $isChanged ? 'audit-changed-old' : '' }}">
                                            <span class="audit-val">{!! $formatAuditValue($fieldKey, $oldVal) !!}</span>
                                        </td>
                                    @endforeach
                                </tr>

                                {{-- DÒNG 2: CHỈNH SỬA (GIÁ TRỊ MỚI) --}}
                                <tr class="audit-row-new">
                                    <td class="audit-type-col">
                                        <span class="audit-badge-new">Chỉnh sửa</span>
                                    </td>

                                    @foreach($fieldLabels as $fieldKey => $fieldLabel)
                                        @php
                                            $oldVal = $oldValues[$fieldKey] ?? null;
                                            $newVal = $newValues[$fieldKey] ?? null;

                                            $isChanged = array_key_exists($fieldKey, $oldValues) || array_key_exists($fieldKey, $newValues);
                                            if ($isChanged && $oldVal === $newVal) {
                                                $isChanged = false;
                                            }
                                        @endphp
                                        <td class="audit-cell {{ $isChanged ? 'audit-changed-new' : '' }}">
                                            <span class="audit-val">{!! $formatAuditValue($fieldKey, $newVal) !!}</span>
                                        </td>
                                    @endforeach
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            @else
                <div class="audit-empty">
                    <span class="audit-empty-icon"><i class="bi bi-clock-history"></i></span>
                    <p class="audit-empty-title">Chưa có lịch sử chỉnh sửa</p>
                    <p class="audit-empty-text">Các thay đổi sẽ xuất hiện ở đây sau lần cập nhật đầu tiên.</p>
                </div>
            @endif
        </div>
    </div>

</div>