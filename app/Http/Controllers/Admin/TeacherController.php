<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoles;
use App\Models\AcademicYear;
use App\Models\Classroom;
use App\Models\Strand;
use App\Models\Subject;
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
    public function index(Request $request)
    {
        $gradeLevels = ['Kinder', 'Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5',
                        'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10'];

        $query = User::whereHas('roles', function ($q) {
            $q->where('name', UserRoles::TEACHER->value);
        })->with(['teacherClassrooms.strand']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('grade_level')) {
            $query->whereHas('teacherClassrooms.strand', fn($q) =>
                $q->where('name', $request->grade_level)
            );
        }

        $teachers = $query->latest()->paginate(15)->withQueryString();

        return view('users.admin.users.teacher.index', compact('teachers', 'gradeLevels'));
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
        $teacher = User::with([
            'teacherClassrooms.strand',
            'teacherClassrooms.subject',
            'teacherClassrooms.academicYear',
        ])->findOrFail($id);

        $strands = Strand::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('id')->get();

        return view('users.admin.users.teacher.show', compact('teacher', 'strands', 'subjects', 'academicYears'));
    }

    public function assignClassroom(Request $request, string $id)
    {
        $teacher = User::findOrFail($id);

        $validated = $request->validate([
            'strand_id'        => ['required', 'exists:strands,id'],
            'subject_id'       => ['required', 'exists:subjects,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'name'             => ['required', 'string', 'max:255'],
            'description'      => ['required', 'string', 'max:1000'],
        ]);

        $classCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $validated['name']), 0, 4))
            . '-' . strtoupper(substr(md5(uniqid()), 0, 6));

        Classroom::create([
            'name'             => $validated['name'],
            'class_code'       => $classCode,
            'description'      => $validated['description'],
            'strand_id'        => $validated['strand_id'],
            'subject_id'       => $validated['subject_id'],
            'academic_year_id' => $validated['academic_year_id'],
            'teacher_id'       => $teacher->id,
        ]);

        return back()->with('success', 'Classroom assigned to teacher successfully.');
    }

    public function removeClassroom(string $id, Classroom $classroom)
    {
        abort_if($classroom->teacher_id != $id, 403);
        $classroom->delete();
        return back()->with('success', 'Classroom removed successfully.');
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
