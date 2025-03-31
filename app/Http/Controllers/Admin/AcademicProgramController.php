<?php

namespace App\Http\Controllers\Admin;

use App\Models\AcademicProgram;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function toggleActive(AcademicProgram $program)
    {
        $program->update(['is_active' => !$program->is_active]);
        return back()->with('success', 'Program status updated successfully');
    }

    public function destroy(AcademicProgram $program)
    {
        if ($program->path) {
            Storage::disk('public')->delete($program->path);
        }

        $program->delete();
        return back()->with('success', 'Program deleted successfully');
    }
}
