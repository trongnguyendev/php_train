@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Danh sách Danh mục</h1>
    <a href="{{ route('category.create') }}" class="btn btn-primary mb-3">Thêm Danh mục</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên Danh mục</th>
                <th width="150">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('category.edit', $category) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('category.destroy', $category) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" class="text-center">Chưa có danh mục nào</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
