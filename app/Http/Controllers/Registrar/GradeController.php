<?php

namespace App\Http\Controllers\Registrar;

use App\Models\User;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();

        $students = User::role('student')
            ->with([
                'studentProfile.academicRecords.academicYear',
                'studentProfile.academicRecords.grades'
            ])
            ->when($request->academic_year, function($query) use ($request) {
                $query->whereHas('studentProfile.academicRecords', function($q) use ($request) {
                    $q->where('academic_year_id', $request->academic_year);
                });
            })
            ->orderBy('name')
            ->paginate(12);

        return view('users.registrar.grade.index', compact('students', 'academicYears'));
    }
    public function show(User $student)
    {
        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();

        return view('users.registrar.grade.show', compact('student', 'academicYears'));
    }
}
