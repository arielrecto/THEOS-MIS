<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRoles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $students = User::role(UserRoles::STUDENT->value)->latest()->paginate(10);

        return view('users.admin.users.student.index', compact(['students']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = User::find($id);


        return view('users.admin.users.student.show', compact(['student']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = User::find($id);

        return view('users.admin.users.student.edit', compact(['student']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = User::find($id);

        if ($request->password) {
            $request->validate([
                'password' => 'required|confirmed'
            ]);


            $student->update([
                'password' => Hash::make($request->password)
            ]);
        }

        $student->update([
            'name' => $request->name ?? $student->name,
            'email' => $request->email ?? $student->email,
        ]);


        return back()->with(['success' => 'student Data Update']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = User::find($id);

        $student->delete();

        return back()->with(['message' => 'Student Date Deleted']);
    }
}
