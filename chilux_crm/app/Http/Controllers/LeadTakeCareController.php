<?php

namespace App\Http\Controllers;

use App\Models\LeadTakeCare;
use Illuminate\Http\Request;

class LeadTakeCareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leadTakeCare = LeadTakeCare::all();
        return view('lead_take_cares.index', compact('leadTakeCare'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lead_take_cares.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $leadTakeCare = LeadTakeCare::create();
            'lead_id' => $request->lead_id,
            'take_care_plan' => $request->take_care_plan,
            'take_care_date' => $request->take_care_date,
            'take_care_result' => $request->take_care_result
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadTakeCare $leadTakeCare)
    {
        return view('lead_take_cares.show', compact('leadTakeCare'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadTakeCare $leadTakeCare)
    {
        return view ('lead_take_cares.edit', compact('leadTakeCare'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadTakeCare $leadTakeCare)
    {
        $leadTakeCare->update([
            'lead_id' => $request->lead_id,
            'take_care_plan' => $request->take_care_plan,
            'take_care_date' => $request->take_care_date,
            'take_care_result' => $request->take_care_result
        ]);

        return redirect()->route('lead_take_cares.index')->with('success', 'Cập nhập thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadTakeCare $leadTakeCare)
    {
        $leadTakeCare->delete();
        return redirect()->route('lead_take_cares.index')->with('success', 'Xóa thành công!');
    }
}
