<?php

namespace App\Http\Controllers\Admin;

use App\Models\Strand;
use App\Models\TuitionFeeBracket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $strands = Strand::with('tuitionFees')->latest()->paginate(10);
        $brackets = TuitionFeeBracket::with('fees')->where('is_active', true)->get();

        return view('users.admin.strand.index', compact('strands', 'brackets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.strand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'acronym' => 'required',
            'description' => 'required'
        ]);


        Strand::create([
            'name' => $request->name,
            'acronym' => $request->acronym,
            'descriptions' => $request->description
        ]);


        return back()->with([
            'message' => 'Strand Added'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $strand = Strand::with(['tuitionFees.bracket', 'classrooms.teacher.profile'])
            ->findOrFail($id);

        $brackets = TuitionFeeBracket::with('fees')->where('is_active', true)->get();

        return view('users.admin.strand.show', compact('strand', 'brackets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $strand = Strand::find($id);


        return view('users.admin.strand.edit', compact('strand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $strand = Strand::find($id);


        $strand->update([
            'name' => $request->name ?? $strand->name,
            'acronym' => $request->acronym ?? $strand->acronym,
            'descriptions' => $request->description ?? $strand->descriptions
        ]);


        return back()->with(['message' => 'Strand Data Updated']);
    }

    /**
     * Update tuition fees for the strand.
     */
    public function updateTuitionFees(Request $request, string $id)
    {
        $strand = Strand::findOrFail($id);

        $request->validate([
            'tuition_fees' => 'nullable|array',
            'tuition_fees.*' => 'exists:tuition_fees,id'
        ]);

        // Sync the tuition fees (this will remove old ones and add new ones)
        $strand->tuitionFees()->sync($request->tuition_fees ?? []);

        return redirect()
            ->route('admin.strands.index')
            ->with('success', 'Tuition fees updated successfully for ' . $strand->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $strand = Strand::find($id);

        // Detach all tuition fees before deleting
        $strand->tuitionFees()->detach();

        $strand->delete();

        return back()->with(['message' => 'Strand Deleted Successfully']);
    }
}
