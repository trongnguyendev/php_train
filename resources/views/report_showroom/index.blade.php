@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <form method="GET" action="">
        <label style="font-weight: bold;">Tháng Hiện Tại:</label>
        <input type="month" id="month" name="month" value="{{ $month ?? '' }}">

        <label style="font-weight: bold;">Tháng Trước Đó:</label>
        <input type="month" id="last-month" name="last-month" value="{{ $last_month ?? '' }}">

        <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
    </form>
  


            <div class = "row">
                    <div class="col">
                        <div class="fw-bold text-center my-2">BẢNG THÁNG {{ $month }}</div>
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
                         <div class="fw-bold text-center my-2">BẢNG THÁNG {{ $last_month }}</div>
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
