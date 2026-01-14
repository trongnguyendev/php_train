<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ReportDaily;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Auth;

class ReportDailyController extends Controller
{
    public function exportDaily(Request $request)
    {
       $today = Carbon::today();

        $data = DB::table('leads')
            ->join('sale_users', 'sale_users.id', '=', 'leads.sale_information_id')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->whereDate('leads.first_interaction_date', $today)
            ->select(
                'sale_users.id',
                'sale_users.name as sale_name',
                \DB::raw('COUNT(leads.id) as total_customers'),
                \DB::raw('SUM(CASE WHEN leads.customer_type_id = customer_types.id AND customer_types.name = "Khách Hàng Mới"
                THEN 1 ELSE 0 END) as total_new_customers'),
                \DB::raw('SUM(CASE WHEN leads.customer_type_id = customer_types.id AND customer_types.name = "Khách Hàng Cũ"
                 THEN 1 ELSE 0 END) as total_old_customers'),
                \DB::raw('SUM(CASE WHEN leads.customer_type_id = customer_types.id AND customer_types.name = "Khách Hàng Mới" AND current_customer_status_id =  customer_statuses.id = "Tiềm Năng"
                THEN 1 ELSE 0 END) as total_new_potential'),
                
            )
            ->groupBy('sale_users.id', 'sale_users.name')
            ->get();

        return view('report_daily.index', compact('data', 'today'));
    }
}
