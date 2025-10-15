<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRoles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;



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


    public function updateProfile(Request $request, $id)
    {
        $student = User::find($id);




        $validated = $request->validate([
            // 'lrn' => ['required', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:255'],
            'parent_name' => ['required', 'string', 'max:255'],
            'relationship' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $student->studentProfile->update($validated);

        return back()->with('success', 'Profile updated successfully');
    }


    public function updateEmail(Request $request, $id)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
        ]);


        $student = User::find($id);

        $student->update(['email' => $request->email]);

        return back()->with('success', 'Email updated successfully');
    }

    public function updatePassword(Request $request, $id)
    {


        $student = User::find($id);

        if (Hash::check($request->current_password, $student->password)) {
            $validated = $request->validate([
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);

            $student->update([
                'password' => Hash::make($validated['password']),
            ]);

            return back()->with('success', 'Password updated successfully');
        } else {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }


        return back()->with('success', 'Password updated successfully');
    }
}
