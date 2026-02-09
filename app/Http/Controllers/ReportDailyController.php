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
            ->where('lead_type', 1)
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
        // $request->validate([
        //     'month-to' => 'nullable|date_format:Y-m',
        //     'month-from' => 'nullable|date_format:Y-m',
        // ]);

        // // Lấy tháng hiện tại hoặc tháng được chọn
        // $monthCurrent = $request->input('month-to') ? Carbon::parse($request->input('month-to')) : Carbon::now();
        // $monthOld = $request->input('month-from') ? Carbon::parse($request->input('month-from')) : (clone $monthCurrent)->subMonth();
        

        // // Hàm truy vấn dữ liệu theo tháng
        // $getDataByMonth = function($month) {
        //     $start = $month->copy()->startOfMonth()->toDateString();
        //     $end = $month->copy()->endOfMonth()->toDateString();
        $request->validate([
        'from_date_1' => 'nullable|date',
        'to_date_1'   => 'nullable|date',
        'from_date_2' => 'nullable|date',
        'to_date_2'   => 'nullable|date',
    ]);

        // Khoảng 1 (mặc định: tháng hiện tại)
        $fromDate1 = $request->input('from_date_1')
            ? Carbon::parse($request->input('from_date_1'))->startOfDay()
            : Carbon::now()->startOfMonth();

        $toDate1 = $request->input('to_date_1')
            ? Carbon::parse($request->input('to_date_1'))->endOfDay()
            : Carbon::now()->endOfMonth();

        // Khoảng 2 (mặc định: tháng trước)
        $fromDate2 = $request->input('from_date_2')
            ? Carbon::parse($request->input('from_date_2'))->startOfDay()
            : Carbon::now()->subMonth()->startOfMonth();

        $toDate2 = $request->input('to_date_2')
            ? Carbon::parse($request->input('to_date_2'))->endOfDay()
            : Carbon::now()->subMonth()->endOfMonth();


            // Hàm query theo khoảng ngày
        $getDataByRange = function ($from, $to) {

            return DB::table('leads')
                ->join('sale_users', 'sale_users.id', '=', 'leads.sale_information_id')
                ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
                ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
                ->where('lead_type', 1)
                ->whereBetween('leads.first_interaction_date', [$from, $to])
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

        
            // Lấy dữ liệu
            $data = $getDataByRange($fromDate1, $toDate1);
            $data_prev = $getDataByRange($fromDate2, $toDate2);


         return view('report_month.index', [
        'data' => $data,
        'data_prev' => $data_prev,
        'from_date_1' => $fromDate1->toDateString(),
        'to_date_1' => $toDate1->toDateString(),
        'from_date_2' => $fromDate2->toDateString(),
        'to_date_2' => $toDate2->toDateString(),
    ]);
    }

   public function reportShowroom(Request $request)
    {
        $showrooms = Showroom::all();
        $metrics = [
            'SL KHÁCH HÀNG ĐẾN SR' => 'sr_total_customers',
            'SL KHÁCH HÀNG MỚI'   => 'sr_new_customers',
            'SL KHÁCH HÀNG CŨ'    => 'sr_old_customers',
            'KH MỚI TIỀM NĂNG'     => 'sr_new_potential',
            'KH CŨ TIỀM NĂNG'      => 'sr_old_potential',
            'KH TIỀM NĂNG'        => 'sr_total_potential',
            'KH QUAN TÂM'         => 'sr_total_care',
            'KH THAM KHẢO'        => 'sr_total_reference',
            'KH HẾT NHU CẦU'      => 'sr_total_no_need',
            'KH ĐÃ CHỐT MỚI'      => 'sr_new_closed',
            'KH ĐÃ CHỐT CŨ'       => 'sr_old_closed',
            'DOANH SỐ MỚI'        => 'sr_total_new_closed',
            'DOANH SỐ CŨ'         => 'sr_total_old_closed',
            'TỔNG DOANH SỐ CHỐT LIỀN'       => 'sr_total_sale_closed',
            'TỔNG DOANH SỐ THÁNG'          => 'sr_total',
        ];

        // $month = $request->input('month') ?? Carbon::now()->format('Y-m');
        // $last_month = $request->input('last-month') ?? Carbon::now()->subMonth()->format('Y-m');

        // Khoảng ngày 1
$fromDate1 = $request->input('from_date_1')
    ? Carbon::parse($request->input('from_date_1'))->startOfDay()
    : Carbon::now()->startOfMonth();

$toDate1 = $request->input('to_date_1')
    ? Carbon::parse($request->input('to_date_1'))->endOfDay()
    : Carbon::now()->endOfMonth();

// Khoảng ngày 2 (so sánh)
$fromDate2 = $request->input('from_date_2')
    ? Carbon::parse($request->input('from_date_2'))->startOfDay()
    : Carbon::now()->subMonth()->startOfMonth();

$toDate2 = $request->input('to_date_2')
    ? Carbon::parse($request->input('to_date_2'))->endOfDay()
    : Carbon::now()->subMonth()->endOfMonth();

        // Khách trực tiếp (offline)
        $data_offline = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->join('showrooms', 'showrooms.id', '=', 'leads.showroom_id')
            // ->whereBetween('first_interaction_date', [$month.'-01', $month.'-31'])
            ->whereBetween('first_interaction_date', [$fromDate1, $toDate1])
            ->where('lead_type', 1)
            ->select('showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1 THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Tiềm Năng" AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_potential'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Tiềm Năng" AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_potential'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Quan Tâm" THEN 1 ELSE 0 END) as total_care'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Tham Khảo" THEN 1 ELSE 0 END) as total_reference'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Hết Nhu Cầu" THEN 1 ELSE 0 END) as total_no_need'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Mới" THEN COALESCE(order_value, 0) ELSE 0 END) as total_new_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Cũ" THEN COALESCE(order_value, 0) ELSE 0 END) as total_old_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 1 THEN COALESCE(order_value, 0) ELSE 0 END) as total'),
           
                // ... thêm các trường khác nếu cần ...
            )
            ->groupBy('showroom_id')
            ->get();

        // Khách online
        $data_online = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->join('customer_sources', 'customer_sources.id', '=', 'leads.source_id')
            // KHÔNG join showroom
            // ->whereBetween('first_interaction_date', [$month.'-01', $month.'-31'])
            ->whereBetween('first_interaction_date', [$fromDate1, $toDate1])
            ->where('lead_type', 2)
            ->select('source_id',
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Tiềm Năng" AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_potential'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Tiềm Năng" AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_potential'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Quan Tâm" THEN 1 ELSE 0 END) as total_care'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Tham Khảo" THEN 1 ELSE 0 END) as total_reference'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Hết Nhu Cầu" THEN 1 ELSE 0 END) as total_no_need'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Mới" THEN COALESCE(order_value, 0) ELSE 0 END) as total_new_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Cũ" THEN COALESCE(order_value, 0) ELSE 0 END) as total_old_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Đã Chốt"  THEN COALESCE(order_value, 0) ELSE 0 END) as total'),
                // ... thêm các trường khác nếu cần ...
            )
            ->groupBy('source_id')
            ->get();

        // Tính tổng new_customers và old_customers của cả offline và online
        // Tổng cho tháng hiện tại
        // Tổng toàn hệ thống (offline + online)
        $sr_total_customers = 0;
        $sr_new_customers = 0;
        $sr_old_customers = 0;
        $sr_new_potential = 0;
        $sr_old_potential = 0;
        $sr_total_potential = 0;
        $sr_total_care = 0;
        $sr_total_reference = 0;
        $sr_total_no_need = 0;
        $sr_new_closed = 0;
        $sr_old_closed = 0;
        $sr_total_new_closed = 0;
        $sr_total_old_closed = 0;
        $sr_total_sale_closed = 0;
        $sr_total = 0;
        // Tổng theo showroom
        $totals_current = [];
        foreach ($showrooms as $showroom) {
            foreach ($metrics as $key) {
                $totals_current[$showroom->id][$key] = 0;
            }
        }
        // Duyệt offline
        foreach ($data_offline as $item) {
            $sr_total_customers += $item->total_customers;
            $sr_new_customers += $item->new_customers;
            $sr_old_customers += $item->old_customers;
            $sr_new_potential += $item->new_potential;
            $sr_old_potential += $item->old_potential;
           
            $sr_total_care += $item->total_care;
            $sr_total_reference += $item->total_reference;
            $sr_total_no_need += $item->total_no_need;
            $sr_new_closed += $item->new_closed;
            $sr_old_closed += $item->old_closed;
            $sr_total_new_closed += $item->total_new_closed;
            $sr_total_old_closed += $item->total_old_closed;
            $sr_total_sale_closed += $item->total_new_closed + $item->total_old_closed;
            $sr_total += $item->total;
            // Gán cho showroom
            foreach ($metrics as $label => $key) {
                switch ($key) {
                    case 'sr_total_customers': $totals_current[$item->showroom_id][$key] += $item->total_customers; break;
                    case 'sr_new_customers': $totals_current[$item->showroom_id][$key] += $item->new_customers; break;
                    case 'sr_old_customers': $totals_current[$item->showroom_id][$key] += $item->old_customers; break;
                    case 'sr_new_potential': $totals_current[$item->showroom_id][$key] += $item->new_potential; break;
                    case 'sr_old_potential': $totals_current[$item->showroom_id][$key] += $item->old_potential; break;

                    case 'sr_total_potential': $totals_current[$item->showroom_id][$key] += (int) $item->old_potential + (int) $item->new_potential; break;
                    case 'sr_total_care': $totals_current[$item->showroom_id][$key] += $item->total_care; break;
                    case 'sr_total_reference': $totals_current[$item->showroom_id][$key] += $item->total_reference; break;
                    case 'sr_total_no_need': $totals_current[$item->showroom_id][$key] += $item->total_no_need; break;
                    case 'sr_new_closed': $totals_current[$item->showroom_id][$key] += $item->new_closed; break;
                    case 'sr_old_closed': $totals_current[$item->showroom_id][$key] += $item->old_closed; break;
                    case 'sr_total_new_closed': $totals_current[$item->showroom_id][$key] += $item->total_new_closed; break;
                    case 'sr_total_old_closed': $totals_current[$item->showroom_id][$key] += $item->total_old_closed; break;
                    case 'sr_total_sale_closed': $totals_current[$item->showroom_id][$key] += $item->total_new_closed + $item->total_old_closed; break;
                    case 'sr_total': $totals_current[$item->showroom_id][$key] += $item->total; break;
                    // ... các trường khác nếu có ...
                }
            }
        }
        // Mapping source_id online về showroom_id dựa trên tên showroom và tên nguồn
        // Chuẩn hóa tên để so khớp chính xác hơn
        function normalizeName($name) {
            $name = mb_strtolower($name, 'UTF-8');
            $name = str_replace(['showroom', 'xem tt'], '', $name);
            $name = preg_replace('/\s+/', ' ', $name);
            return trim($name);
        }
        $sourceIdToShowroomId = [];
        $sources = DB::table('customer_sources')->pluck('name', 'id');
        foreach ($showrooms as $showroom) {
            $showroomNorm = normalizeName($showroom->name);
            foreach ($sources as $source_id => $source_name) {
                $sourceNorm = normalizeName($source_name);
                // Nếu phần tên showroom nằm trong tên nguồn online (ví dụ: "quận 1" trong "xem tt quận 1")
                if ($showroomNorm && strpos($sourceNorm, $showroomNorm) !== false) {
                    $sourceIdToShowroomId[$source_id] = $showroom->id;
                }
            }
        }
        foreach ($data_online as $item) {
            $sr_total_customers += $item->total_customers;
            $sr_new_customers += $item->new_customers;
            $sr_old_customers += $item->old_customers;
            $sr_new_potential += $item->new_potential;
            $sr_old_potential += $item->old_potential;
           
            $sr_total_reference += $item->total_reference;
            $sr_total_no_need += $item->total_no_need;
            $sr_new_closed += $item->new_closed;
            $sr_old_closed += $item->old_closed;
            $sr_total_sale_closed += $item->total_new_closed + $item->total_old_closed;
            $sr_total += $item->total;
            // Nếu source_id online map được showroom_id thì cộng vào showroom tương ứng
            if (isset($sourceIdToShowroomId[$item->source_id])) {
                $showroom_id = $sourceIdToShowroomId[$item->source_id];
                foreach ($metrics as $label => $key) {
                    switch ($key) {
                        case 'sr_total_customers': $totals_current[$showroom_id][$key] += $item->total_customers; break;
                        case 'sr_new_customers': $totals_current[$showroom_id][$key] += $item->new_customers; break;
                        case 'sr_old_customers': $totals_current[$showroom_id][$key] += $item->old_customers; break;
                        case 'sr_new_potential': $totals_current[$showroom_id][$key] += $item->new_potential; break;
                        case 'sr_old_potential': $totals_current[$showroom_id][$key] += $item->old_potential; break;

                        case 'sr_total_potential': $totals_current[$showroom_id][$key] += (int) $item->old_potential + (int) $item->new_potential; break;
                        case 'sr_total_care': $totals_current[$showroom_id][$key] += $item->total_care; break;
                        case 'sr_total_reference': $totals_current[$showroom_id][$key] += $item->total_reference; break;
                        case 'sr_total_no_need': $totals_current[$showroom_id][$key] += $item->total_no_need; break;
                        case 'sr_new_closed': $totals_current[$showroom_id][$key] += $item->new_closed; break;
                        case 'sr_old_closed': $totals_current[$showroom_id][$key] += $item->old_closed; break;
                        case 'sr_total_new_closed': $totals_current[$showroom_id][$key] += $item->total_new_closed; break;
                        case 'sr_total_old_closed': $totals_current[$showroom_id][$key] += $item->total_old_closed; break;
                        case 'sr_total_sale_closed': $totals_current[$showroom_id][$key] += $item->total_new_closed + $item->total_old_closed; break;
                        case 'sr_total': $totals_current[$showroom_id][$key] += $item->total; break;
                    }
                }
            }
        }
        $totals_sum = [
            'sr_total_customers' => $sr_total_customers,
            'sr_new_customers' => $sr_new_customers,
            'sr_old_customers' => $sr_old_customers,
            'sr_new_potential' => $sr_new_potential,
            'sr_old_potential' => $sr_old_potential,
            
            'sr_total_care' => $sr_total_care,
            'sr_total_reference' => $sr_total_reference,
            'sr_total_no_need' => $sr_total_no_need,
            'sr_new_closed' => $sr_new_closed,
            'sr_old_closed' => $sr_old_closed,
            'sr_total_new_closed' => $sr_total_new_closed,
            'sr_total_old_closed' => $sr_total_old_closed,
            'sr_total_sale_closed' => $sr_total_sale_closed,
            'sr_total' => $sr_total,
        ];

        // Tổng cho tháng trước (tương tự như trên)
        $data_offline_prev = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->join('showrooms', 'showrooms.id', '=', 'leads.showroom_id')
            // ->whereBetween('first_interaction_date', [$last_month.'-01', $last_month.'-31'])
            ->whereBetween('first_interaction_date', [$fromDate2, $toDate2])
            ->where('lead_type', 1)
            ->select('showroom_id',
                DB::raw('SUM(CASE WHEN lead_type = 1 THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Tiềm Năng" AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_potential'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Tiềm Năng" AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_potential'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Quan Tâm" THEN 1 ELSE 0 END) as total_care'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Tham Khảo" THEN 1 ELSE 0 END) as total_reference'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Hết Nhu Cầu" THEN 1 ELSE 0 END) as total_no_need'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Mới" THEN COALESCE(order_value, 0) ELSE 0 END) as total_new_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 1 AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Cũ" THEN COALESCE(order_value, 0) ELSE 0 END) as total_old_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 1 THEN COALESCE(order_value, 0) ELSE 0 END) as total'),
            )
            ->groupBy('showroom_id')
            ->get();

        $data_online_prev = DB::table('leads')
            ->join('customer_types', 'customer_types.id', '=', 'leads.customer_type_id')
            ->join('customer_statuses', 'customer_statuses.id', '=', 'leads.current_customer_status_id')
            ->join('customer_sources', 'customer_sources.id', '=', 'leads.source_id')
            // ->whereBetween('first_interaction_date', [$last_month.'-01', $last_month.'-31'])
            ->whereBetween('first_interaction_date', [$fromDate2, $toDate2])
            ->where('lead_type', 2)
            ->select('source_id',
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id THEN 1 ELSE 0 END) as total_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_customers'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Tiềm Năng" AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_potential'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Tiềm Năng" AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_potential'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Quan Tâm" THEN 1 ELSE 0 END) as total_care'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Tham Khảo" THEN 1 ELSE 0 END) as total_reference'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Hết Nhu Cầu" THEN 1 ELSE 0 END) as total_no_need'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Mới" THEN 1 ELSE 0 END) as new_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Cũ" THEN 1 ELSE 0 END) as old_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Mới" THEN COALESCE(order_value, 0) ELSE 0 END) as total_new_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Đã Chốt" AND customer_types.name = "Khách Hàng Cũ" THEN COALESCE(order_value, 0) ELSE 0 END) as total_old_closed'),
                DB::raw('SUM(CASE WHEN lead_type = 2 AND sale_information_id = sale_support_id AND customer_statuses.name = "Đã Chốt"  THEN COALESCE(order_value, 0) ELSE 0 END) as total'),
            )
            ->groupBy('source_id')
            ->get();

        $totals_prev = [];
        foreach ($showrooms as $showroom) {
            foreach ($metrics as $key) {
                $totals_prev[$showroom->id][$key] = 0;
            }
        }
        foreach ($data_offline_prev as $item) {
            foreach ($metrics as $label => $key) {
                switch ($key) {
                    case 'sr_total_customers': $totals_prev[$item->showroom_id][$key] += $item->total_customers; break;
                    case 'sr_new_customers': $totals_prev[$item->showroom_id][$key] += $item->new_customers; break;
                    case 'sr_old_customers': $totals_prev[$item->showroom_id][$key] += $item->old_customers; break;
                    case 'sr_new_potential': $totals_prev[$item->showroom_id][$key] += $item->new_potential; break;
                    case 'sr_old_potential': $totals_prev[$item->showroom_id][$key] += $item->old_potential; break;
                    case 'sr_total_potential': $totals_prev[$item->showroom_id][$key] += (int) $item->old_potential + (int) $item->new_potential; break;
                    case 'sr_total_care': $totals_prev[$item->showroom_id][$key] += $item->total_care; break;
                    case 'sr_total_reference': $totals_prev[$item->showroom_id][$key] += $item->total_reference; break;
                    case 'sr_total_no_need': $totals_prev[$item->showroom_id][$key] += $item->total_no_need; break;
                    case 'sr_new_closed': $totals_prev[$item->showroom_id][$key] += $item->new_closed; break;
                    case 'sr_old_closed': $totals_prev[$item->showroom_id][$key] += $item->old_closed; break;
                    case 'sr_total_new_closed': $totals_prev[$item->showroom_id][$key] += $item->total_new_closed; break;
                    case 'sr_total_old_closed': $totals_prev[$item->showroom_id][$key] += $item->total_old_closed; break;
                    case 'sr_total_sale_closed': $totals_prev[$item->showroom_id][$key] += $item->total_new_closed + $item->total_old_closed; break;
                    case 'sr_total': $totals_prev[$item->showroom_id][$key] += $item->total; break;
                }
            }
        }
        // Mapping source_id online về showroom_id cho dữ liệu tháng trước
        foreach ($data_online_prev as $item) {
            if (isset($sourceIdToShowroomId[$item->source_id])) {
                $showroom_id = $sourceIdToShowroomId[$item->source_id];
                foreach ($metrics as $label => $key) {
                    switch ($key) {
                        case 'sr_total_customers': $totals_prev[$showroom_id][$key] += $item->total_customers; break;
                        case 'sr_new_customers': $totals_prev[$showroom_id][$key] += $item->new_customers; break;
                        case 'sr_old_customers': $totals_prev[$showroom_id][$key] += $item->old_customers; break;
                        case 'sr_new_potential': $totals_prev[$showroom_id][$key] += $item->new_potential; break;
                        case 'sr_old_potential': $totals_prev[$showroom_id][$key] += $item->old_potential; break;
                        case 'sr_total_potential': $totals_prev[$showroom_id][$key] += (int) $item->old_potential + (int) $item->new_potential; break;
                        case 'sr_total_care': $totals_prev[$showroom_id][$key] += $item->total_care; break;
                        case 'sr_total_reference': $totals_prev[$showroom_id][$key] += $item->total_reference; break;
                        case 'sr_total_no_need': $totals_prev[$showroom_id][$key] += $item->total_no_need; break;
                        case 'sr_new_closed': $totals_prev[$showroom_id][$key] += $item->new_closed; break;
                        case 'sr_old_closed': $totals_prev[$showroom_id][$key] += $item->old_closed; break;
                        case 'sr_total_new_closed': $totals_prev[$showroom_id][$key] += $item->total_new_closed; break;
                        case 'sr_total_old_closed': $totals_prev[$showroom_id][$key] += $item->total_old_closed; break;
                        case 'sr_total_sale_closed': $totals_prev[$showroom_id][$key] += $item->total_new_closed + $item->total_old_closed; break;
                        case 'sr_total': $totals_prev[$showroom_id][$key] += $item->total; break;
                    }
                }
            }
        }
        // Nếu có mapping showroom_id cho online thì cộng vào $totals_prev tương ứng

        return view('report_showroom.index', compact('showrooms', 'metrics', 'data_offline', 'data_online', 'totals_current', 'totals_prev'));
    }

 
}