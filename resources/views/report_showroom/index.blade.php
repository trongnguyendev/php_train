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
                <div class= "col">
                    <table class="table table-hover table-report" style="margin-left:auto; margin-right:auto;">
                        <thead>
                            <tr>
                                <th>SHOWROOM</th>
                                @foreach ($showrooms as $showroom)
                                    <th class="text-center">{{ $showroom->name }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($metrics as $label => $field)
                            <tr>
                                <td class="fw-bold">{{ $label }}</td>

                                @foreach ($showrooms as $showroom)
                                    <td class="text-center">
                                        {{ data_get($data, $showroom->id.'.'.$field, 0) }}
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>  
                <div class= "col">
                    <table class="table table-hover table-report" style="margin-left:auto; margin-right:auto;">
                        <thead>
                            <tr>
                                <th>SHOWROOM</th>
                                @foreach ($showrooms as $showroom)
                                    <th class="text-center">{{ $showroom->name }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($metrics as $label => $field)
                            <tr>
                                <td class="fw-bold">{{ $label }}</td>

                                @foreach ($showrooms as $showroom)
                                    <td class="text-center">
                                        {{ data_get($data_last, $showroom->id.'.'.$field, 0) }}
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        
</div>
@endsection
