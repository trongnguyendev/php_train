@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Báo cáo khách hàng tháng {{ $month }}/{{ $year }}</h1>

    <form method="GET" action="{{ route('customers.report') }}" class="mb-3">
        <label for="month">Tháng:</label>
        <input type="number" name="month" id="month" min="1" max="12" value="{{ $month }}">
        <label for="year">Năm:</label>
        <input type="number" name="year" id="year" value="{{ $year }}">
        <button type="submit" class="btn btn-primary">Xem</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sale</th>
                @foreach($days as $day)
                    <th>{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($report as $sale => $rows)
                <tr>
                    <td>{{ $sale }}</td>
                    @foreach($days as $day)
                        <td>
                            @if(isset($rows[$day]))
                                @foreach($rows[$day] as $status => $count)
                                    <div>{{ $status }}: <b>{{ $count }}</b></div>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
