<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Mockery\Matcher\Subset;

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
        return view('users.admin.subject.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'subject_code' => 'required',
            'description' => 'required'
        ]);


        Subject::create([
            'name' => $request->name,
            'subject_code' => $request->subject_code,
            'description' => $request->description
        ]);


        return back()->with(['message' => 'Subject Added']);
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

        return view('users.admin.subject.edit', compact('subject'));
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
