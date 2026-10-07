<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa đơn {{ $invoice->invoice_code }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            margin: 0;
            padding: 0;
            background: #fff;
            color: #000;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }

        .invoice {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
        }

        /* HEADER */
        .header {
            position: relative;
            min-height: 190px;
            margin-bottom: 20px;
        }

        .header-left {
            width: 55%;
            float: left;
            line-height: 1.45;
        }

        .logo {
            max-height: 55px;
            margin-bottom: 8px;
            display: block;
        }

        .header-right {
            width: 45%;
            float: right;
            text-align: right;
            padding-top: 5px;
        }

        .clear {
            clear: both;
        }

        .invoice-title {
            font-size: 26px;
            font-weight: bold;
            color: #00008b;
            text-align: right;
            margin-bottom: 25px;
            letter-spacing: 0.5px;
        }

        .date {
            font-style: italic;
            font-weight: bold;
            color: #0000cd;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .invoice-number {
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 6px;
        }

        .showroom {
            font-weight: bold;
            font-size: 14px;
        }

        .region-title {
            font-weight: bold;
            font-size: 13px;
        }

        .hotline {
            font-weight: bold;
            margin-top: 4px;
        }

        /* CUSTOMER */
        .customer-info {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .customer-row {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }

        .customer-label {
            display: table-cell;
            width: 130px;
            font-weight: bold;
            font-size: 14px;
            vertical-align: top;
        }

        .customer-value {
            display: table-cell;
            font-weight: bold;
            font-size: 14px;
            vertical-align: top;
        }

        /* PRODUCT TABLE */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .product-table th,
        .product-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .product-table th {
            text-align: center;
            font-weight: bold;
            height: 32px;
            font-size: 13px;
        }

        .col-stt { width: 6%; }
        .col-product { width: 54%; }
        .col-quantity { width: 10%; }
        .col-price { width: 15%; }
        .col-total { width: 15%; }

        .center { text-align: center; }
        .right { text-align: right; }
        .product-name { text-align: left; }

        /* SUMMARY */
        .summary-wrapper {
            width: 100%;
            margin-top: 15px;
            display: table;
            table-layout: fixed;
        }

        .summary-note {
            display: table-cell;
            width: 60%;
            vertical-align: top;
            padding-right: 15px;
        }

        .summary-box {
            display: table-cell;
            width: 40%;
            vertical-align: top;
        }

        .summary-row {
            display: table;
            width: 100%;
            margin-bottom: 4px;
        }

        .summary-label {
            display: table-cell;
            width: 55%;
            padding: 3px 0;
            text-align: right;
            font-weight: bold;
        }

        .summary-value {
            display: table-cell;
            width: 45%;
            padding: 3px 0;
            text-align: right;
            font-weight: bold;
        }

        .amount-word {
            margin-top: 45px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 13px;
        }

        /* SIGNATURE */
        .signature {
            width: 100%;
            margin-top: 40px;
            display: table;
            table-layout: fixed;
            text-align: center;
        }

        .signature-column {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .signature-title {
            font-weight: bold;
            font-size: 14px;
        }

        .signature-note {
            margin-top: 4px;
            font-size: 13px;
        }

        .signature-space {
            height: 110px;
        }

        .sale-name {
            font-weight: bold;
            font-size: 14px;
        }

        /* PRINT BUTTON */
        .no-print {
            text-align: center;
            margin-top: 25px;
        }

        .print-button {
            border: none;
            background: #173b76;
            color: #fff;
            padding: 10px 22px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        @media print {
            body { padding: 0; margin: 0; }
            .invoice { max-width: none; width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>

<body>

<div class="invoice">

    {{-- HEADER --}}
    <div class="header">
        <div class="header-left">
            <img src="{{ route('drive.image', ['id' => '16WjkiyytGbGWOAZ7B5fDH2PHLe3OS2Qw']) }}" alt="Chilux Logo" class="logo">

            <div class="region-title">🏢 Miền Nam:</div>
            <div>- 19 Đinh Thị Thi, Khu đô thị Vạn Phúc, Thủ Đức, TP.HCM</div>
            <div>- Lầu 2, 208 đường Cô Bắc, phường Cô Giang, Quận 1, TP. HCM</div>
            <div>- Số 685 Đại lộ Bình Dương, Hiệp Thành, Thủ Dầu Một, Bình Dương</div>

            <div class="region-title" style="margin-top: 4px;">🏢 Miền Bắc:</div>
            <div>- 502 Xã Đàn, phường Nam Đồng, Quận Đống Đa, Hà Nội</div>

            <div class="hotline">☎ Tổng đài CSKH: 1900 8668 92</div>
        </div>

        <div class="header-right">
            <div class="invoice-title">HÓA ĐƠN BÁN HÀNG</div>
            <div class="date">
                Ngày {{ $invoice->created_at ? $invoice->created_at->format('d') : date('d') }} Tháng {{ $invoice->created_at ? $invoice->created_at->format('m') : date('m') }} Năm {{ $invoice->created_at ? $invoice->created_at->format('Y') : date('Y') }}
            </div>
            <div class="invoice-number">Số: {{ $invoice->invoice_code }}</div>
            <div class="showroom">
                {{ $invoice->showroom->name ?? 'Chưa chọn showroom' }}
            </div>
        </div>

        <div class="clear"></div>
    </div>

    {{-- CUSTOMER INFO --}}
    <div class="customer-info">
        <div class="customer-row">
            <div class="customer-label">Tên Khách Hàng:</div>
            <div class="customer-value">{{ $invoice->customer_name ?: '................................................' }}</div>
        </div>

        <div class="customer-row">
            <div class="customer-label">Số Điện Thoại:</div>
            <div class="customer-value">{{ $invoice->customer_phone ?: '................................................' }}</div>
        </div>

        <div class="customer-row">
            <div class="customer-label">Địa Chỉ:</div>
            <div class="customer-value">{{ $invoice->customer_address ?: '................................................' }}</div>
        </div>

        <div class="customer-row">
            <div class="customer-label">Hình Thức Cọc:</div>
            <div class="customer-value">{{ $invoice->deposit_type ?: ($invoice->payment_method ?: 'Chuyển khoản') }}</div>
        </div>
    </div>

    {{-- PRODUCTS TABLE --}}
    <table class="product-table">
        <colgroup>
            <col class="col-stt">
            <col class="col-product">
            <col class="col-quantity">
            <col class="col-price">
            <col class="col-total">
        </colgroup>

        <thead>
            <tr>
                <th>STT</th>
                <th>Tên Sản Phẩm</th>
                <th>Số Lượng</th>
                <th>Đơn Giá</th>
                <th>Thành Tiền</th>
            </tr>
        </thead>

        <tbody>
            @foreach($invoice->items as $index => $item)
                @php
                    $unitPrice = (float) ($item->unit_price ?? 0);
                    $qty       = (float) ($item->quantity ?? 1);
                    $lineTotal = (float) ($item->subtotal ?? ($item->total ?? ($unitPrice * $qty)));
                @endphp
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="product-name">{{ $item->product_name }}</td>
                    <td class="center">{{ rtrim(rtrim(number_format($qty, 2, '.', ''), '0'), '.') }}</td>
                    <td class="right">{{ number_format($unitPrice, 0, ',', '.') }} đ</td>
                    <td class="right">{{ number_format($lineTotal, 0, ',', '.') }} đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- SUMMARY & ĐỌC TIỀN THÀNH CHỮ --}}
    @php
        // Tiền cọc & Phí khác
        $deposit  = (float) ($invoice->deposit_amount ?? $invoice->deposit ?? $invoice->advance_payment ?? 0);
        $otherFee = (float) ($invoice->other_fee ?? 0);

        // Quét tất cả các cột chiết khấu có thể xuất hiện trong DB
        $discountManual = (float) ($invoice->discount_manual ?? $invoice->discount_amount ?? 0);
        $discountRetail = (float) ($invoice->discount_retail ?? $invoice->other_discount ?? 0);
        $discountTotal  = (float) ($invoice->discount_total ?? 0);

        // Tính tổng chiết khấu
        $discount = $discountTotal > 0 ? $discountTotal : ($discountManual + $discountRetail);

        // Tổng tiền sản phẩm & Tổng thanh toán
        $subtotal   = (float) ($invoice->subtotal ?? $invoice->items->sum('subtotal'));
        $grandTotal = (float) ($invoice->grand_total ?? max(0, $subtotal - $discount + $otherFee));
        $remaining  = (float) ($invoice->remaining ?? max(0, $grandTotal - $deposit));
        $note       = $invoice->note ?? '';

        // Hàm đọc số tiền thành chữ trong PHP
        if (!function_exists('convert_number_to_words_print')) {
            function convert_number_to_words_print($number) {
                $hyphen      = ' ';
                $conjunction = ' ';
                $separator   = ' ';
                $negative    = 'âm ';
                $dictionary  = array(
                    0                   => 'không',
                    1                   => 'một',
                    2                   => 'hai',
                    3                   => 'ba',
                    4                   => 'bốn',
                    5                   => 'năm',
                    6                   => 'sáu',
                    7                   => 'bảy',
                    8                   => 'tám',
                    9                   => 'chín',
                    10                  => 'mười',
                    11                  => 'mười một',
                    12                  => 'mười hai',
                    13                  => 'mười ba',
                    14                  => 'mười bốn',
                    15                  => 'mười lăm',
                    16                  => 'mười sáu',
                    17                  => 'mười bảy',
                    18                  => 'mười tám',
                    19                  => 'mười chín',
                    20                  => 'hai mươi',
                    30                  => 'ba mươi',
                    40                  => 'bốn mươi',
                    50                  => 'năm mươi',
                    60                  => 'sáu mươi',
                    70                  => 'bảy mươi',
                    80                  => 'tám mươi',
                    90                  => 'chín mươi',
                    100                 => 'trăm',
                    1000                => 'ngàn',
                    1000000             => 'triệu',
                    1000000000          => 'tỷ',
                    1000000000000       => 'nghìn tỷ'
                );

                if (!is_numeric($number)) return false;
                if ($number < 0) return $negative . convert_number_to_words_print(abs($number));

                $string = $fraction = null;

                if (strpos($number, '.') !== false) {
                    list($number, $fraction) = explode('.', $number);
                }

                switch (true) {
                    case $number < 21:
                        $string = $dictionary[$number];
                        break;
                    case $number < 100:
                        $tens   = ((int) ($number / 10)) * 10;
                        $units  = $number % 10;
                        $string = $dictionary[$tens];
                        if ($units) {
                            $string .= $hyphen . ($units == 1 ? 'mốt' : ($units == 5 ? 'lăm' : $dictionary[$units]));
                        }
                        break;
                    case $number < 1000:
                        $hundreds  = (int) ($number / 100);
                        $remainder = $number % 100;
                        $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                        if ($remainder) {
                            $string .= $conjunction . ($remainder < 10 ? 'lẻ ' : '') . convert_number_to_words_print($remainder);
                        }
                        break;
                    default:
                        $baseUnit = pow(1000, floor(log($number, 1000)));
                        $numBaseUnits = (int) ($number / $baseUnit);
                        $remainder = $number % $baseUnit;
                        $string = convert_number_to_words_print($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                        if ($remainder) {
                            $string .= $remainder < 100 ? $conjunction . 'không trăm ' : $separator;
                            $string .= convert_number_to_words_print($remainder);
                        }
                        break;
                }

                return $string;
            }
        }

        $amountInWords = convert_number_to_words_print($remaining);
    @endphp

    <div class="summary-wrapper">
        <div class="summary-note">
            @if($note)
                <div style="line-height: 1.5;">
                    <strong>Ghi Chú Giao Hàng:</strong> {!! nl2br(e($note)) !!}
                </div>
            @endif

            <div class="amount-word">
                SỐ TIỀN BẰNG CHỮ: {{ $amountInWords ? mb_strtoupper($amountInWords, 'UTF-8') . ' ĐỒNG' : '................................................' }}
            </div>
        </div>

        <div class="summary-box">
            <div class="summary-row">
                <div class="summary-label">TỔNG:</div>
                <div class="summary-value">{{ number_format($subtotal, 0, ',', '.') }} đ</div>
            </div>

            <div class="summary-row">
                <div class="summary-label">CHIẾT KHẤU:</div>
                <div class="summary-value">{{ number_format($discount, 0, ',', '.') }} đ</div>
            </div>

            <div class="summary-row">
                <div class="summary-label">CỌC:</div>
                <div class="summary-value">{{ number_format($deposit, 0, ',', '.') }} đ</div>
            </div>

            <div class="summary-row">
                <div class="summary-label">PHÍ KHÁC:</div>
                <div class="summary-value">{{ number_format($otherFee, 0, ',', '.') }} đ</div>
            </div>

            <div class="summary-row">
                <div class="summary-label">CÒN LẠI:</div>
                <div class="summary-value">{{ number_format($remaining, 0, ',', '.') }} đ</div>
            </div>
        </div>
    </div>

    {{-- SIGNATURE --}}
    <div class="signature">
        <div class="signature-column">
            <div class="signature-title">Khách Hàng</div>
            <div class="signature-note">(Ký, ghi rõ họ tên)</div>
            <div class="signature-space"></div>
            <div>&nbsp;</div>
        </div>

        <div class="signature-column">
            <div class="signature-title">Nhân viên Bán Hàng</div>
            <div class="signature-note">(Ký, ghi rõ họ tên)</div>
            <div class="signature-space"></div>
            <div class="sale-name">
                {{ $invoice->sale_name ?? (auth()->user()->name ?? 'N/A') }}
            </div>
        </div>
    </div>

    {{-- PRINT BUTTON --}}
    <div class="no-print">
        <button type="button" class="print-button" onclick="window.print()">
            IN HÓA ĐƠN
        </button>
    </div>

</div>

<script>
    window.addEventListener('load', function () {
        setTimeout(function () {
            window.print();
        }, 300);
    });
</script>

</body>
</html>