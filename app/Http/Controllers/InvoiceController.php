<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Lead;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * DANH SÁCH HÓA ĐƠN
     */
    public function index()
    {
        $invoices = Invoice::with('lead')
            ->latest()
            ->paginate(30);

        return view('invoices.index', [
            'invoices' => $invoices,
        ]);
    }
    /**
     * FORM TẠO HÓA ĐƠN
     */
    public function create(Request $request)
    {
        $lead = null;

        if ($request->has('lead_id')) {
            $leadId = $request->input('lead_id');

            if (!empty($leadId)) {
                $lead = Lead::with('phones')->find($leadId);
            }
        }

        $products = Product::where('is_active', 1)
            ->orderBy('name', 'asc')
            ->get();

        return view('invoices.create', [
            'lead' => $lead,
            'products' => $products,
        ]);
    }

    /**
     * TÌM LEAD THEO SỐ ĐIỆN THOẠI (AJAX)
     */
    public function searchLeadsByPhone(Request $request)
    {
        $phone = trim($request->input('phone', ''));
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) < 6) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng nhập ít nhất 6 số.',
                'leads'   => [],
            ]);
        }

        $leads = Lead::with('phones')
            ->whereHas('phones', function ($query) use ($phone) {
                $query->where('phone', 'like', '%' . $phone . '%');
            })
            ->latest('id')
            ->limit(20)
            ->get();

        $data = [];

        foreach ($leads as $lead) {
            $phones = [];

            if ($lead->phones) {
                foreach ($lead->phones as $leadPhone) {
                    if (!empty($leadPhone->phone)) {
                        $phones[] = $leadPhone->phone;
                    }
                }
            }

            $name    = $lead->name ?? $lead->customer_name ?? '';
            $address = $lead->address ?? $lead->customer_address ?? '';

            $data[] = [
                'id'      => $lead->id,
                'name'    => $name,
                'phone'   => count($phones) > 0 ? $phones[0] : $phone,
                'phones'  => $phones,
                'address' => $address,
            ];
        }

        return response()->json([
            'success' => true,
            'count'   => count($data),
            'leads'   => $data,
        ]);
    }

    /**
     * LƯU HÓA ĐƠN (Xử lý lưu Chiết khấu & Chi phí hóa đơn)
     */
    public function store(Request $request)
    {
        // 1. Validate dữ liệu gửi lên từ Form
        $validated = $request->validate([
            'sale_name'        => 'nullable|string|max:255',
            'lead_id'          => 'nullable|integer|exists:leads,id',
            'customer_name'    => 'nullable|string|max:255',
            'customer_phone'   => 'nullable|string|max:50',
            'customer_address' => 'nullable|string',
            'note'             => 'nullable|string',

            // Nhận đúng biến từ Form create
            'discount_amount'  => 'nullable|numeric|min:0', // Chiết khấu (đ)
            'other_discount'   => 'nullable|numeric|min:0', // Chiết khấu khác (đ)
            'other_fee'        => 'nullable|numeric|min:0', // Phí khác (đ)
            'deposit_amount'   => 'nullable|numeric|min:0', // Tiền cọc (đ)
            'deposit_type'     => 'nullable|string|max:255',

            'items'            => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity'   => 'required|numeric|min:0.01',
        ]);

        // 2. SỬA DÒNG NÀY: Dùng find() thay vì findOrFail() để tránh dính 404
        $leadId = $validated['lead_id'] ?? null;
        $lead = $leadId ? Lead::with('phones')->find($leadId) : null;

        // Lấy giá trị chiết khấu từ Form
        $discountManual = (float) ($request->input('discount_amount') ?? $request->input('discount_manual') ?? 0);
        $discountRetail = (float) ($request->input('other_discount') ?? $request->input('discount_retail') ?? 0);
        $discountTotal  = $discountManual + $discountRetail;

        $otherFee      = (float) ($request->input('other_fee') ?? 0);
        $depositAmount = (float) ($request->input('deposit_amount') ?? 0);
        $depositType   = $request->input('deposit_type') ?? 'Chuyển khoản';

        DB::beginTransaction();

        try {
            $invoice = new Invoice();

            // Safe fallback nếu không có Lead
            $invoice->lead_id          = $lead ? $lead->id : null;
            $invoice->invoice_code     = $this->generateInvoiceCode();
            
            // Tự động fallback lấy thông tin từ Lead nếu Form không nhập
            $defaultPhone              = $lead && $lead->phones->isNotEmpty() ? $lead->phones->first()->phone : '';
            $invoice->customer_name    = $validated['customer_name'] ?? ($lead ? $lead->name : 'Khách lẻ');
            $invoice->customer_phone   = $validated['customer_phone'] ?? $defaultPhone;
            $invoice->customer_address = $validated['customer_address'] ?? ($lead ? $lead->address : '');

            // GÁN GIÁ TRỊ VÀO ĐÚNG CỘT TÊN TRONG DATABASE
            $invoice->discount_manual = $discountManual;
            $invoice->discount_retail = $discountRetail;
            $invoice->discount_total  = $discountTotal;

            $invoice->deposit_amount  = $depositAmount;
            $invoice->deposit_type    = $depositType;
            $invoice->other_fee       = $otherFee;

            $invoice->payment_method  = 'Chuyển khoản';
            $invoice->sale_name       = $validated['sale_name'] ?? (auth()->user()->name ?? 'N/A');
            $invoice->note            = $validated['note'] ?? null;

            $invoice->save();

            $invoiceSubtotal = 0;

            // Lưu danh sách sản phẩm
            foreach ($validated['items'] as $item) {
                $product   = Product::findOrFail($item['product_id']);
                $unitPrice = (float) $product->price;
                $quantity  = (float) $item['quantity'];
                $subtotal  = $unitPrice * $quantity;

                $invoiceItem = new InvoiceItem();
                $invoiceItem->invoice_id   = $invoice->id;
                $invoiceItem->product_id   = $product->id;
                $invoiceItem->product_name = $product->name;
                $invoiceItem->unit_price   = $unitPrice;
                $invoiceItem->quantity     = $quantity;
                $invoiceItem->subtotal     = $subtotal;
                $invoiceItem->total        = $subtotal;
                $invoiceItem->save();

                $invoiceSubtotal += $subtotal;
            }

            // Tính lại tổng tiền
            $grandTotalFinal = max($invoiceSubtotal - $discountTotal + $otherFee, 0);
            $remainingFinal  = max($grandTotalFinal - $depositAmount, 0);

            $invoice->subtotal    = $invoiceSubtotal;
            $invoice->grand_total = $grandTotalFinal;
            $invoice->remaining   = $remainingFinal;

            $invoice->save();

            DB::commit();

            return redirect()
                ->route('invoices.show', $invoice)
                ->with('success', 'Tạo hóa đơn thành công.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Không thể tạo hóa đơn: ' . $e->getMessage()]);
        }
    }

    /**
     * XEM HÓA ĐƠN
     */
    public function show(Invoice $invoice)
    {
        $invoice->load([
            'lead',
            'items.product',
        ]);

        return view('invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * IN HÓA ĐƠN
     */
    public function print(Invoice $invoice)
    {
        $invoice->load([
            'lead',
            'items.product',
        ]);

        return view('invoices.print', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * TẠO MÃ HÓA ĐƠN
     */
    private function generateInvoiceCode()
    {
        $prefix = 'HD' . date('ymd') . '-';

        $lastInvoice = Invoice::where('invoice_code', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        if (!$lastInvoice) {
            $number = 1;
        } else {
            $lastNumber = (int) substr($lastInvoice->invoice_code, -3);
            $number     = $lastNumber + 1;
        }

        return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}