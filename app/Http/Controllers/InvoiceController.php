<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Lead;
use App\Models\Showroom;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
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
        $showrooms = Showroom::orderBy('name')->get();

        return view('invoices.index', [
            'invoices' => $invoices,
            'showrooms' => $showrooms,
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
        $showrooms = Showroom::orderBy('name')->get();

        return view('invoices.create', [
            'lead' => $lead,
            'products' => $products,
            'showrooms' => $showrooms,
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
            'showroom_id' => ['required','exists:showrooms,id',],

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
            $invoice->showroom_id      = $validated['showroom_id'] ?? null;
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
            'showroom',
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

    public function edit(Invoice $invoice)
    {
        Gate::authorize('update', $invoice);

        $invoice->load('items');

        // Nếu create() có lọc theo tài khoản/chi nhánh,
        // dùng lại đúng điều kiện lọc đó tại đây.
        $products = Product::query()
            ->orderBy('name')
            ->get();

        $showrooms = Showroom::query()
            ->orderBy('name')
            ->get();

        return view('invoices.edit', compact(
            'invoice',
            'products',
            'showrooms'
        ));
    }
    public function updateDetails(Request $request, Invoice $invoice)
    {
        Gate::authorize('update', $invoice);

        // Dùng cùng phạm vi showroom được phép chọn như create().
        $showrooms = Showroom::query()
            ->orderBy('name')
            ->get();

        $data = $request->validate([
            'invoice_version' => [
                'nullable',
                'string',
                'max:100',
            ],

            'lead_id' => [
                'nullable',
                'integer',
                'exists:leads,id',
            ],

            'sale_name' => [
                'required',
                'string',
                'max:255',
            ],

            'showroom_id' => [
                'required',
                Rule::in($showrooms->modelKeys()),
            ],

            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'customer_phone' => [
                'required',
                'string',
                'max:50',
            ],

            'customer_address' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'note' => [
                'nullable',
                'string',
                'max:5000',
            ],

            // Tên input lấy theo view edit mới.
            'discount_amount' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999999',
            ],

            'other_discount' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999999',
            ],

            'deposit_amount' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999999',
            ],

            'other_fee' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999999',
            ],

            'deposit_type' => [
                'required',
                Rule::in([
                    'Chuyển khoản',
                    'Tiền mặt',
                    'Quẹt thẻ',
                    'Trống',
                ]),
            ],

            'items' => [
                'required',
                'array',
                'min:1',
                'max:200',
            ],

            'items.*.id' => [
                'nullable',
                'integer',
                'distinct',
            ],

            'items.*.product_id' => [
                'required',
                'integer',
            ],

            'items.*.quantity' => [
                'required',
                'numeric',
                'min:0.01',
                'max:1000000',
                'regex:/^\d+(?:\.\d{1,2})?$/',
            ],

            // Giá gửi từ form chỉ phục vụ khôi phục giao diện.
            // Khi lưu sẽ lấy giá từ database.
            'items.*.unit_price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999999999',
            ],
        ]);

        DB::transaction(function () use ($invoice, $data) {
            $lockedInvoice = Invoice::query()
                ->whereKey($invoice->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            Gate::authorize('update', $lockedInvoice);

            /*
            * Tránh lưu đè khi hóa đơn đã thay đổi
            * kể từ lúc mở trang chỉnh sửa.
            */
            $currentVersion = $lockedInvoice->updated_at
                ?->format('Y-m-d H:i:s.u');

            if (
                ($data['invoice_version'] ?? null)
                !== $currentVersion
            ) {
                throw ValidationException::withMessages([
                    'invoice_version' =>
                        'Hóa đơn đã thay đổi. Vui lòng mở lại trang chỉnh sửa trước khi lưu.',
                ]);
            }

            $existingItems = $lockedInvoice->items()
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            /*
            * Dùng cùng điều kiện lọc sản phẩm như create()/store().
            */
            $products = Product::query()
                ->whereIn(
                    'id',
                    collect($data['items'])
                        ->pluck('product_id')
                        ->unique()
                        ->all()
                )
                ->get()
                ->keyBy('id');

            $subtotal = 0;
            $keepIds = [];

            foreach ($data['items'] as $index => $row) {
                $item = null;

                /*
                * Dòng cũ phải thuộc hóa đơn hiện tại.
                */
                if (!empty($row['id'])) {
                    $item = $existingItems->get($row['id']);

                    if (!$item) {
                        throw ValidationException::withMessages([
                            "items.$index.product_id" =>
                                'Sản phẩm không thuộc hóa đơn này.',
                        ]);
                    }
                }

                $sameProduct = $item
                    && (string) $item->product_id
                        === (string) $row['product_id'];

                if ($sameProduct) {
                    /*
                    * Giữ giá và tên đã lưu của sản phẩm cũ.
                    */
                    $unitPrice = (float) $item->unit_price;

                    $productName = $item->product_name;
                } else {
                    /*
                    * Thêm mới hoặc đổi sản phẩm:
                    * lấy tên và giá từ database.
                    */
                    $product = $products->get($row['product_id']);

                    if (!$product) {
                        throw ValidationException::withMessages([
                            "items.$index.product_id" =>
                                'Sản phẩm không tồn tại hoặc không còn được phép chọn.',
                        ]);
                    }

                    $unitPrice = (float) $product->price;

                    $productName = $product->name;
                }

                if (
                    !is_finite($unitPrice)
                    || $unitPrice < 0
                ) {
                    throw ValidationException::withMessages([
                        "items.$index.product_id" =>
                            'Đơn giá sản phẩm không hợp lệ.',
                    ]);
                }

                $quantity = round(
                    (float) $row['quantity'],
                    2
                );

                $lineTotal = round(
                    $quantity * $unitPrice,
                    0
                );

                if (!$item) {
                    $item = $lockedInvoice->items()->make();
                }

                $item->product_id = $row['product_id'];
                $item->product_name = $productName;
                $item->quantity = $quantity;
                $item->unit_price = $unitPrice;
                $item->subtotal = $lineTotal;

                // Nếu dòng cũ có thêm cột total thì đồng bộ.
                if (array_key_exists('total', $item->getAttributes())) {
                    $item->total = $lineTotal;
                }

                $item->save();

                $keepIds[] = $item->getKey();

                $subtotal += $lineTotal;
            }

            /*
            * Xóa các dòng đã bị bỏ khỏi form.
            */
            $lockedInvoice->items()
                ->whereNotIn('id', $keepIds)
                ->delete();

            /*
            * Đổi tên input của view sang cột database đang dùng.
            */
            $discountManual = round(
                (float) $data['discount_amount'],
                0
            );

            $discountRetail = round(
                (float) $data['other_discount'],
                0
            );

            $discountTotal = $discountManual + $discountRetail;

            $deposit = round(
                (float) $data['deposit_amount'],
                0
            );

            $otherFee = round(
                (float) $data['other_fee'],
                0
            );

            $grandTotal = max(
                0,
                $subtotal - $discountTotal + $otherFee
            );

            /*
            * Thông tin khách hàng và hóa đơn.
            */
            $lockedInvoice->lead_id = $data['lead_id'] ?? null;
            $lockedInvoice->sale_name = $data['sale_name'];
            $lockedInvoice->showroom_id = $data['showroom_id'];

            $lockedInvoice->customer_name = $data['customer_name'];
            $lockedInvoice->customer_phone = $data['customer_phone'];
            $lockedInvoice->customer_address =
                $data['customer_address'] ?? null;

            $lockedInvoice->note = $data['note'] ?? null;

            /*
            * Các cột tiền đang dùng trong hàm cũ của bạn.
            */
            $lockedInvoice->subtotal = $subtotal;
            $lockedInvoice->discount_manual = $discountManual;
            $lockedInvoice->discount_retail = $discountRetail;
            $lockedInvoice->discount_total = $discountTotal;
            $lockedInvoice->deposit_amount = $deposit;
            $lockedInvoice->other_fee = $otherFee;
            $lockedInvoice->grand_total = $grandTotal;
            $lockedInvoice->remaining = max(0, $grandTotal - $deposit);

            /*
            * Đồng bộ các tên cột khác nếu database có dùng.
            */
            $optionalColumns = [
                'discount_amount' => $discountManual,
                'other_discount' => $discountRetail,

                'deposit' => $deposit,
                'advance_payment' => $deposit,

                'deposit_type' => $data['deposit_type'],
                'payment_method' => $data['deposit_type'],
            ];

            $attributes = $lockedInvoice->getAttributes();

            foreach ($optionalColumns as $column => $value) {
                if (array_key_exists($column, $attributes)) {
                    $lockedInvoice->{$column} = $value;
                }
            }

            if ($lockedInvoice->usesTimestamps()) {
                $lockedInvoice->setUpdatedAt(
                    $lockedInvoice->freshTimestamp()
                );
            }

            $lockedInvoice->save();

            /*
            * Nếu hệ thống đang quản lý tồn kho/công nợ,
            * bổ sung nghiệp vụ điều chỉnh tại đây
            * trong cùng transaction.
            */
        });

        return redirect()
            ->route('invoices.show', $invoice)
            ->with(
                'invoice_update_success',
                'Đã cập nhật hóa đơn thành công.'
            );
    }
}