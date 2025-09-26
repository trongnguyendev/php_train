<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index()
    {
        $sources = Source::all();
        return view('source.index', compact('sources'));
    }

    public function create()
    {
        return view('source.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sources,name'
        ]);

        Source::create($request->only('name'));

        return redirect()->route('source.index')->with('success', 'Nguồn khách hàng đã được thêm!');
    }

    public function show(Source $source)
    {
        return view('source.show', compact('source'));
    }

    public function edit(Source $source)
    {
        return view('source.edit', compact('source'));
    }

    public function update(Request $request, Source $source)
    {
        $request->validate([
            'name' => 'required|unique:sources,name,' . $source->id
        ]);

        $source->update($request->only('name'));

        return redirect()->route('source.index')->with('success', 'Cập nhật nguồn khách hàng thành công!');
    }

    public function destroy(Source $source)
    {
        $source->delete();
        return redirect()->route('source.index')->with('success', 'Xóa nguồn khách hàng thành công!');
    }
}
