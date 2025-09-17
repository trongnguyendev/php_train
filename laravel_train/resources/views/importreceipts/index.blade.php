@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách phiếu nhập</h1>
    <a href="{{ route('importreceipts.create') }}" class="btn btn-primary mb-3">+ Tạo phiếu nhập</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã phiếu</th>
                <th>Kho</th>
                <th>Ngày nhập</th>
                <th>Sản phẩm</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($receipts as $receipt)
                <tr>
                    <td>{{ $receipt->code }}</td>
                    <td>{{ $receipt->warehouse->name }}</td>
                    <td>{{ $receipt->received_at }}</td>
                    <td>
                        @foreach($receipt->products as $product)
                            <div>{{ $product->name }} (SL: {{ $product->pivot->quantity }})</div>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('importreceipts.show', $receipt->id) }}" class="btn btn-info btn-sm">Xem</a>
                        <a href="{{ route('importreceipts.edit', $receipt->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('importreceipts.destroy', $receipt->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa phiếu nhập này?')" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
