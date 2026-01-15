<?php

namespace App\Http\Controllers\Admin;

use App\Models\AcademicProgram;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AcademicProgramController extends Controller
{
    public function index()
    {
        $programs = AcademicProgram::latest()->get();
        return view('users.admin.cms.program.index', compact('programs'));
    }

    public function create()
    {
        return view('users.admin.cms.program.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path = $request->file('image')->store('programs', 'public');

        AcademicProgram::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'path' => $path,
            'is_active' => false
        ]);

        return redirect()
            ->route('admin.CMS.programs.index')
            ->with('success', 'Program created successfully');
    }

    public function show(AcademicProgram $program)
    {
        return view('users.admin.cms.program.show', compact('program'));
    }

    public function edit(AcademicProgram $program)
    {
        return view('users.admin.cms.program.edit', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AcademicProgram $program)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'is_active' => $request->has('is_active') ? true : false,
            ];

            // Handle image upload if new image is provided
            if ($request->hasFile('image')) {
                // Delete old image
                if ($program->path && Storage::disk('public')->exists($program->path)) {
                    Storage::disk('public')->delete($program->path);
                }

                // Store new image
                $path = $request->file('image')->store('programs', 'public');
                $data['path'] = $path;
            }

            $program->update($data);

            return redirect()
                ->route('admin.CMS.programs.index')
                ->with('success', 'Program updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update program: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function toggleActive(AcademicProgram $program)
    {
        $program->update(['is_active' => !$program->is_active]);
        return back()->with('success', 'Program status updated successfully');
    }

    public function destroy(AcademicProgram $program)
    {
        try {
            // Delete image file
            if ($program->path && Storage::disk('public')->exists($program->path)) {
                Storage::disk('public')->delete($program->path);
            }

            $program->delete();
            
            return redirect()
                ->route('admin.CMS.programs.index')
                ->with('success', 'Program deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete program: ' . $e->getMessage());
        }
    }
}
