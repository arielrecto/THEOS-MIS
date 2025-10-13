<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Strand;
use App\Models\Subject;
use App\Models\Classroom;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;
use App\Models\ClassroomStudent;
use App\Enums\AcademicYearStatus;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();

        $query = Classroom::query()
            ->where('teacher_id', Auth::id())
            ->with(['subject', 'strand', 'teacher.profile', 'academicYear', 'classroomStudents']);

        if ($request->has('academic_year')) {
            $query->where('academic_year_id', $request->academic_year);
        }

        $classrooms = $query->latest()->paginate(10);

        return view('users.teacher.classroom.index', compact('classrooms', 'academicYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $subjects = Subject::get();

        $strands = Strand::get();


        $academicYear = AcademicYear::where('status', AcademicYearStatus::Active->value)->latest()->first();


        if (!$academicYear) {
            return back()->with(['error' => 'Action rejected, no active academic year please contact the admin']);
        }

        return view('users.teacher.classroom.create', compact(['subjects', 'strands', 'academicYear']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'subject' => 'required',
            'strand' => 'required',
            'academic_year' => 'required'
        ]);



        $classroom_code = 'CLSSRM' . uniqid();




        $classroom = Classroom::create([
            'name' => $request->name,
            'class_code' => $classroom_code,
            'description' => $request->description,
            'subject_id' => $request->subject,
            'strand_id' => $request->strand,
            'academic_year_id' => $request->academic_year,
            'teacher_id' => Auth::user()->id
        ]);


        if ($request->has('image')) {
            $imageName = 'IMG-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/classroom', $imageName, 'public');

            $classroom->update([
                'image' => asset('/storage/' . $dir),
            ]);
        }


        return  back()->with(['success' => 'Classroom Added']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classroom = Classroom::find($id);


        $attendance = $classroom->attendances()->latest()->first();



        return view('users.teacher.classroom.show', compact(['classroom', 'attendance']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $classroom = Classroom::where('teacher_id', Auth::id())
            ->findOrFail($id);

        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();
        $subjects = Subject::orderBy('name')->get();
        $strands = Strand::orderBy('name')->get();

        return view('users.teacher.classroom.edit', compact(
            'classroom',
            'academicYears',
            'subjects',
            'strands'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $classroom = Classroom::where('teacher_id', Auth::id())
            ->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_year_id' => 'required|exists:academic_years,id',
            'subject_id' => 'required|exists:subjects,id',
            'strand_id' => 'required|exists:strands,id',
        ]);

        $classroom->update($validated);

        return redirect()
            ->route('teacher.classrooms.index')
            ->with('success', 'Classroom updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classroom = Classroom::find($id);


        $classroom->delete();


        return to_route('teacher.classrooms.index')->with(['message' => 'classroom deleted']);
    }

    public function students(string $id)
    {


        $classroomStudents = Classroom::whereId($id)->first()->classroomStudents;



        return view('users.teacher.classroom.student.index', compact('classroomStudents', 'id'));
    }

    public function removeStudent(string $id)
    {
        $classroomStudent = ClassroomStudent::find($id);

        $classroomStudent->delete();


        return back()->with(['message' => 'Student Successfully Remove in Classroom']);
    }
}
