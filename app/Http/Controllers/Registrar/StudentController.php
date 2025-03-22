<?php

namespace App\Http\Controllers\Registrar;

use App\Models\User;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\AcademicRecord;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();

        $students = User::role('student')
            ->with([
                'studentProfile' => function ($query) {
                    $query->with([
                        'academicRecords' => function ($q) {
                            $q->with(['academicYear', 'grades']);
                        },
                    ]);
                },
            ])
            ->when($request->academic_year, function ($query) use ($request) {
                $query->whereHas('academicRecords', function ($q) use ($request) {
                    $q->where('academic_year_id', $request->academic_year);
                });
            })
            ->orderBy('name')
            ->paginate(12);

        return view('users.registrar.student.index', compact('students', 'academicYears'));
    }

    public function show(Request $request, string $id)
    {
        $student = User::role('student')
            ->with([
                'studentProfile',
                'studentProfile.academicRecords' => function($query) use ($request) {
                    $query->when($request->academic_year, function($q) use ($request) {
                        $q->where('academic_year_id', $request->academic_year);
                    })
                    ->orderBy('grade_level', 'desc');
                },
                'studentProfile.academicRecords.academicYear',
                'studentProfile.academicRecords.grades'
            ])
            ->findOrFail($id);

        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();

        return view('users.registrar.student.show', compact('student', 'academicYears'));
    }

    public function print(string $studentId, string $academicRecordId)
    {
        $student = User::with('studentProfile')->findOrFail($studentId);

        $academicRecord = AcademicRecord::with([
            'academicYear',
            'grades' => function($query) {
                $query->orderBy('subject')->orderBy('quarter');
            }
        ])->findOrFail($academicRecordId);

        return view('users.registrar.student.print', compact('student', 'academicRecord'));
    }

    public function printGoodMoral(string $id)
    {
        $student = User::with(['studentProfile'])->findOrFail($id);
        $currentDate = now()->format('F d, Y');

        return view('users.registrar.student.good-moral', compact('student', 'currentDate'));
    }

    public function printForm137(string $id)
    {
        $student = User::with([
            'studentProfile' => function($query) {
                $query->with([
                    'academicRecords' => function($q) {
                        $q->with(['academicYear', 'grades' => function($query) {
                            $query->orderBy('subject')->orderBy('quarter');
                        }]);
                    },
                ]);
            },
        ])->findOrFail($id);

        return view('users.registrar.student.form-137', compact('student'));
    }
}
