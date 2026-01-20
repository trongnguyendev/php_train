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
                                            $stats = isset($showroomStats) && $showroomStats ? $showroomStats->firstWhere('showroom_id', $showroom->id) : null;
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
                                            $khNewStats = isset($khNew) && $khNew ? $khNew->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $khNewStats ? $khNewStats->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>
                            <tr>
                                <th style = "font-weight: bold;"> SL KHÁCH HÀNG CŨ</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $khOldStats = isset($khOld) && $khOld ? $khOld->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $khOldStats ? $khOldStats->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>

                            <tr>
                                <th style = "font-weight: bold;"> SL KHÁCH  HÀNG TN  MỚI</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $stats = isset($customer_potential_new) && $customer_potential_new ? $customer_potential_new->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $stats ? $stats->total_customers : 0 }}
                                        </th>
                                    
                                    @endforeach
                            </tr>

                            <tr>
                                <th style = "font-weight: bold;"> SL KHÁCH  HÀNG TN  CŨ</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $stats = isset($customer_potential_old) && $customer_potential_old ? $customer_potential_old->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $stats ? $stats->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>

                             <tr>
                                <th style = "font-weight: bold;"> SL KHÁCH HÀNG TN</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $total = isset($total_customer_potential) && $total_customer_potential ? $total_customer_potential->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $total ? $total->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>

                            <tr>
                                <th style = "font-weight: bold;"> SL KH QUAN TÂM</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $total = isset($customer_care) && $customer_care ? $customer_care->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $total ? $total->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>

                            <tr>
                                <th style = "font-weight: bold;"> SL KH THAM KHẢO</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $total = isset($customer_reference) && $customer_reference ? $customer_reference->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $total ? $total->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>
                            <!-- hết nhu cầu -->
                            <tr>
                                <th style = "font-weight: bold;"> SL KHÁCH HÀNG HẾT NHU CẦU</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $total = isset($customer_outOfNeed) && $customer_outOfNeed ? $customer_outOfNeed->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $total ? $total->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>

                            <!-- khách cũ chốt liền -->

                             <tr>
                                <th style = "font-weight: bold;"> SL KHÁCH HÀNG CŨ CHỐT LIỀN</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $total = isset($customer_closingSale) && $customer_closingSale ? $customer_closingSale->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $total ? $total->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>

                            <!-- khách mới chốt liền -->

                            <tr>
                                <th style = "font-weight: bold;"> SL KHÁCH HÀNG MỚI CHỐT LIỀN</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $total = isset($customer_newClosingSale) && $customer_newClosingSale ? $customer_newClosingSale->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $total ? $total->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>

                            <!-- khách chốt liền -->

                            <tr>
                                <th style = "font-weight: bold;"> SL KHÁCH HÀNG CHỐT LIỀN</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $total = isset($total_customer_closingSale) && $total_customer_closingSale ? $total_customer_closingSale->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $total ? $total->total_customers : 0 }}
                                        </th>
                                    @endforeach
                            </tr>
                            <!-- TỔNG DOANH SỐ KHÁCH MỚI CHỐT LIỀN -->
                            <tr>
                                <th style = "font-weight: bold;"> TỔNG DOANH SỐ KHÁCH MỚI CHỐT LIỀN</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $total = isset($total_Sale_New) && $total_Sale_New ? $total_Sale_New->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $total ? $total->total_value : 0 }}
                                        </th>
                                    @endforeach
                            </tr>
                             <!-- TỔNG DOANH SỐ KHÁCH CŨ CHỐT LIỀN -->
                            <tr>
                                <th style = "font-weight: bold;"> TỔNG DOANH SỐ KHÁCH CŨ CHỐT LIỀN</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $total = isset($total_Sale_Old) && $total_Sale_Old ? $total_Sale_Old->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $total ? $total->total_value : 0 }}
                                        </th>
                                    @endforeach
                            </tr>

                             <!-- TỔNG DOANH SỐ KHÁCH CŨ CHỐT LIỀN -->
                            <tr>
                                <th style = "font-weight: bold;"> TỔNG DOANH SỐ CHỐT LIỀN</th>
                                    @foreach($showrooms as $showroom)
                                        @php
                                            $total = isset($total_Sale_Month) && $total_Sale_Month ? $total_Sale_Month->firstWhere('showroom_id', $showroom->id) : null;
                                        @endphp
                                        <th style = "font-weight: bold; color: blue;">
                                            {{ $total ? $total->total_value_month : 0 }}
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
