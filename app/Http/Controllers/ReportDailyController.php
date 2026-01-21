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
use App\Models\Showroom;

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
            'month-from' => 'nullable|date_format:Y-m',
            'month-to' => 'nullable|date_format:Y-m',
        ]);

        // Lấy tháng hiện tại hoặc tháng được chọn
        $monthCurrent = $request->input('month-to') ? Carbon::parse($request->input('month-to')) : Carbon::now();
        $monthOld = $request->input('month-from') ? Carbon::parse($request->input('month-from')) : (clone $monthCurrent)->subMonth();
        

        // Hàm truy vấn dữ liệu theo tháng
        $getDataByMonth = function($start, $end) {
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

        $data = $getDataByMonth($monthCurrent, $monthCurrent);
        $data_prev = $getDataByMonth($monthOld, $monthOld);


        return view('report_month.index', [
            'data' => $data,
            'data_prev' => $data_prev,
            'month' => $monthCurrent->format('Y-m'),
            'prev_month' => $monthOld->format('Y-m'),
        ]);
    }

   public function reportShowroom(Request $request)
    {
        $showrooms = Showroom::all();
        $metrics = [
            'SL KHÁCH HÀNG ĐẾN SR' => 'total_customers',
            'SL KHÁCH HÀNG MỚI'   => 'new_customers',
            'SL KHÁCH HÀNG CŨ'    => 'old_customers',
            'KH TIỀM NĂNG'        => 'potential',
            'KH QUAN TÂM'         => 'care',
            'KH THAM KHẢO'        => 'reference',
            'KH HẾT NHU CẦU'      => 'out_of_need',
            'KH ĐÃ CHỐT MỚI'      => 'new_closed',
            'KH ĐÃ CHỐT CŨ'       => 'old_closed',
            'DOANH SỐ MỚI'        => 'sale_new',
            'DOANH SỐ CŨ'         => 'sale_old',
        ];

        $month = $request->input('month') ?? Carbon::now()->format('Y-m');
        $last_month = $request->input('last-month') ?? Carbon::now()->subMonth()->format('Y-m');

        $showroomMonth = function($starMonth,$endMonth){
            return DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
        
            ->whereBetween('first_interaction_date', [$starMonth, $endMonth])
            ->select('showroom_id',

                // Tổng khách
                DB::raw('SUM(lead_type = 1) as total_customers'),

                // Khách mới / cũ
                DB::raw('SUM(lead_type = 1 AND customer_types.name = "Khách Hàng Mới") as new_customers'),
                DB::raw('SUM(lead_type = 1 AND customer_types.name = "Khách Hàng Cũ") as old_customers'),

                // Online
                DB::raw('SUM(lead_type = 2 AND sale_information_id = sale_support_id) as online_customers'),

                // Tiềm năng
                DB::raw('SUM(lead_type = 1 AND customer_statuses.name = "Tiềm Năng") as potential'),

                // Quan tâm / Tham khảo / Hết nhu cầu
                DB::raw('SUM(lead_type = 1 AND customer_statuses.name = "Quan Tâm") as care'),
                DB::raw('SUM(lead_type = 1 AND customer_statuses.name = "Tham Khảo") as reference'),
                DB::raw('SUM(lead_type = 1 AND customer_statuses.name = "Hết Nhu Cầu") as out_of_need'),

                // Chốt
                DB::raw('SUM(lead_type = 1 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Mới") as new_closed'),
                DB::raw('SUM(lead_type = 1 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Cũ") as old_closed'),

                // Doanh số
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_types.name = "Khách Hàng Mới" THEN order_value ELSE 0 END) as sale_new'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_types.name = "Khách Hàng Cũ" THEN order_value ELSE 0 END) as sale_old')
            )
            ->groupBy('showroom_id')
            ->get();
        };
        $data = $showroomMonth($month.'-01',$month.'-31');
        $data_last = $showroomMonth($last_month.'-01',$last_month.'-31');
        
        return view('report_showroom.index', compact('showrooms', 'metrics', 'data', 'data_last', 'month', 'last_month'));
    }

 
}