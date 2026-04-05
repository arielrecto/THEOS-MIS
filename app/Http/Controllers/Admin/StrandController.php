<?php

namespace App\Http\Controllers\Admin;

use App\Models\Strand;
use App\Models\Section;
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
        $strands = Strand::with(['tuitionFees', 'sections'])->latest()->paginate(10);
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
            'message' => 'Grade Level Added'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $strand = Strand::with(['tuitionFees.bracket', 'classrooms.teacher.profile', 'sections'])
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

        return back()->with(['message' => 'Grade Level Data Updated']);
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

        $strand->tuitionFees()->sync($request->tuition_fees ?? []);

        return redirect()
            ->route('admin.strands.index')
            ->with('success', 'Tuition fees updated successfully for ' . $strand->name);
    }

    /**
     * Store a section for the strand.
     */
    public function storeSection(Request $request)
    {


        $strand = Strand::findOrFail($request->strand_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'grade_level' => 'required',
            'capacity' => 'required|integer|min:1|max:100',
            'description' => 'nullable|string',
        ]);

        $strand->sections()->create([
            'name' => $request->name,
            'grade_level' => $request->grade_level,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return back()->with('success', 'Section added successfully to ' . $strand->name);
    }

    /**
     * Update a section.
     */
    public function updateSection(Request $request, string $strandId, string $sectionId)
    {
        $section = Section::where('strand_id', $strandId)->findOrFail($sectionId);

        $request->validate([
            'name' => 'required|string|max:255',
            'grade_level' => 'required|integer|min:7|max:12',
            'capacity' => 'required|integer|min:1|max:100',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $section->update([
            'name' => $request->name,
            'grade_level' => $request->grade_level,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return back()->with('success', 'Section updated successfully');
    }

    /**
     * Delete a section.
     */
    public function destroySection(string $strandId, string $sectionId)
    {
        $section = Section::where('strand_id', $strandId)->findOrFail($sectionId);

        // Check if section has students
        if ($section->academicRecords()->count() > 0) {
            return back()->with('error', 'Cannot delete section with enrolled students');
        }

        $section->delete();

        return back()->with('success', 'Section deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $strand = Strand::find($id);

        // Detach all tuition fees before deleting
        $strand->tuitionFees()->detach();

        // Delete all sections
        $strand->sections()->delete();

        $strand->delete();

        return back()->with(['message' => 'Grade Level Deleted Successfully']);
    }
}
