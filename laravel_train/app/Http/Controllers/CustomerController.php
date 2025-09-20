<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Carbon\Carbon;
use Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        // [
        //     'customer_type_id': 1,
        //     'name': 'abc',
        // ]
        // $searchs = CustomerType::find($request->customer_type_id);
        // $users = User::latest()->paginate(10);

        // $users = User::with('CustomerType')
        //     ->latest()
        //     ->paginate(10);

        $statusList = ['Quan Tâm', 'Tiền Năng'];

        $customer = Customer::query();
        
        if($request->has('current_guest_status')) {
            $customer = $customer->where('current_guest_status', $request->current_guest_status);
        }
        if($request->has('customer_type_id')) {
            $customer = $customer->where('customer_type_id', $request->customer_type_id);
        }

        $customer = $customer->get();
        
        return view('customer.index', compact('customer', 'statusList'));
    }

    /**
     * Hiển thị form tạo user mới
     */
    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'name' => 'required|string',
            'phone' => 'required|string'
        ], [
            'start_date.required' => 'Ngày không được để trống',
            'name.required' => 'Tên không được để trống',
            'phone.required' => 'Số Điện Thoại không được để trống',
        ]);

        $customer = Customer::create([
            'start_date' => $request->start_date,
            'name' => $request->name,
            'phone' => $request->phone,
            'province' => $request->province,
            'address' => $request->address,
            'type_customer' => $request->type_customer,
            'page_source' => $request->page_source,
            'sale_product' => $request->sale_product,
            'first_guest_status' => $request->first_guest_status,
            'note' => $request->note,
            'sale_infor' => $request->sale_infor,
            'current_guest_status' => $request->current_guest_status,
            'information_exchange' => $request->information_exchange,
            'results' => $request->results,
            'take_care_guest_first_one' => $request->take_care_guest_first_one,
        ]);

        return redirect()->route('customer.index')->with('success', 'Tạo tài khoản thành công!');
    }

    /**
     * Hiển thị thông tin chi tiết của user
     */
    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    /**
     * Hiển thị form chỉnh sửa user
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }


     /**
     * Cập nhật thông tin user
     */
    public function update(Request $request, Customer $customer)
    {
         $request->validate([
            'start_date' => 'required|date',
            'name' => 'required|string',
            'phone' => 'required|string'
        ], [
            'start_date.required' => 'Ngày không được để trống',
            'name.required' => 'Tên không được để trống',
            'phone.required' => 'Số Điện Thoại không được để trống',
        ]);
        $customer->update([
            'start_date' => $request->start_date,
            'name' => $request->name,
            'phone' => $request->phone,
            'province' => $request->province,
            'address' => $request->address,
            'type_customer' => $request->type_customer,
            'page_source' => $request->page_source,
            'sale_product' => $request->sale_product,
            'first_guest_status' => $request->first_guest_status,
            'note' => $request->note,
            'sale_infor' => $request->sale_infor,
            'current_guest_status' => $request->current_guest_status,
            'information_exchange' => $request->information_exchange,
            'results' => $request->results,
            'take_care_guest_first_one' => $request->take_care_guest_first_one,
        ]);

        return redirect()->route('customer.index')->with('success', 'Cập nhật THÔNG TIN KHÁCH HÀNG thành công!');
    }

    /**
     * Xóa user
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customer.index')->with('success', 'Xóa Thông Tin khách hàng thành công!');
    }

    public function report(Request $request)
    {
        // Lấy tháng và năm từ request (nếu có), mặc định tháng hiện tại
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $start = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
        $end   = $start->copy()->endOfMonth();

        // Lấy dữ liệu thống kê
        $stats = \App\Models\Customer::selectRaw('DATE(start_date) as ngay, sale_infor as sale, current_guest_status as tinh_trang, COUNT(*) as so_luong')
            ->whereBetween('start_date', [$start, $end])
            ->groupBy('ngay', 'sale', 'tinh_trang')
            ->orderBy('ngay')
            ->get();

        // Tạo mảng ngày trong tháng
        $days = range(1, $end->day);

        // Xử lý pivot thành ma trận [sale][ngày][tình trạng]
        $report = [];
        foreach ($stats as $row) {
            $day = \Carbon\Carbon::parse($row->ngay)->day;
            $sale = $row->sale;
            $status = $row->tinh_trang;
            $report[$sale][$day][$status] = $row->so_luong;
        }

        return view('customer.report', compact('report', 'days', 'month', 'year'));

    }

    

}