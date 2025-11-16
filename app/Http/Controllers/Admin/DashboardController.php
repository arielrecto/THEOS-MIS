<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Enums\UserRoles;
use App\Models\Classroom;
use App\Models\Strand;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentProfile;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $total_users = User::whereHas('roles', function($q) {
            $q->where('name', '!=', UserRoles::ADMIN->value);
        })->count();

        $total_classrooms = Classroom::count();

        $total_students = User::whereHas('roles', function($q) {
            $q->where('name', UserRoles::STUDENT->value);
        })->count();

        // Get all dashboard data
        $enrollmentTrend = $this->getEnrollmentTrend();
        $studentsPerStrand = $this->getStudentsPerStrand();
        $genderDistribution = $this->getGenderDistribution();

        return view('users.admin.dashboard', compact([
            'total_users',
            'total_classrooms',
            'total_students',
            'enrollmentTrend',
            'studentsPerStrand',
            'genderDistribution'
        ]));
    }

    private function getEnrollmentTrend()
    {
        $months = collect(range(5, 0))->map(function($month) {
            return Carbon::now()->subMonths($month)->format('F');
        });

        $enrollments = StudentProfile::select(
                DB::raw('COUNT(*) as count'),
                DB::raw("strftime('%m', created_at) as month")
            )
            ->whereDate('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return [
            'labels' => $months,
            'datasets' => [[
                'label' => 'New Enrollments',
                'data' => array_values($enrollments),
                'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                'borderColor' => 'rgb(59, 130, 246)',
                'borderWidth' => 1
            ]]
        ];
    }

    private function getStudentsPerStrand()
    {
        $studentsPerStrand = Classroom::select('strands.name')
            ->selectRaw('COUNT(DISTINCT classroom_students.student_id) as student_count')
            ->leftJoin('classroom_students', 'classrooms.id', '=', 'classroom_students.classroom_id')
            ->leftJoin('strands', 'classrooms.strand_id', '=', 'strands.id')
            ->whereNotNull('strands.id')
            ->groupBy('strands.id', 'strands.name')
            ->orderBy('strands.name')
            ->get();

        // Generate distinct colors for each strand
        $colors = $this->generateColors(count($studentsPerStrand));

        return [
            'labels' => $studentsPerStrand->pluck('name'),
            'datasets' => [[
                'label' => 'Students per Grade Level',
                'data' => $studentsPerStrand->pluck('student_count'),
                'backgroundColor' => $colors['background'],
                'borderColor' => $colors['border'],
                'borderWidth' => 1
            ]]
        ];
    }

    private function getGenderDistribution()
    {
        $genderCounts = StudentProfile::select('gender', DB::raw('count(*) as count'))
            ->whereNotNull('gender')
            ->groupBy('gender')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->gender => $item->count];
            });

        return [
            'labels' => ['Male', 'Female'],
            'datasets' => [[
                'label' => 'Gender Distribution',
                'data' => [
                    $genderCounts['male'] ?? 0,
                    $genderCounts['female'] ?? 0
                ],
                'backgroundColor' => [
                    'rgba(99, 102, 241, 0.5)',
                    'rgba(236, 72, 153, 0.5)'
                ],
                'borderColor' => [
                    'rgb(99, 102, 241)',
                    'rgb(236, 72, 153)'
                ],
                'borderWidth' => 1
            ]]
        ];
    }

    private function generateColors($count)
    {
        $colors = [
            'background' => [],
            'border' => []
        ];

        for ($i = 0; $i < $count; $i++) {
            $hue = ($i * (360 / $count)) % 360;
            $colors['background'][] = "hsla($hue, 70%, 60%, 0.5)";
            $colors['border'][] = "hsl($hue, 70%, 50%)";
        }

        return $colors;
    }
}
