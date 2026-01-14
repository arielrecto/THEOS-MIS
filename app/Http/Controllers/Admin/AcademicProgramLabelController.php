<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicProgramLabel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcademicProgramLabelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = AcademicProgramLabel::latest()->paginate(10);

        return view('users.admin.cms.academic-program-label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.cms.academic-program-label.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            AcademicProgramLabel::create([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
            ]);

            return back()
                ->with('success', 'Academic program label created successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to create academic program label: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $label = AcademicProgramLabel::findOrFail($id);

        return view('users.admin.cms.academic-program-label.show', compact('label'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $label = AcademicProgramLabel::findOrFail($id);

        return view('users.admin.cms.academic-program-label.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $label = AcademicProgramLabel::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $label->update([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
            ]);

            return back()
                ->with('success', 'Academic program label updated successfully!');
        } catch (\Exception $e) {
            return
                back()
                ->with('error', 'Failed to update academic program label: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $label = AcademicProgramLabel::findOrFail($id);
            $label->delete();

            return back()
                ->with('success', 'Academic program label deleted successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete academic program label: ' . $e->getMessage());
        }
    }
}
