<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class CustomerStatisticsController extends Controller
{
    public function index()
    {
        return view('statistics.index');
    }

    
    public function statisticsData()
    {
    $data = Customer::select(
            DB::raw('DATE(customer_for_showroom) as ngay'),
            'customers.type_showroom_id',
            'type_showrooms.name as showroom_name',
            DB::raw('COUNT(*) as tong_khach')
        )
        ->join('type_showrooms', 'customers.type_showroom_id', '=', 'type_showrooms.id')
        ->groupBy(DB::raw('DATE(customer_for_showroom)'), 'customers.type_showroom_id', 'type_showrooms.name')
        ->orderBy('ngay', 'asc')
        ->get();

    $dataChart2 = Customer::select(
            DB::raw('DATE(customer_for_showroom) as ngay'),
            'customers.type_showroom_id',
            'type_showrooms.name as showroom_name',
            DB::raw('COUNT(*) as tong_khach')
        )
        ->join('type_showrooms', 'customers.type_showroom_id', '=', 'type_showrooms.id')
        ->join('type_customers', 'customers.type_customer_yet_id', '=', 'type_customers.id')
        ->join('statuses', 'customers.current_status_id', '=', 'statuses.id')
        ->whereColumn('salename_infor_id', 'salename_support_id')
        ->where('type_customers.name', 'Khách hàng mới')
        ->where('statuses.name', 'Tiềm năng')
        ->groupBy(DB::raw('DATE(customer_for_showroom)'), 'customers.type_showroom_id', 'type_showrooms.name')
        ->orderBy('ngay', 'asc')
        ->get();


        return response()->json([
            'data' => $data,
            'dataChart2' => $dataChart2
        ]);
    }

}
