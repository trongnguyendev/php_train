@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <form method="GET" action="">
        <label style="font-weight: bold;">Chọn Ngày:</label>
        <input type="date" id="date" name="date" value="{{ $date ?? '' }}">
        <button type="submit" class="btn btn-primary btn-sm">Lọc</button>
    </form>
  

<div class="row">
    <div class="col-md-6">
        <div class="card">
          
            <div class="card-body">
                
                <table class="table table-hover">
                        <thead>
                            <th></th>
                            @foreach($showrooms as $showroom)
                                <th>{{ $showroom->name }}</th>
                            @endforeach
                        </thead>
                        <tbody>
                            <tr>
                                <th style = "font-weight: bold;"> SL KHÁCH HÀNG ĐẾN SR</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $stats = $showroomStats->firstWhere('showroom_id', $showroom->id);
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $stats ? $stats->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>
                            <tr>
                                <th style = "font-weight: bold;"> SL KHÁCH HÀNG MỚI</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $khNewStats = $khNew->firstWhere('showroom_id', $showroom->id);
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $khNewStats ? $khNewStats->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
