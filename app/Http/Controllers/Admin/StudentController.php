<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRoles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;



class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $gradeLevels = ['Kinder', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5',
                        'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'];

        $query = User::role(UserRoles::STUDENT->value)
            ->with([
                'studentProfile.academicRecords' => fn($q) => $q->orderByDesc('id'),
            ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('studentProfile', fn($sq) =>
                      $sq->where('lrn', 'like', "%{$search}%")
                         ->orWhere('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                  );
            });
        }

        if ($request->filled('grade_level')) {
            $query->whereHas('studentProfile.academicRecords', fn($q) =>
                $q->where('grade_level', $request->grade_level)
            );
        }

        $students = $query->latest()->paginate(15)->withQueryString();

        return view('users.admin.users.student.index', compact('students', 'gradeLevels'));
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
        $student = User::with([
            'studentProfile.academicRecords.academicYear',
            'profilePicture',
            'asStudentClassrooms.classroom.subject',
            'asStudentClassrooms.classroom.teacher',
            'asStudentClassrooms.classroom.academicYear',
            'asStudentClassrooms.classroom.strand',
        ])->findOrFail($id);

        return view('users.admin.users.student.show', compact('student'));
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

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $student->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully');
    }
}
