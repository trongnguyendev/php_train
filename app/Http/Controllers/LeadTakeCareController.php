<?php

namespace App\Http\Controllers;

use App\Models\LeadTakeCare;
use Illuminate\Http\Request;

class LeadTakeCareController extends Controller
{
    // Xử lý inline edit cho LeadTakeCare
    public function updateInline(Request $request, $id = null)
    {
        $field = $request->field;
        $value = $request->value;
        $leadId = $request->lead_id;
        $index = $request->index;

        if ($id) {
            // Update bản ghi đã có
            $leadTakeCare = LeadTakeCare::findOrFail($id);
            $leadTakeCare->$field = $value;
            $leadTakeCare->save();
        } else {
            // Lấy danh sách chăm sóc của lead, sắp xếp theo ngày tạo
            $cares = LeadTakeCare::where('lead_id', $leadId)->orderBy('created_at')->get();
            if (isset($cares[$index])) {
                // Nếu đã có bản ghi ở vị trí index thì update
                $leadTakeCare = $cares[$index];
                $leadTakeCare->$field = $value;
                $leadTakeCare->save();
            } else {
                // Nếu chưa có thì tạo mới
                $data = [
                    'lead_id' => $leadId,
                    'take_care_plan' => null,
                    'take_care_date' => null,
                    'take_care_result' => null
                ];
                $data[$field] = $value;
                $leadTakeCare = LeadTakeCare::create($data);
            }
        }
        return response()->json(['success' => true, 'id' => $leadTakeCare->id]);
    }
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
        $leadTakeCare = LeadTakeCare::create([
            'lead_id' => $request->lead_id,
            'take_care_plan' => $request->take_care_plan,
            'take_care_date' => $request->take_care_date,
            'take_care_result' => $request->take_care_result
        ]);

        return redirect()->route('lead_take_cares.index')->with('success', 'Tạo thành công!');
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
