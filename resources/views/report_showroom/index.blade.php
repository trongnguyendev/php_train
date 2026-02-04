@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <form method="GET" action="" style="display:flex;gap:12px;align-items:end;flex-wrap:wrap">

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

</form>



            <div class = "row">
                    <div class="col">
                        <div class="fw-bold text-center my-2"></div>
                        <table class="table table-hover table-report" style="margin-left:auto; margin-right:auto;">
                            <thead>
                                <tr>
                                    <th>Showroom</th>
                                    @foreach ($showrooms as $showroom)
                                        <th class="text-center">{{ $showroom->name }}</th>
                                    @endforeach
                                    <th class="text-center">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($metrics as $label => $key)
                                <tr>
                                    <td class="fw-bold">{{ $label }}</td>
                                    @php $sum = 0; @endphp
                                    @foreach ($showrooms as $showroom)
                                        <td class="text-center">{{ $totals_current[$showroom->id][$key] ?? 0 }}</td>
                                        @php $sum += $totals_current[$showroom->id][$key] ?? 0; @endphp
                                    @endforeach
                                    <td class="text-center fw-bold">{{ $sum }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                    <div class="col">
                         <div class="fw-bold text-center my-2"></div>
                        <table class="table table-hover table-report" style="margin-left:auto; margin-right:auto;">
                            <thead>
                                <tr>
                                    <th>Showroom</th>
                                    @foreach ($showrooms as $showroom)
                                        <th class="text-center">{{ $showroom->name }}</th>
                                    @endforeach
                                    <th class="text-center">Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($metrics as $label => $key)
                                <tr>
                                    <td class="fw-bold">{{ $label }}</td>
                                    @php $sum = 0; @endphp
                                    @foreach ($showrooms as $showroom)
                                        <td class="text-center">{{ $totals_prev[$showroom->id][$key] ?? 0 }}</td>
                                        @php $sum += $totals_prev[$showroom->id][$key] ?? 0; @endphp
                                    @endforeach
                                    <td class="text-center fw-bold">{{ $sum }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                       
                    </div>
                
            </div>
        
</div>
@endsection
