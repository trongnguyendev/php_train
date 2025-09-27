<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CustomerStatisticsController extends Controller
{
    public function index()
    {
        return view('statistics.index');
    }

    public function getData()
    {
        $statistics = DB::table('customers')
            ->join('type_showrooms', 'customers.type_showroom_id', '=', 'type_showrooms.id')
            ->select(
                'customers.customer_for_showroom',
                'type_showrooms.name as showroom_name',
                DB::raw('COUNT(customers.id) as total_customers')
            )
            ->groupBy('customers.customer_for_showroom', 'type_showrooms.name')
            ->orderBy('customers.customer_for_showroom')
            ->get();

        return response()->json($statistics);
    }
}
