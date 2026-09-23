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
use App\Models\Phone;
use App\Models\LeadProductCategory;
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

        // 2. Phân trang
        $auditLogs = $query
            ->latest()
            ->paginate(30)
            ->withQueryString();

        // 3. Xây dựng danh sách ID -> Tên
        $maps = $this->buildLookupMaps($auditLogs);

        // 4. Danh sách nhân viên filter
        $users = User::pluck('name', 'id');

        return view('audit_logs.index', compact(
            'auditLogs',
            'maps',
            'users'
        ));
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

        // Áp dụng filter
        $this->applyFilters($query, $request);

        // Lấy toàn bộ lịch sử của Lead
        $auditLogs = $query
            ->orderBy('created_at', 'desc')
            ->get();

        // Map ID -> Tên
        $maps = $this->buildLookupMaps($auditLogs);

        // Danh sách nhân viên
        $users = User::pluck('name', 'id');

        return view('audit_logs.index', compact(
            'auditLogs',
            'maps',
            'users',
            'lead'
        ));
    }


    /**
     * Áp dụng điều kiện lọc
     */
    

    
   
private function applyFilters(
        $query,
        Request $request
    ) {

        /*
        |--------------------------------------------------------------------------
        | 1. NGƯỜI SỬA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('user_id')) {

            $query->where(
                'user_id',
                $request->user_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 2. HÀNH ĐỘNG
        |--------------------------------------------------------------------------
        |
        | created
        | updated
        | deleted
        |
        */

        if ($request->filled('customer_code')) {
            $keyword = trim($request->customer_code);

            $query->whereHas('auditable', function ($q) use ($keyword) {
                $q->whereHas('customerCode', function ($q2) use ($keyword) {
                    $q2->where('customer_code', 'like', '%' . $keyword . '%');
                });
            });
        }

        if ($request->filled('phone')) {
            $keyword = trim($request->phone);

            $query->whereHas('auditable', function ($q) use ($keyword) {
                $q->whereHas('phones', function ($q2) use ($keyword) {
                    $q2->where('phone', 'like', '%' . $keyword . '%');
                });
            });
        }


        /*
        |--------------------------------------------------------------------------
        | 3. TỪ NGÀY
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 4. ĐẾN NGÀY
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_to')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 5. NGUỒN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('source_id')) {

            $sourceId = $request->source_id;

            $query->where(function ($q) use ($sourceId) {

                $q->where(
                    'new_values->source_id',
                    $sourceId
                )

                ->orWhere(
                    'old_values->source_id',
                    $sourceId
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | 6. SHOWROOM
        |--------------------------------------------------------------------------
        */

        if ($request->filled('showroom_id')) {

            $showroomId = $request->showroom_id;

            $query->where(function ($q) use ($showroomId) {

                $q->where(
                    'new_values->showroom_id',
                    $showroomId
                )

                ->orWhere(
                    'old_values->showroom_id',
                    $showroomId
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | 7. LOẠI LEAD
        |--------------------------------------------------------------------------
        |
        | 1 = Trực tiếp
        | 2 = Online
        |
        */

        if ($request->filled('lead_type')) {

            $leadType = $request->lead_type;

            $query->where(function ($q) use ($leadType) {

                $q->where(
                    'new_values->lead_type',
                    $leadType
                )

                ->orWhere(
                    'old_values->lead_type',
                    $leadType
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | 8. LOẠI KHÁCH HÀNG
        |--------------------------------------------------------------------------
        */

        if ($request->filled('customer_type_id')) {

            $customerTypeId =
                $request->customer_type_id;

            $query->where(function ($q) use ($customerTypeId) {

                $q->where(
                    'new_values->customer_type_id',
                    $customerTypeId
                )

                ->orWhere(
                    'old_values->customer_type_id',
                    $customerTypeId
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | 9. KÊNH HỖ TRỢ
        |--------------------------------------------------------------------------
        */

        if ($request->filled('support_channel_id')) {

            $supportChannelId =
                $request->support_channel_id;

            $query->where(function ($q) use ($supportChannelId) {

                $q->where(
                    'new_values->support_channel_id',
                    $supportChannelId
                )

                ->orWhere(
                    'old_values->support_channel_id',
                    $supportChannelId
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | 10. TÌNH TRẠNG KHÁCH HÀNG
        |--------------------------------------------------------------------------
        |
        | Kiểm tra cả:
        |
        | current_customer_status_id
        | first_customer_status_id
        |
        */

        if ($request->filled('customer_status_id')) {

            $customerStatusId =
                $request->customer_status_id;

            $query->where(function ($q) use ($customerStatusId) {

                $q->where(
                    'new_values->current_customer_status_id',
                    $customerStatusId
                )

                ->orWhere(
                    'old_values->current_customer_status_id',
                    $customerStatusId
                )

                ->orWhere(
                    'new_values->first_customer_status_id',
                    $customerStatusId
                )

                ->orWhere(
                    'old_values->first_customer_status_id',
                    $customerStatusId
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | 11. DANH MỤC SẢN PHẨM
        |--------------------------------------------------------------------------
        */

        if ($request->filled('product_categories_id')) {

            $productCategoryId =
                $request->product_categories_id;

            $query->where(function ($q) use ($productCategoryId) {

                /*
                | Trường hợp:
                |
                | "product_categories_id": 5
                |
                */

                $q->where(
                    'new_values->product_categories_id',
                    $productCategoryId
                )

                ->orWhere(
                    'old_values->product_categories_id',
                    $productCategoryId
                )

                /*
                | Trường hợp:
                |
                | "product_categories_id": [1,2,5]
                |
                */

                ->orWhereJsonContains(
                    'new_values->product_categories_id',
                    $productCategoryId
                )

                ->orWhereJsonContains(
                    'old_values->product_categories_id',
                    $productCategoryId
                );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | 12. TÌM KIẾM CHUNG
        |--------------------------------------------------------------------------
        |
        | Tìm trong:
        |
        | old_values
        | new_values
        |
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );


            if ($search !== '') {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'old_values',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'new_values',
                        'like',
                        '%' . $search . '%'
                    );
                });
            }
        }


        /*
        |--------------------------------------------------------------------------
        | 13. TRẢ QUERY
        |--------------------------------------------------------------------------
        */

        return $query;
    }


    /**
     * ==========================================================
     * BUILD LOOKUP MAPS
     * ==========================================================
     *
     * Chuyển:
     *
     * ID -> Tên
     *
     * Riêng lead_product_category:
     *
     * audit_logs
     *      ↓
     * lead_product_category.id
     *      ↓
     * product_categories_id
     *      ↓
     * product_categories.name
     */
    private function buildLookupMaps($auditLogs)
    {
        /**
         * ======================================================
         * 1. Gom tất cả ID từ AuditLog
         * ======================================================
         */
        $lookupIds = [

            'customer_id' => [],

            'province_id' => [],

            'customer_type_id' => [],

            'source_id' => [],

            // ID của lead_product_category
            'lead_product_category_id' => [],

            // ID của product_categories
            'product_categories_id' => [],

            'showroom_id' => [],

            'customer_status_id' => [],

            'user_ids' => [],

            'support_channel_id' => [],
        ];


        /**
         * ======================================================
         * 2. Đọc old_values + new_values
         * ======================================================
         */
        foreach ($auditLogs as $log) {

            $oldValues = $log->old_values ?? [];
            $newValues = $log->new_values ?? [];

            $changes = array_merge(
                $oldValues,
                $newValues
            );


            foreach ($changes as $key => $val) {

                /**
                 * Bỏ qua null / rỗng
                 */
                if (
                    $val === null ||
                    $val === ''
                ) {
                    continue;
                }


                /**
                 * ==================================================
                 * CUSTOMER
                 * ==================================================
                 */
                if ($key === 'customer_id') {

                    if (is_array($val)) {

                        $lookupIds['customer_id'] = array_merge(
                            $lookupIds['customer_id'],
                            $val
                        );

                    } else {

                        $lookupIds['customer_id'][] = $val;
                    }
                }


                /**
                 * ==================================================
                 * PROVINCE
                 * ==================================================
                 */
                if ($key === 'province_id') {

                    if (is_array($val)) {

                        $lookupIds['province_id'] = array_merge(
                            $lookupIds['province_id'],
                            $val
                        );

                    } else {

                        $lookupIds['province_id'][] = $val;
                    }
                }


                /**
                 * ==================================================
                 * CUSTOMER TYPE
                 * ==================================================
                 */
                if ($key === 'customer_type_id') {

                    if (is_array($val)) {

                        $lookupIds['customer_type_id'] = array_merge(
                            $lookupIds['customer_type_id'],
                            $val
                        );

                    } else {

                        $lookupIds['customer_type_id'][] = $val;
                    }
                }


                /**
                 * ==================================================
                 * SOURCE
                 * ==================================================
                 */
                if ($key === 'source_id') {

                    if (is_array($val)) {

                        $lookupIds['source_id'] = array_merge(
                            $lookupIds['source_id'],
                            $val
                        );

                    } else {

                        $lookupIds['source_id'][] = $val;
                    }
                }


                /**
                 * ==================================================
                 * LEAD PRODUCT CATEGORY
                 *
                 * Audit đang lưu:
                 *
                 * lead_product_category_id
                 *
                 * ==================================================
                 */
                if ($key === 'lead_product_category_id') {

                    if (is_array($val)) {

                        $lookupIds['lead_product_category_id'] =
                            array_merge(
                                $lookupIds['lead_product_category_id'],
                                $val
                            );

                    } else {

                        $lookupIds['lead_product_category_id'][] = $val;
                    }
                }


                /**
                 * ==================================================
                 * PRODUCT CATEGORY
                 *
                 * Trường hợp AuditLog lưu trực tiếp
                 * product_categories_id
                 * ==================================================
                 */
             
        if ($key === 'product_categories_id') {
            if (is_array($val)) {
                $lookupIds['product_categories_id'] = array_merge(
                    $lookupIds['product_categories_id'],
                    $val
                );
            } else {
                $lookupIds['product_categories_id'][] = $val;
            }
        }

                /**
                 * ==================================================
                 * SHOWROOM
                 * ==================================================
                 */
                if ($key === 'showroom_id') {

                    if (is_array($val)) {

                        $lookupIds['showroom_id'] = array_merge(
                            $lookupIds['showroom_id'],
                            $val
                        );

                    } else {

                        $lookupIds['showroom_id'][] = $val;
                    }
                }


                /**
                 * ==================================================
                 * CUSTOMER STATUS
                 * ==================================================
                 */
                if (
                    in_array(
                        $key,
                        [
                            'first_customer_status_id',
                            'current_customer_status_id',
                            'first_status_id',
                        ],
                        true
                    )
                ) {

                    if (is_array($val)) {

                        $lookupIds['customer_status_id'] =
                            array_merge(
                                $lookupIds['customer_status_id'],
                                $val
                            );

                    } else {

                        $lookupIds['customer_status_id'][] = $val;
                    }
                }


                /**
                 * ==================================================
                 * USER
                 * ==================================================
                 */
                if (
                    in_array(
                        $key,
                        [
                            'sale_information_id',
                            'sale_support_id',
                            'created_by',
                        ],
                        true
                    )
                ) {

                    if (is_array($val)) {

                        $lookupIds['user_ids'] =
                            array_merge(
                                $lookupIds['user_ids'],
                                $val
                            );

                    } else {

                        $lookupIds['user_ids'][] = $val;
                    }
                }


                /**
                 * ==================================================
                 * SUPPORT CHANNEL
                 * ==================================================
                 */
                if ($key === 'support_channel_id') {

                    if (is_array($val)) {

                        $lookupIds['support_channel_id'] =
                            array_merge(
                                $lookupIds['support_channel_id'],
                                $val
                            );

                    } else {

                        $lookupIds['support_channel_id'][] = $val;
                    }
                }
            }
        }


        /**
         * ======================================================
         * 3. Loại ID trùng + loại giá trị rỗng
         * ======================================================
         */
        foreach ($lookupIds as $key => $ids) {

            $lookupIds[$key] = array_values(
                array_unique(
                    array_filter(
                        $ids,
                        fn ($id) =>
                            $id !== null &&
                            $id !== ''
                    )
                )
            );
        }


        /**
         * ======================================================
         * 4. MAP CUSTOMER
         * ======================================================
         */
        $customerMap = [];

        if (!empty($lookupIds['customer_id'])) {

            $customerMap = CustomerCode::whereIn(
                'id',
                $lookupIds['customer_id']
            )
            ->pluck(
                'customer_code',
                'id'
            )
            ->toArray();
        }


        /**
         * ======================================================
         * 5. MAP PROVINCE
         * ======================================================
         */
        $provinceMap = [];

        if (!empty($lookupIds['province_id'])) {

            $provinceMap = Province::whereIn(
                'id',
                $lookupIds['province_id']
            )
            ->pluck(
                'name',
                'id'
            )
            ->toArray();
        }


        /**
         * ======================================================
         * 6. MAP CUSTOMER TYPE
         * ======================================================
         */
        $customerTypeMap = [];

        if (!empty($lookupIds['customer_type_id'])) {

            $customerTypeMap = CustomerType::whereIn(
                'id',
                $lookupIds['customer_type_id']
            )
            ->pluck(
                'name',
                'id'
            )
            ->toArray();
        }


        /**
         * ======================================================
         * 7. MAP SOURCE
         * ======================================================
         */
        $sourceMap = [];

        if (!empty($lookupIds['source_id'])) {

            $sourceMap = CustomerSource::whereIn(
                'id',
                $lookupIds['source_id']
            )
            ->pluck(
                'name',
                'id'
            )
            ->toArray();
        }


        /**
         * ======================================================
         * 8. MAP LEAD PRODUCT CATEGORY
         *
         * Đây là phần bạn đang cần.
         *
         * lead_product_category.id
         *          ↓
         * product_categories_id
         * ======================================================
         */
        $leadProductCategoryMap = [];

        if (!empty($lookupIds['lead_product_category_id'])) {

            $leadProductCategoryMap =
                LeadProductCategory::whereIn(
                    'id',
                    $lookupIds['lead_product_category_id']
                )
                ->pluck(
                    'product_categories_id',
                    'id'
                )
                ->toArray();
        }


        /**
         * ======================================================
         * 9. Gom thêm product_categories_id
         *
         * Bao gồm:
         *
         * - ID lấy trực tiếp từ AuditLog
         * - ID lấy qua lead_product_category
         * ======================================================
         */
        $productCategoryIds =
            array_merge(
                $lookupIds['product_categories_id'],
                array_values($leadProductCategoryMap)
            );

        $productCategoryIds = array_values(
            array_unique(
                array_filter(
                    $productCategoryIds,
                    fn ($id) =>
                        $id !== null &&
                        $id !== ''
                )
            )
        );


        /**
         * ======================================================
         * 10. MAP PRODUCT CATEGORY
         * ======================================================
         */
        $productCategoryMap = [];

        if (!empty($lookupIds['product_categories_id'])) {

            $productCategoryMap = ProductCategory::whereIn(
                'id',
                array_unique($lookupIds['product_categories_id'])
            )
            ->pluck(
                'name',
                'id'
            )
            ->toArray();
        }
        
            $productCategoryMap = ProductCategory::whereIn('id', $productCategoryIds)
                ->pluck('name', 'id')
                ->toArray();

        /**
         * ======================================================
         * 11. MAP SHOWROOM
         * ======================================================
         */
        $showroomMap = [];

        if (!empty($lookupIds['showroom_id'])) {

            $showroomMap = Showroom::whereIn(
                'id',
                $lookupIds['showroom_id']
            )
            ->pluck(
                'name',
                'id'
            )
            ->toArray();
        }


        /**
         * ======================================================
         * 12. MAP PHONE
         * ======================================================
         */
        $phoneMap = [];

        if (!empty($lookupIds['customer_id'])) {

            $phoneMap = Phone::whereIn(
                'lead_id',
                $lookupIds['customer_id']
            )
            ->pluck(
                'phone',
                'lead_id'
            )
            ->toArray();
        }


        /**
         * ======================================================
         * 13. MAP CUSTOMER STATUS
         * ======================================================
         */
        $customerStatusMap = [];

        if (!empty($lookupIds['customer_status_id'])) {

            $customerStatusMap =
                CustomerStatus::whereIn(
                    'id',
                    $lookupIds['customer_status_id']
                )
                ->pluck(
                    'name',
                    'id'
                )
                ->toArray();
        }


        /**
         * ======================================================
         * 14. MAP USER
         * ======================================================
         */
        $userMap = [];

        if (!empty($lookupIds['user_ids'])) {

            $userMap = User::whereIn(
                'id',
                $lookupIds['user_ids']
            )
            ->pluck(
                'name',
                'id'
            )
            ->toArray();
        }


        /**
         * ======================================================
         * 15. MAP SUPPORT CHANNEL
         * ======================================================
         */
        $supportChannelMap = [];

        if (!empty($lookupIds['support_channel_id'])) {

            $supportChannelMap =
                SupportChannel::whereIn(
                    'id',
                    $lookupIds['support_channel_id']
                )
                ->pluck(
                    'name',
                    'id'
                )
                ->toArray();
        }


        /**
         * ======================================================
         * 16. Trả toàn bộ maps về View
         * ======================================================
         */
        return [

            'customer_id' =>
                $customerMap,

            'province_id' =>
                $provinceMap,

            'customer_type_id' =>
                $customerTypeMap,

            'source_id' =>
                $sourceMap,

            // ID trực tiếp của product_categories
            'product_categories_id' =>
                $productCategoryMap,

            // ID của lead_product_category
            //
            // Ví dụ:
            // 25 => 5
            //
            // nghĩa là:
            // lead_product_category.id = 25
            // product_categories_id = 5
            'lead_product_category_id' =>
                $leadProductCategoryMap,

            'showroom_id' =>
                $showroomMap,

            'phones' =>
                $phoneMap,

            'customer_status_id' =>
                $customerStatusMap,

            'users' =>
                $userMap,

            'support_channel_id' =>
                $supportChannelMap,
            
            'lead_take_'
        ];
    }
}