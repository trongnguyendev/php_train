<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShowroomController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\CustomerStatusController;
use App\Http\Controllers\SaleUserController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\CustomerSourceController;
use App\Http\Controllers\CustomerTypeController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SupportChannelController;
use App\Http\Controllers\ReportDailyController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function (){
    if(auth()->check()) {
        return redirect()->route('users.index');
    }
    return redirect()->route('login');
})->name('dashboard');

Route::resource('showrooms', ShowroomController::class);
Route::resource('users', UserController::class);
Route::resource('product_categories', ProductCategoryController::class);
Route::resource('customer_status', CustomerStatusController::class);
Route::resource('sale_users', SaleUserController::class);
Route::resource('leads', LeadController::class);
Route::resource('customer_sources', CustomerSourceController::class);
Route::resource('customer_types', CustomerTypeController::class);
Route::resource('provinces', ProvinceController::class);

// Role and Permission routes

Route::resource('support-channels', SupportChannelController::class);
Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class)->only(['index', 'show']);

// User role assignment routes
Route::get('users/{user}/assign-roles', [UserController::class, 'assignRoles'])->name('users.assign-roles');
Route::put('users/{user}/sync-roles', [UserController::class, 'syncRoles'])->name('users.sync-roles');


Route::post('/lead/update-inline/{id}', [LeadController::class, 'updateInline']);
Route::post('/lead-take-care/update-inline/{id?}', [App\Http\Controllers\LeadTakeCareController::class, 'updateInline']);
Route::get('/lead/get-categories/{id}', [LeadController::class, 'getCategories']);
Route::post('/lead/update-categories/{id}', [LeadController::class, 'updateCategories']);
Route::match(['get','post'], '/report_daily', [ReportDailyController::class, 'exportDaily'])
    ->name('report_daily.index');
Route::match(['get','post'], '/report_month', [ReportDailyController::class, 'exportCurrentMonth'])
    ->name('report_month.index');
Route::match(['get','post'], '/report_showroom', [ReportDailyController::class, 'reportShowroom'])
    ->name('report_showroom.index');

Route::match(['get','post'], '/potential', [ReportDailyController::class, 'Potential'])
    ->name('potential.index');


    use App\Models\Lead;
use App\Models\CustomerCode;
use Illuminate\Support\Facades\DB;

Route::get('/migrate-customer-data', function () {
    // 1. Lấy toàn bộ các đơn hàng (leads) đang có giá trị customer_code chữ cũ
    $leads = DB::table('leads')->get();
    
    $count = 0;
    
    DB::beginTransaction();
    try {
        foreach ($leads as $lead) {
            // Nếu đơn hàng này có mã chữ cũ (ví dụ: C020626001)
            if (!empty($lead->customer_code)) {
                
                // 2. Kiểm tra xem mã chữ này đã tồn tại bên bảng customer_codes chưa
                // Nếu chưa có thì tạo mới, nếu có rồi (khách cũ tạo đơn thứ 2) thì lấy lại bản ghi đó
                $customer = CustomerCode::firstOrCreate([
                    'customer_code' => $lead->customer_code
                ]);

                // 3. Tính toán mã đơn hàng (order_code) mới dựa trên mã khách
                // Đếm xem khách hàng này đã có bao nhiêu đơn được xử lý trước đó trong vòng lặp rồi
                $orderCount = DB::table('leads')
                    ->where('customer_id', $customer->id)
                    ->count();
                
                // Tạo đuôi tăng dần theo khách (Ví dụ: C020626001-01 hoặc C020626001001 tùy bạn muốn nối dấu gạch hay không)
                $newOrderCode = $customer->customer_code . str_pad($orderCount + 1, 2, '0', STR_PAD_LEFT);

                // 4. Cập nhật lại vào bảng leads (Gán ID mới và đổi order_code)
                DB::table('leads')
                    ->where('id', $lead->id)
                    ->update([
                        'customer_id' => $customer->id,
                        'order_code'  => $newOrderCode
                    ]);

                $count++;
            }
        }
        
        DB::commit();
        return "Đã chuyển đổi thành công cấu trúc cho " . $count . " đơn hàng cũ!";
    } catch (\Exception $e) {
        DB::rollBack();
        return "Gặp lỗi trong quá trình chuyển đổi: " . $e->getMessage();
    }
});

Route::get('/report-daily/export-excel', [ReportDailyController::class, 'exportExcel'])
    ->name('report_daily.exportExcel');


Route::get('/report-month', [ReportDailyController::class, 'exportCurrentMonth'])
    ->name('report.month');

Route::get('/report-month/export', [ReportDailyController::class, 'exportCurrentMonthExcel'])
    ->name('report.month.export');

Route::get('/report-showroom/export',[ReportDailyController::class, 'exportShowroomExcel'])  
    ->name('report_showroom.export');
// Tải data
Route::get(
    '/reports/data-export-excel',
    [ReportDailyController::class, 'dataExportExcel']
)->name('reports.dataExportExcel');
