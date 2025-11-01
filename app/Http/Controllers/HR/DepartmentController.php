<?php

namespace App\Http\Controllers\HR;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::latest()->paginate(10);

        return view('users.hr.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $employees = User::role(['employee', 'admin', 'human-resource', 'teacher'])->get();



        return view('users.hr.departments.create', compact(['employees']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'head' => 'nullable'
        ]);

        Department::create($request->all());

        return back()
            ->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::findOrFail($id);

        return view('users.hr.departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = Department::findOrFail($id);

        $employees = User::role(['employee', 'admin', 'human-resource', 'teacher'])->get();

        return view('users.hr.departments.edit', compact('department', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $department = Department::findOrFail($id);
        $department->update($request->all());

        return back()
            ->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return back()
            ->with('success', 'Department deleted successfully.');
    }

    public function toggleStatus(string $id)
    {
        $department = Department::findOrFail($id);
        $department->update([
            'is_active' => !$department->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $department->is_active,
            'message' => 'Department status updated successfully'
        ]);
    }
}
