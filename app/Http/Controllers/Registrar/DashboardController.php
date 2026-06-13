<?php

namespace App\Http\Controllers\Registrar;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\EnrollmentForm;
use App\Models\Payment;
use App\Models\StudentProfile;
use App\Models\AcademicYear;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Get current academic year
        $currentAcademicYear = AcademicYear::where('status', 'active')->first();

        // Enrollee stats for current year
        $enrolleeQuery = $currentAcademicYear
            ? EnrollmentForm::where('academic_year_id', $currentAcademicYear->id)
            : EnrollmentForm::whereNull('id');

        $enrolleeCounts = [
            'total'    => $enrolleeQuery->count(),
            'approved' => (clone $enrolleeQuery)->where('status', 'approved')->count(),
            'pending'  => (clone $enrolleeQuery)->where('status', 'pending')->count(),
            'rejected' => (clone $enrolleeQuery)->where('status', 'rejected')->count(),
        ];

        $enrolleesByGrade = (clone $enrolleeQuery)
            ->selectRaw('grade_level, count(*) as total')
            ->groupBy('grade_level')
            ->orderBy('grade_level')
            ->pluck('total', 'grade_level');

        // Payment stats for current year's enrollees
        $enrolleeUserIds = $currentAcademicYear
            ? EnrollmentForm::where('academic_year_id', $currentAcademicYear->id)
                ->whereNotNull('user_id')->pluck('user_id')->unique()
            : collect();

        $paymentQuery = Payment::whereIn('user_id', $enrolleeUserIds);

        $paymentStats = [
            'total_amount'   => (clone $paymentQuery)->where('status', 'approved')->sum('amount'),
            'total_count'    => $paymentQuery->count(),
            'approved_count' => (clone $paymentQuery)->where('status', 'approved')->count(),
            'pending_count'  => (clone $paymentQuery)->where('status', 'pending')->count(),
        ];

        $recentPayments = Payment::with(['user', 'paymentAccount'])
            ->whereIn('user_id', $enrolleeUserIds)
            ->latest()->take(5)->get();

        // Get counts
        $counts = [
            'enrollments'    => $currentAcademicYear
                ? $currentAcademicYear->enrollments()->count()
                : 0,
            'students'       => StudentProfile::count(),
            'academic_years' => AcademicYear::count(),
        ];

        // Get recent enrollments
        $recentEnrollments = Enrollment::with(['academicYear', 'enrollees'])
            ->latest()->take(5)->get();

        // Get enrollment statistics
        $enrollmentStats = $this->getEnrollmentStats($currentAcademicYear);

        return view('users.registrar.dashboard', compact(
            'counts',
            'recentEnrollments',
            'currentAcademicYear',
            'enrollmentStats',
            'enrolleeCounts',
            'enrolleesByGrade',
            'paymentStats',
            'recentPayments'
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
