<?php

namespace App\Http\Controllers\Admin;

use App\Models\Strand;
use App\Models\Subject;
use Mockery\Matcher\Subset;
use Illuminate\Http\Request;
use App\Models\GradeLevelSubject;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $subjects = Subject::latest()->paginate(10);

        return view('users.admin.subject.index', compact(['subjects']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $strands = Strand::all();
        return view('users.admin.subject.create', compact('strands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:255|unique:subjects',
            'description' => 'nullable|string',
            'strands' => 'required|array|exists:strands,id'
        ]);

        $subject = Subject::create([
            'name' => $validated['name'],
            'subject_code' => $validated['subject_code'],
            'description' => $validated['description']
        ]);

        // Create grade level subject relationships
        foreach ($validated['strands'] as $strandId) {
            GradeLevelSubject::create([
                'strand_id' => $strandId,
                'subject_id' => $subject->id
            ]);
        }

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Subject created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subject = Subject::find($id);

        return view('users.admin.subject.show', compact(['subject']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = Subject::find($id);
        $strands = Strand::all();



        return view('users.admin.subject.edit', compact('subject', 'strands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subject = Subject::find($id);


        $subject->update([
            'name' => $request->name ?? $subject->name,
            'subject_code' => $request->subject_code ?? $subject->subject_code,
            'description' => $request->description ?? $subject->description
        ]);


        return back()->with(['message' => 'Subject Data Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::find($id);

        $subject->delete();


        return back()->with(['message' => 'Subject Deleted']);
    }
}
