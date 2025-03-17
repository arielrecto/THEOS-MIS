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
    public function index()
    {

        $user = Auth::user();

        $classrooms = Classroom::where('teacher_id', $user->id)->latest()->paginate(10);

        return view('users.teacher.classroom.index', compact(['classrooms']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $subjects = Subject::get();

        $strands = Strand::get();


        $academicYear = AcademicYear::where('status', AcademicYearStatus::Active->value)->latest()->first();

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



        $classroom_code = 'CLSSRM'.uniqid();


        $imageName = 'IMG-' . uniqid() . '.' . $request->image->extension();
        $dir = $request->image->storeAs('/classroom', $imageName, 'public');

       Classroom::create([
        'image' => asset('/storage/' . $dir),
        'name' => $request->name,
        'class_code' => $classroom_code,
        'description' => $request->description,
        'subject_id' => $request->subject,
        'strand_id' => $request->strand,
        'academic_year_id' => $request->academic_year,
        'teacher_id' => Auth::user()->id
       ]);


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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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

    public function students(string $id){


        $classroomStudents = Classroom::whereId($id)->first()->classroomStudents;



        return view('users.teacher.classroom.student.index', compact('classroomStudents', 'id'));

    }

    public function removeStudent(string $id){
        $classroomStudent = ClassroomStudent::find($id);

        $classroomStudent->delete();


        return back()->with(['message' => 'Student Successfully Remove in Classroom']);

    }
}
