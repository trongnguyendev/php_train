<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Lead;
use App\Models\Province;
use App\Models\CustomerType;
use App\Models\CustomerSource;
use App\Models\ProductCategory;
use App\Models\Showroom;
use App\Models\CustomerStatus;
use App\Models\User;
use App\Models\SupportChannel;
use App\Models\CustomerCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class AuditLogController extends Controller
{
    /**
     * Route: audit_logs.index
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('user');

        // 1. Áp dụng bộ lọc
        $this->applyFilters($query, $request);

        // 2. Phân trang và giữ Query String trên URL
        $auditLogs = $query->latest()->paginate(30)->withQueryString();

        // 3. Xây dựng danh sách tên/mã map từ ID
        $maps = $this->buildLookupMaps($auditLogs);

        // 4. Lấy danh sách nhân viên cho Dropdown filter
        $users = User::pluck('name', 'id');

        return view('audit_logs.index', compact('auditLogs', 'maps', 'users'));
    }

    /**
     * Route: leads.history
     */
    public function leadHistory(Request $request, Lead $lead)
    {
        Gate::authorize('view', $lead);

        $query = AuditLog::with('user')
            ->where('model_type', Lead::class)
            ->where('model_id', $lead->id);

        $this->applyFilters($query, $request);

        $auditLogs = $query->orderBy('created_at', 'desc')->get();

        $maps = $this->buildLookupMaps($auditLogs);
        $users = User::pluck('name', 'id');

        return view('audit_logs.index', compact('auditLogs', 'maps', 'users', 'lead'));
    }

    /**
     * Áp dụng điều kiện lọc an toàn
     */
    private function applyFilters($query, Request $request)
    {
        // Lọc theo Người thực hiện
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        // Lọc theo Hành động (Kiểm tra xem DB dùng cột 'event', 'action', hay 'description')
        if ($request->filled('event')) {
            $eventVal = $request->input('event');

            if (Schema::hasColumn('audit_logs', 'event')) {
                $query->where('event', $eventVal);
            } elseif (Schema::hasColumn('audit_logs', 'action')) {
                $query->where('action', $eventVal);
            } elseif (Schema::hasColumn('audit_logs', 'description')) {
                $query->where('description', 'like', "%{$eventVal}%");
            }
        }

        // Lọc theo Loại Model
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->input('model_type'));
        }

        // Lọc theo Khoảng thời gian
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        // Tìm kiếm từ khóa trong old_values hoặc new_values
        if ($request->filled('search')) {
            $keyword = $request->input('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('old_values', 'like', "%{$keyword}%")
                  ->orWhere('new_values', 'like', "%{$keyword}%");
            });
        }
    }

    /**
     * Gom ID và lấy Mã/Tên tương ứng từ DB
     */
    private function buildLookupMaps($auditLogs)
    {
        $lookupIds = [
            'customer_id'            => [],
            'province_id'            => [],
            'customer_type_id'       => [],
            'source_id'              => [],
            'product_categories_id'  => [],
            'showroom_id'            => [],
            'customer_status_id'     => [],
            'user_ids'               => [],
            'support_channel_id'     => [],
        ];

        foreach ($auditLogs as $log) {
            $changes = array_merge($log->old_values ?? [], $log->new_values ?? []);
            foreach ($changes as $key => $val) {
                if (empty($val)) continue;

                if ($key === 'customer_id') {
                    if (is_array($val)) {
                        $lookupIds['customer_id'] = array_merge($lookupIds['customer_id'], $val);
                    } else {
                        $lookupIds['customer_id'][] = $val;
                    }
                }
                if ($key === 'province_id') $lookupIds['province_id'][] = $val;
                if ($key === 'customer_type_id') $lookupIds['customer_type_id'][] = $val;
                if ($key === 'source_id') $lookupIds['source_id'][] = $val;
                if ($key === 'product_categories_id') $lookupIds['product_categories_id'][] = $val;
                if ($key === 'showroom_id') $lookupIds['showroom_id'][] = $val;
                if (in_array($key, ['first_customer_status_id', 'current_customer_status_id', 'first_status_id'])) {
                    $lookupIds['customer_status_id'][] = $val;
                }
                if (in_array($key, ['sale_information_id', 'sale_support_id', 'created_by'])) {
                    $lookupIds['user_ids'][] = $val;
                }
                if ($key === 'support_channel_id') $lookupIds['support_channel_id'][] = $val;
            }
        }

        return [
            'customer_id'           => CustomerCode::whereIn('id', array_unique($lookupIds['customer_id']))->pluck('customer_code', 'id')->toArray(),
            'province_id'           => Province::whereIn('id', array_unique($lookupIds['province_id']))->pluck('name', 'id')->toArray(),
            'customer_type_id'      => CustomerType::whereIn('id', array_unique($lookupIds['customer_type_id']))->pluck('name', 'id')->toArray(),
            'source_id'             => CustomerSource::whereIn('id', array_unique($lookupIds['source_id']))->pluck('name', 'id')->toArray(),
            'product_categories_id' => ProductCategory::whereIn('id', array_unique($lookupIds['product_categories_id']))->pluck('name', 'id')->toArray(),
            'showroom_id'           => Showroom::whereIn('id', array_unique($lookupIds['showroom_id']))->pluck('name', 'id')->toArray(),
            'customer_status_id'    => CustomerStatus::whereIn('id', array_unique($lookupIds['customer_status_id']))->pluck('name', 'id')->toArray(),
            'users'                 => User::whereIn('id', array_unique($lookupIds['user_ids']))->pluck('name', 'id')->toArray(),
            'support_channel_id'    => SupportChannel::whereIn('id', array_unique($lookupIds['support_channel_id']))->pluck('name', 'id')->toArray(),
        ];
    }
}