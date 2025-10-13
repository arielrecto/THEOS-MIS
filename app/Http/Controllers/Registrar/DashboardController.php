<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\StudentProfile;
use App\Models\AcademicYear;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Get current academic year
        $currentAcademicYear = AcademicYear::where('status', 'active')->first();

        // Get counts
        $counts = [
            'enrollments' => $currentAcademicYear
                ? $currentAcademicYear->enrollments()->count()
                : 0,
            'students' => StudentProfile::count(),
            'academic_years' => AcademicYear::count(),
        ];

        // Get recent enrollments
        $recentEnrollments = Enrollment::with(['academicYear', 'enrollees'])
            ->latest()
            ->take(5)
            ->get();

        // Get enrollment statistics
        $enrollmentStats = $this->getEnrollmentStats($currentAcademicYear);

        return view('users.registrar.dashboard', compact(
            'counts',
            'recentEnrollments',
            'currentAcademicYear',
            'enrollmentStats'
        ));
    }

    private function getEnrollmentStats($academicYear)
    {
        if (!$academicYear) {
            return collect();
        }

        return $academicYear->enrollments()
            ->withCount('enrollees')
            ->get()
            ->map(function ($enrollment) {
                return [
                    'name' => $enrollment->name,
                    'count' => $enrollment->enrollees_count,
                    'status' => $enrollment->status,
                ];
            });
    }
}
