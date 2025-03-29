<?php

namespace App\Http\Controllers\Admin;

use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicYears = AcademicYear::paginate(10);
        return view('users.admin.academic-year.index', compact('academicYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.academic-year.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);


        AcademicYear::create([
            'name' => "Academic Year " . date('Y', strtotime($request->start_date)) . " - " . date('Y', strtotime($request->end_date)),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active',
        ]);

        return redirect()->route('admin.academic-year.index')->with('success', 'Academic Year created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        return view('users.admin.academic-year.edit', compact('academicYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // If this is being set as active, deactivate all others
        if ($request->has('status') && $request->status === 'active') {
            AcademicYear::where('id', '!=', $academicYear->id)
                ->update(['status' => 'inactive']);
        }

        $academicYear->update([
            'name' => "Academic Year " . date('Y', strtotime($request->start_date)) . " - " . date('Y', strtotime($request->end_date)),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->has('status') ? 'active' : 'inactive',
        ]);

        return redirect()
            ->route('admin.academic-year.index')
            ->with('success', 'Academic Year updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->delete();

        return redirect()
            ->route('admin.academic-year.index')
            ->with('success', 'Academic Year deleted successfully');
    }
}
