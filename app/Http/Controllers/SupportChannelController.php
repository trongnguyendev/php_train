<?php

namespace App\Http\Controllers;

use App\Models\SupportChannel;
use App\Models\Lead;
use Illuminate\Http\Request;

class SupportChannelController extends Controller
{
    public function index()
    {
        // Gate::authorize('viewAny', SupportChannel::class); // Bỏ comment nếu có policy
        $channels = SupportChannel::with('lead')->get();
        return view('support_channels.index', compact('channels'));
    }

    public function create()
    {
        // Gate::authorize('create', SupportChannel::class);
        $leads = \App\Models\Lead::all();
        return view('support_channels.create', compact('leads'));
    }

    public function store(Request $request)
    {
        // Gate::authorize('create', SupportChannel::class);
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Tên kênh không được để trống',
        ]);

        SupportChannel::create([
            'name' => $request->name,
        ]);

        return redirect()->route('support-channels.index')->with('success', 'Tạo kênh hỗ trợ thành công!');
    }

    public function show(SupportChannel $support_channel)
    {
        // Gate::authorize('view', $support_channel);
        return view('support_channels.show', compact('support_channel'));
    }

    public function edit(SupportChannel $support_channel)
    {
        // Gate::authorize('update', $support_channel);
        $leads = \App\Models\Lead::all();
        return view('support_channels.edit', compact('support_channel', 'leads'));
    }

    public function update(Request $request, SupportChannel $support_channel)
    {
        // Gate::authorize('update', $support_channel);
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Tên kênh không được để trống',
        ]);

        $support_channel->update([
            'name' => $request->name,
        ]);

        return redirect()->route('support-channels.index')->with('success', 'Cập nhật kênh hỗ trợ thành công!');
    }

    public function destroy(SupportChannel $support_channel)
    {
        // Gate::authorize('delete', $support_channel);
        $support_channel->delete();
        return redirect()->route('support-channels.index')->with('success', 'Xóa kênh hỗ trợ thành công!');
    }
}
