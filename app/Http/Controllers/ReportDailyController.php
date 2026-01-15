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
        $date = $request->input('date');
        $today = $date ? Carbon::parse($date)->toDateString() : Carbon::today()->toDateString();

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
                \DB::raw('SUM(CASE WHEN leads.customer_type_id = customer_types.id AND customer_types.name = "Khách Hàng Mới" AND customer_statuses.name = "Tiềm Năng"
                THEN 1 ELSE 0 END) as total_new_potential'),
                \DB::raw('SUM(CASE WHEN leads.customer_type_id = customer_types.id AND customer_types.name = "Khách Hàng Cũ" AND customer_statuses.name = "Tiềm Năng"
                THEN 1 ELSE 0 END) as total_old_potential'),
                \DB::raw('SUM(
                    CASE 
                        WHEN leads.customer_type_id = customer_types.id AND customer_types.name IN ("Khách Hàng Mới", "Khách Hàng Cũ")
                        AND customer_statuses.name = "Tiềm Năng"
                        THEN 1 ELSE 0 
                    END
                ) as total_potential'),
                \DB::raw('SUM(CASE WHEN leads.customer_type_id = customer_types.id AND customer_statuses.name = "Quan Tâm"
                THEN 1 ELSE 0 END) as total_care'),
                \DB::raw('SUM(CASE WHEN leads.customer_type_id = customer_types.id AND customer_types.name = "Khách Hàng Mới" AND customer_statuses.name = "Đã Chốt"
                THEN 1 ELSE 0 END) as total_new_locked'),
                \DB::raw('SUM(CASE WHEN leads.customer_type_id = customer_types.id AND customer_types.name = "Khách Hàng Cũ" AND customer_statuses.name = "Đã Chốt"
                THEN 1 ELSE 0 END) as total_old_locked'),
                \DB::raw('SUM(leads.order_value) as total_value')
            )
            ->groupBy('sale_users.id', 'sale_users.name')
            ->get();

        return view('report_daily.index', compact('data', 'today'));
    }

    public function exportCurrentMonth(Request $request)
    {
        $request->validate([
            'month' => 'nullable|date_format:Y-m',
        ]);

        // Lấy tháng hiện tại hoặc tháng được chọn
        $month = $request->input('month') ? Carbon::parse($request->input('month').'-01') : Carbon::now();
        $prevMonth = (clone $month)->subMonth();

        // Hàm truy vấn dữ liệu theo tháng
        $getDataByMonth = function($month) {
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();
            return DB::table('leads')
                ->join('sale_users', 'sale_users.id', '=', 'leads.sale_information_id')
                ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
                ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
                ->whereBetween('leads.first_interaction_date', [$start, $end])
                ->select(
                    'sale_users.id',
                    'sale_users.name as sale_name',
                    DB::raw('COUNT(leads.id) as total_customers'),
                    DB::raw('SUM(CASE WHEN customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as total_new_customers'),
                    DB::raw('SUM(CASE WHEN customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as total_old_customers'),
                    DB::raw('SUM(CASE WHEN customer_types.name = "Khách Hàng Mới" AND customer_statuses.name = "Tiềm Năng" THEN 1 ELSE 0 END) as total_new_potential'),
                    DB::raw('SUM(CASE WHEN customer_types.name = "Khách Hàng Cũ" AND customer_statuses.name = "Tiềm Năng" THEN 1 ELSE 0 END) as total_old_potential'),
                    DB::raw('SUM(CASE WHEN customer_types.name IN ("Khách Hàng Mới", "Khách Hàng Cũ") AND customer_statuses.name = "Tiềm Năng" THEN 1 ELSE 0 END) as total_potential'),
                    DB::raw('SUM(CASE WHEN customer_statuses.name = "Quan Tâm" THEN 1 ELSE 0 END) as total_care'),
                    DB::raw('SUM(CASE WHEN customer_types.name = "Khách Hàng Mới" AND customer_statuses.name = "Đã Chốt" THEN 1 ELSE 0 END) as total_new_locked'),
                    DB::raw('SUM(CASE WHEN customer_types.name = "Khách Hàng Cũ" AND customer_statuses.name = "Đã Chốt" THEN 1 ELSE 0 END) as total_old_locked'),
                    DB::raw('SUM(leads.order_value) as total_value')
                )
                ->groupBy('sale_users.id', 'sale_users.name')
                ->get();
        };

        $data = $getDataByMonth($month);
        $data_prev = $getDataByMonth($prevMonth);

        return view('report_month.index', [
            'data' => $data,
            'data_prev' => $data_prev,
            'month' => $month->format('Y-m'),
            'prev_month' => $prevMonth->format('Y-m'),
        ]);
    }

 
}