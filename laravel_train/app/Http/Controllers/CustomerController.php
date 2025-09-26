<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Province;
use App\Models\TypeCustomer;
use App\Models\TypeShowroom;
use App\Models\Category;
use App\Models\Status;
use App\Models\Salename;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <- 📌 Chú ý: cần để dùng DB::transaction

class CustomerController extends Controller
{
    /**
     * Danh sách khách hàng
     */
    public function index(Request $request)
    {
        // Lấy danh sách status để hiển thị dropdown search
        $statusList = Status::all();

        // Bắt đầu query
        $query = Customer::with([
            'province',
            'typeCustomerYet',
            'typeCustomer',
            'typeShowroom',
            'category',
            'statusFirst',
            'currentStatus',
            'salenameInfor',
            'salenameSupport',
            'cateloryProduct',
            'source'
        ]);

        // Lọc theo status_first_id nếu có
        if ($request->filled('status_first_id')) {
            $query->where('status_first_id', $request->status_first_id);
        }

        // Lọc theo tên khách hàng nếu có
        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        // Lấy kết quả phân trang
        $customer = $query->latest()->paginate(20);

        // Giữ các tham số tìm kiếm khi phân trang
        $customer->appends($request->all());

        return view('customer.index', compact('customer', 'statusList'));
    }


    /**
     * Form thêm mới
     */
    public function create()
    {
        $provinces = Province::all();
        $typeCustomer = TypeCustomer::all();
        $typeShowroom = TypeShowroom::all();
        $category = Category::all();
        $status = Status::all();
        $salename = Salename::all();
        $source = Source::all();

        return view('customer.create', compact(
            'provinces',
            'typeCustomer',
            'typeShowroom',
            'category',
            'status',
            'salename',
            'source'
        ));
    }

    /**
     * Lưu mới
     */
    public function store(Request $request)
    {
        // 📌 Validation dữ liệu: bắt buộc đúng trước khi lưu
        $validatedData = $request->validate([
            'customer_for_showroom' => 'nullable|date',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'province_id' => 'nullable|exists:provinces,id',
            'address' => 'nullable|string',
            'zalo_feedback' => 'nullable|string|max:255',
            'type_customer_yet_id' => 'nullable|exists:type_customers,id',
            'type_customer_id' => 'nullable|exists:type_customers,id',
            'type_showroom_id' => 'nullable|exists:type_showrooms,id',
            'type_category_id' => 'nullable|exists:categories,id',
            'status_first_id' => 'nullable|exists:statuses,id',
            'note_sale' => 'nullable|string|max:255',
            'salename_infor_id' => 'nullable|exists:sale_names,id',
            'salename_support_id' => 'nullable|exists:sale_names,id',
            'current_status_id' => 'nullable|exists:statuses,id',
            'order_value' => 'nullable|numeric',
            'customer_support_yet_id' => 'nullable|exists:sources,id',
        ]);

        // 📌 Sử dụng Laravel Transaction tích hợp để rollback tự động khi lỗi
        DB::transaction(function () use ($validatedData) {
            Customer::create($validatedData); // ✅ Chỉ lưu khi dữ liệu hợp lệ
        });

        return redirect()->route('customer.index')->with('success', 'Thêm khách hàng thành công!');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(Customer $customer)
    {
        $provinces = Province::all();
        $typeCustomer = TypeCustomer::all();
        $typeShowroom = TypeShowroom::all();
        $category = Category::all();
        $status = Status::all();
        $salename = Salename::all();
        $source = Source::all();

        return view('customer.edit', compact(
            'customer',
            'provinces',
            'typeCustomer',
            'typeShowroom',
            'category',
            'status',
            'salename',
            'source'
        ));
    }

    /**
     * Cập nhật
     */
    public function update(Request $request, Customer $customer)
    {
        // 📌 Validation dữ liệu bắt buộc
        $validatedData = $request->validate([
            'customer_for_showroom' => 'required|date',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province_id' => 'nullable|exists:provinces,id',
            'address' => 'nullable|string',
            'zalo_feedback' => 'nullable|string|max:255',
            'type_customer_yet_id' => 'nullable|exists:type_customers,id',
            'type_customer_id' => 'nullable|exists:type_customers,id',
            'type_showroom_id' => 'nullable|exists:type_showrooms,id',
            'type_category_id' => 'nullable|exists:categories,id',
            'status_first_id' => 'nullable|exists:statuses,id',
            'note_sale' => 'nullable|string|max:255',
            'salename_infor_id' => 'nullable|exists:sale_names,id',
            'salename_support_id' => 'nullable|exists:sale_names,id',
            'current_status_id' => 'nullable|exists:statuses,id',
            'order_value' => 'nullable|numeric',
            'customer_support_yet_id' => 'nullable|exists:sources,id',
        ], [
            'customer_for_showroom.required' => 'Ngày không được để trống',
            'name.required' => 'Tên không được để trống',
            'phone.required' => 'Số Điện Thoại không được để trống',
        ]);

        // 📌 Transaction Laravel: đảm bảo rollback nếu lỗi
        DB::transaction(function () use ($validatedData, $customer) {
            $customer->update($validatedData); // ✅ Chỉ update khi dữ liệu hợp lệ
        });

        return redirect()
            ->route('customer.index')
            ->with('success', 'Cập nhật khách hàng thành công!');
    }

    /**
     * Xóa
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customer.index')->with('success', 'Xóa khách hàng thành công!');
    }
}
