<?php

namespace App\Http\Controllers;

use App\Models\Showroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ShowroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Showroom::class);
        $showroom = Showroom::all();
        return view('showrooms.index', compact('showroom'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Showroom::class);
        return view('showrooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Showroom::class);
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Tên không được để trống'
        ]);

        $showroom = Showroom::create([
            'name' => $request->name
        ]);

        return redirect()->route('showrooms.index')->with('success', 'Tạo Showroom thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Showroom $showroom)
    {
        Gate::authorize('view', $showroom);
        return view('showrooms.show', compact('showroom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Showroom $showroom)
    {
        Gate::authorize('update', $showroom);
        return view('showrooms.edit', compact('showroom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Showroom $showroom)
    {
        Gate::authorize('update', $showroom);
        $request->validate([
            'name' => 'required|string'
        ], [
            'name.required' => 'Tên showroom không được để trống!'
        ]);

        $showroom->update([
            'name' => $request->name
        ]);

        return redirect()->route('showrooms.index')->with('success', 'Cập nhập Showroom thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Showroom $showroom)
    {
        Gate::authorize('delete', $showroom);
        $showroom->delete();
        return redirect()->route('showrooms.index')->with('success', 'Xóa Showroom thành công!');
    }
}
