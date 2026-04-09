<?php

namespace App\Http\Controllers\Registrar;

use App\Models\User;
use App\Models\Strand;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();

        // Get only Senior High strands for the strand filter
        $strands = Strand::whereNotNull('acronym')
            ->where('acronym', '!=', '')
            ->orderBy('acronym')
            ->get();

        $students = User::role('student')
            ->with([
                'studentProfile.academicRecords' => function ($query) use ($request) {
                    // Filter by academic year
                    if ($request->academic_year) {
                        $query->where('academic_year_id', $request->academic_year);
                    }

                    // Filter by grade level (Kinder to Grade 10)
                    if ($request->grade_level) {
                        $query->where('grade_level', $request->grade_level);
                    }



                    $query->with(['academicYear', 'grades', 'section.strand']);
                }
            ])
            ->whereHas('studentProfile')
            // Search by student name or LRN
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhereHas('studentProfile', function ($sq) use ($search) {
                          $sq->where('lrn', 'like', "%{$search}%");
                      });
                });
            })
            ->when($request->academic_year || $request->grade_level || $request->strand, function ($query) use ($request) {
                $query->whereHas('studentProfile.academicRecords', function ($q) use ($request) {
                    if ($request->academic_year) {
                        $q->where('academic_year_id', $request->academic_year);
                    }

                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('users.registrar.grade.index', compact('students', 'academicYears', 'strands'));
    }

    public function show(User $student)
    {
        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();

        return view('users.registrar.grade.show', compact('student', 'academicYears'));
    }
}
