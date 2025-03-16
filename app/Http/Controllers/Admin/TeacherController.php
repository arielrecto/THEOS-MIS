<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoles;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $teachers = User::whereHas('roles', function ($q) {
            $q->where('name', UserRoles::TEACHER->value);
        })->latest()->paginate();

        return view('users.admin.users.teacher.index', compact(['teachers']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.users.teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);


        $teacherRole = Role::where('name', UserRoles::TEACHER->value)->first();

        $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        $user->assignRole($teacherRole);


        return back()->with([
            'message' => 'Account Created Success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $teacher = User::find($id);


        return view('users.admin.users.teacher.show', compact(['teacher']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $teacher = User::find($id);

        return view('users.admin.users.teacher.edit', compact(['teacher']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $teacher = User::find($id);


        $teacher->update([
            'name' => $request->name ?? $teacher->name,
            'email' => $request->email ?? $teacher->email,
            'password' => Hash::make($request->password ?? $teacher->password)
        ]);


        return back()->with(['message' => 'Teacher Account Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = User::find($id);


        $teacher->delete();


        return back()->with(['message' => 'Teacher Account Deleted Success']);
    }
}
