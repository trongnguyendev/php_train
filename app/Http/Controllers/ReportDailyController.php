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
        $month = $request->input('month') ?? Carbon::now()->format('Y-m');
        $last_month = Carbon::parse($month.'-01')->subMonth()->format('Y-m');

        // Lấy ngày đầu và cuối tháng
        $startMonth = Carbon::parse($month.'-01')->startOfMonth()->toDateString();
        $endMonth = Carbon::parse($month.'-01')->endOfMonth()->toDateString();
        $startLastMonth = Carbon::parse($last_month.'-01')->startOfMonth()->toDateString();
        $endLastMonth = Carbon::parse($last_month.'-01')->endOfMonth()->toDateString();

        // Truy vấn theo tháng hiện tại
        $showroomStats = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1 THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN sale_information_id = sale_support_id AND lead_type = 2 THEN 1 ELSE 0 END) as online_customers')
            )
            ->groupBy('showroom_id')
            ->get();
        $showroomStats = $showroomStats ?? collect();

        $khNew = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN sale_information_id = sale_support_id AND lead_type = 2 AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as online_customers')
            )
            ->groupBy('showroom_id')
            ->get();
        $khNew = $khNew ?? collect();

        $khOld = collect();
        foreach ($showroomStats as $stat) {
            $khNewStat = $khNew->firstWhere('showroom_id', $stat->showroom_id);
            $total_customers = $stat->total_customers - ($khNewStat ? $khNewStat->total_customers : 0);
            $khOld->push((object)[
                'showroom_id' => $stat->showroom_id,
                'total_customers' => $total_customers,
            ]);
        }
        // Khách hàng tiềm năng
        $customer_potential_new = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1  AND customer_types.name = "Khách Hàng Mới" AND customer_statuses.name = "Tiềm Năng" THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN sale_information_id = sale_support_id AND customer_types.name = "Khách Hàng Mới" AND lead_type = 2 AND customer_statuses.name = "Tiềm Năng" THEN 1 ELSE 0 END ) as online_customers')
            )
            ->groupBy('showroom_id')
            ->get();
        $customer_potential_new = $customer_potential_new ?? collect();

        $customer_potential_old = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1  AND customer_types.name = "Khách Hàng Cũ" AND customer_statuses.name = "Tiềm Năng" THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN sale_information_id = sale_support_id AND lead_type = 2 AND customer_types.name = "Khách Hàng Cũ" AND customer_statuses.name = "Tiềm Năng" THEN 1 ELSE 0 END) as online_customers')
            )
            ->groupBy('showroom_id')
            ->get();
        $customer_potential_old = $customer_potential_old ?? collect();

        $total_customer_potential = collect();
        foreach ($showrooms as $showroom) {
            $new = collect($customer_potential_new)->firstWhere('showroom_id', $showroom->id);
            $old = collect($customer_potential_old)->firstWhere('showroom_id', $showroom->id);
            $total_customers = ($new ? $new->total_customers : 0) + ($old ? $old->total_customers : 0);
            $total_customer_potential->push((object)[
                'showroom_id' => $showroom->id,
                'total_customers' => $total_customers,
            ]);
        }

        // Truy vấn cho tháng trước
        $showroomStatsLast = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->whereBetween('first_interaction_date', [$startLastMonth, $endLastMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1 THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN sale_information_id = sale_support_id AND lead_type = 2 THEN 1 ELSE 0 END) as online_customers')
            )
            ->groupBy('showroom_id')
            ->get();
        $showroomStatsLast = $showroomStatsLast ?? collect();

        // Khách hàng quan tâm
        $customer_care = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1  AND customer_statuses.name = "Quan Tâm" THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN sale_information_id = sale_support_id AND lead_type = 2 AND customer_statuses.name = "Quan Tâm" THEN 1 ELSE 0 END) as online_customers')
            )
            ->groupBy('showroom_id')
            ->get();
        $customer_care = $customer_care ?? collect();

        // khách hàng tham khảo

        $customer_reference = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1  AND customer_statuses.name = "Tham Khảo" THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN sale_information_id = sale_support_id AND lead_type = 2 AND customer_statuses.name = "Tham Khảo" THEN 1 ELSE 0 END) as online_customers')
            )
            ->groupBy('showroom_id')
            ->get();
        $customer_reference = $customer_reference ?? collect();

        // Khách hàng hết nhu cầu

        $customer_outOfNeed = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1  AND customer_statuses.name = "Hết Nhu Cầu" THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN sale_information_id = sale_support_id AND lead_type = 2 AND customer_statuses.name = "Hết Nhu Cầu" THEN 1 ELSE 0 END) as online_customers')
            )
            ->groupBy('showroom_id')
            ->get();
        $customer_outOfNeed = $customer_outOfNeed ?? collect();

        // Khách Hàng Cũ Chốt liền

        $customer_oldClosed = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1  AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN sale_information_id = sale_support_id AND lead_type = 2 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as online_customers')
            )
            ->groupBy('showroom_id')
            ->get();
        $customer_oldClosed = $customer_oldClosed ?? collect();

        // Khách Hàng Mới Đã Chốt

        $customer_newClosed = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1  AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN sale_information_id = sale_support_id AND lead_type = 2 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as online_customers')
            )
            ->groupBy('showroom_id')
            ->get();
        $customer_newClosed = $customer_newClosed ?? collect();

        // Khách hàng chốt liền
        $total_customer_closingSale= collect();
        foreach ($showrooms as $showroom) {
            $new = collect($customer_newClosed)->firstWhere('showroom_id', $showroom->id);
            $old = collect($customer_oldClosed)->firstWhere('showroom_id', $showroom->id);
            $total_customers = ($new ? $new->total_customers : 0) + ($old ? $old->total_customers : 0);
            $total_customer_closingSale->push((object)[
                'showroom_id' => $showroom->id,
                'total_customers' => $total_customers,
            ]);
        }
        // Giá trị đơn chốt được mới
        $total_Sale_New = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN customer_types.name = "Khách Hàng Mới" AND lead_type = 1 THEN order_value ELSE 0 END) as total_value')
            )
            ->groupBy('showroom_id')
            ->get();
        $total_Sale_New = $total_Sale_New ?? collect();

        // Giá trị đơn chốt được cũ
        $total_Sale_Old = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
            ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN customer_types.name = "Khách Hàng Cũ" AND lead_type = 1
                THEN order_value ELSE 0 END) as total_value')
            )
            ->groupBy('showroom_id')
            ->get();
        $total_Sale_Old = $total_Sale_Old ?? collect();

        // TỔNG DOANH SỐ CHỐT LIỀN KHÁCH HÀNG
        $total_sale= collect();
        foreach ($showrooms as $showroom) {
            $new = collect($total_Sale_New)->firstWhere('showroom_id', $showroom->id);
            $old = collect($total_Sale_Old)->firstWhere('showroom_id', $showroom->id);
            $total_value = ($new ? $new->total_value : 0) + ($old ? $old->total_value : 0);
            $total_sale->push((object)[
                'showroom_id' => $showroom->id,
                'total_value' => $total_value,
            ]);
        }

        // Giá trị đơn chốt được ở tháng
        $total_Sale_Month = DB::table('leads')
                ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
                ->join('customer_sources', 'customer_sources.id', '=', 'leads.source_id')
                ->join('showrooms', 'showrooms.id', '=', 'leads.showroom_id')
                ->whereBetween('first_interaction_date', [$startMonth, $endMonth])
                ->whereRaw('customer_sources.name LIKE CONCAT("%", showrooms.name, "%")')
                ->select(
                'showroom_id',
                DB::raw('SUM(CASE WHEN customer_types.name = "Khách Hàng Cũ" AND lead_type = 1 THEN order_value ELSE 0 END) as total_value_month')
            )
            ->groupBy('showroom_id')
            ->get();
        $total_Sale_Old = $total_Sale_Old ?? collect();

        return view('report_showroom.index', [
            'showrooms' => $showrooms,
            'showroomStats' => $showroomStats,
            'showroomStatsLast' => $showroomStatsLast,
            'month' => $month,
            'last_month' => $last_month,
            'khNew' => $khNew,
            'khOld' => $khOld,
            'customer_potential_new' => $customer_potential_new,
            'customer_potential_old' => $customer_potential_old,
            'total_customer_potential' => $total_customer_potential,
            'customer_care' => $customer_care,
            'customer_reference' => $customer_reference,
            'customer_outOfNeed' => $customer_outOfNeed,
            'customer_oldClosed' => $customer_oldClosed,
            'customer_newClosed' => $customer_newClosed,
            'total_customer_closingSale' => $total_customer_closingSale,
            'total_Sale_New' => $total_Sale_New,
            'total_Sale_Old' => $total_Sale_Old,
            'total_sale' => $total_sale,
            'total_Sale_Month' => $total_Sale_Month,
        ]);
    }
 
}