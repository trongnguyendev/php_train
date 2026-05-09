@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

 <!-- <form method="GET" action="" style="display:flex;gap:12px;align-items:end;flex-wrap:wrap">

    {{-- Khoảng ngày 1 --}}
    <div>
        <label style="font-weight: bold;">Từ ngày (1)</label>
        <input type="date"
               name="from_date_1"
               value="{{ request('from_date_1') }}"
               class="form-control form-control-sm">
    </div>

    <div>
        <label style="font-weight: bold;">Đến ngày (1)</label>
        <input type="date"
               name="to_date_1"
               value="{{ request('to_date_1') }}"
               class="form-control form-control-sm">
    </div>

    {{-- Khoảng ngày 2 --}}
    <div>
        <label style="font-weight: bold;">Từ ngày (2)</label>
        <input type="date"
               name="from_date_2"
               value="{{ request('from_date_2') }}"
               class="form-control form-control-sm">
    </div>

    <div>
        <label style="font-weight: bold;">Đến ngày (2)</label>
        <input type="date"
               name="to_date_2"
               value="{{ request('to_date_2') }}"
               class="form-control form-control-sm">
    </div>

    <div>
        <button type="submit" class="btn btn-primary btn-sm">
            Lọc
        </button>
    </div>

</form> -->
        <!-- form hiển thị -->
       <div class="row row-cols-1 row-cols-md-5 g-2">
         <div class="col">
            <div class="card h-100 card-outline card-primary">
                <div class="card-header" style="background-color: #022142; border : 5px solid #95b1d0; text-align: center; color: white;"><h3>TIỀM NĂNG - {{ $potentials->count() }}</h3></div>
                <div class="card-body p-2">
                    <ul class="list-group list-group-flush">
                        @foreach($potentials as $item)
                            <li class="list-group-item bg-potential-light">
                                <div class="d-flex flex-column">
                                    <span class="text-bold text-primary">{{ $item->customer_name }}</span>
                                    <small class="text-muted"><i class="fas fa-phone"></i> {{ $item->all_phones }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        

        <div class="col">
            <div class="card h-100 card-outline card-success">
                <div class="card-header" style="background-color: #022142; border : 5px solid #95b1d0; text-align: center; color: white;"><h3>QUAN TÂM - {{ $interested->count() }}</h3></div>
                <div class="card-body p-2">
                    <ul class="list-group list-group-flush">
                        @foreach($interested as $item)
                            <li class="list-group-item bg-interested-light">
                                <div class="d-flex flex-column">
                                    <span class="text-bold text-success">{{ $item->customer_name }}</span>
                                    <small class="text-muted"><i class="fas fa-phone"></i> {{ $item->all_phones }}</small>
                                </div>
                                
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 card-outline card-warning">
                <div class="card-header" style="background-color: #022142; border : 5px solid #95b1d0; text-align: center; color: white;"><h3>THAM KHẢO - {{ $reference->count() }}</h3></div>
                <div class="card-body p-2">
                    <ul class="list-group list-group-flush">
                        @foreach($reference as $item)
                            <li class="list-group-item bg-reference-light">
                                <div class="d-flex flex-column">
                                    <span class="text-bold text-warning">{{ $item->customer_name }}</span>
                                    <small class="text-muted"><i class="fas fa-phone"></i> {{ $item->all_phones }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 card-outline card-secondary">
                <div class="card-header" style="background-color: #022142; border : 5px solid #95b1d0; text-align: center; color: white;"><h3>HẾT NHU CẦU - {{ $out_of_need->count() }}</h3></div>
                <div class="card-body p-2">
                    <ul class="list-group list-group-flush">
                        @foreach($out_of_need as $item)
                            <li class="list-group-item bg-out-of-need-light">
                                <div class="d-flex flex-column">
                                    <span class="text-bold text-secondary">{{ $item->customer_name }}</span>
                                    <small class="text-muted"><i class="fas fa-phone"></i> {{ $item->all_phones }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-100 card-outline card-secondary">
                <div class="card-header" style="background-color: #022142; border : 5px solid #95b1d0; text-align: center; color: white;"><h3>ĐÃ CHỐT - {{ $closed->count() }}</h3></div>
                <div class="card-body p-2">
                    <ul class="list-group list-group-flush">
                        @foreach($closed as $item)
                            <li class="list-group-item bg-closed-light">
                                <div class="d-flex flex-column">
                                    <span class="text-bold" style="color: #9c27b0;">{{ $item->customer_name }}</span>
                                    <small class="text-muted"><i class="fas fa-phone"></i> {{ $item->all_phones }}</small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        </div>
        
</div>

<style>
    /* Tổng chung cho các item */
    .list-group-item {
        border-radius: 8px !important;
        margin-bottom: 10px !important;
        border: 1px solid rgba(202, 53, 53, 0.05) !important;
        transition: 0.3s;
    }
    .list-group-item:hover { filter: brightness(0.95); }

    /* Màu sắc riêng cho từng cột */
    .bg-potential-light  { background-color: #e7f3ff !important; border-left: 4px solid #007bff !important; }
    .bg-interested-light { background-color: #eaffea !important; border-left: 4px solid #28a745 !important; }
    .bg-reference-light  { background-color: #fff4e5 !important; border-left: 4px solid #ff9800 !important; }
    .bg-out-of-need-light{ background-color: #f8f9fa !important; border-left: 4px solid #6c757d !important; }
    .bg-closed-light     { background-color: #f3e5f5 !important; border-left: 4px solid #9c27b0 !important; }
</style>
@endsection
