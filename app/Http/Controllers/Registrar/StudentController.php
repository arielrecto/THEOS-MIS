<?php

namespace App\Http\Controllers\Registrar;

use App\Models\User;
use App\Models\Strand;
use App\Models\Payment;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Models\AcademicRecord;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Load filter options
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();
        $strands = Strand::orderBy('acronym')->get();
        $gradeLevels = [7, 8, 9, 10, 11, 12];

        // Build the query
        $query = User::role('student')
            ->with([
                'studentProfile.academicRecords' => function ($query) use ($request) {
                    $query->with(['academicYear']) // 'strand' commented out
                        ->when($request->filled('academic_year'), function ($q) use ($request) {
                            $q->where('academic_year_id', $request->academic_year);
                        })
                        ->orderBy('grade_level', 'desc');
                },
                'profilePicture'
            ]);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('studentProfile', function ($sq) use ($search) {
                        $sq->where('lrn', 'like', "%{$search}%")
                            ->orWhere('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%");
                    });
            });
        }

        // Apply grade level filter
        if ($request->filled('grade_level')) {
            $query->whereHas('studentProfile.academicRecords', function ($q) use ($request) {
                $q->where('grade_level', $request->grade_level);
                if ($request->filled('academic_year')) {
                    $q->where('academic_year_id', $request->academic_year);
                }
            });
        }

        // Apply strand filter (commented out)
        // if ($request->filled('strand')) {
        //     $query->whereHas('studentProfile.academicRecords', function ($q) use ($request) {
        //         $q->where('strand_id', $request->strand);
        //         if ($request->filled('academic_year')) {
        //             $q->where('academic_year_id', $request->academic_year);
        //         }
        //     });
        // }

        // Apply academic year filter
        if ($request->filled('academic_year') && !$request->filled('grade_level')) { // && !$request->filled('strand')
            $query->whereHas('studentProfile.academicRecords', function ($q) use ($request) {
                $q->where('academic_year_id', $request->academic_year);
            });
        }

        // Apply sorting
        $sort = $request->get('sort', 'name_asc');

        switch ($sort) {
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'lrn_asc':
                $query->leftJoin('student_profiles', 'users.id', '=', 'student_profiles.user_id')
                    ->orderBy('student_profiles.lrn', 'asc')
                    ->select('users.*');
                break;
            case 'lrn_desc':
                $query->leftJoin('student_profiles', 'users.id', '=', 'student_profiles.user_id')
                    ->orderBy('student_profiles.lrn', 'desc')
                    ->select('users.*');
                break;
            case 'grade_asc':
                $query->leftJoin('student_profiles as sp', 'users.id', '=', 'sp.user_id')
                    ->leftJoin('academic_records as ar', function($join) use ($request) {
                        $join->on('sp.id', '=', 'ar.student_profile_id')
                            ->where(function($q) use ($request) {
                                if ($request->filled('academic_year')) {
                                    $q->where('ar.academic_year_id', $request->academic_year);
                                }
                            });
                    })
                    ->orderBy('ar.grade_level', 'asc')
                    ->select('users.*')
                    ->distinct();
                break;
            case 'grade_desc':
                $query->leftJoin('student_profiles as sp', 'users.id', '=', 'sp.user_id')
                    ->leftJoin('academic_records as ar', function($join) use ($request) {
                        $join->on('sp.id', '=', 'ar.student_profile_id')
                            ->where(function($q) use ($request) {
                                if ($request->filled('academic_year')) {
                                    $q->where('ar.academic_year_id', $request->academic_year);
                                }
                            });
                    })
                    ->orderBy('ar.grade_level', 'desc')
                    ->select('users.*')
                    ->distinct();
                break;
            case 'recent':
                $query->latest('created_at');
                break;
            case 'name_asc':
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        // Paginate results
        $students = $query->paginate(15)->withQueryString();

        return view('users.registrar.student.index', compact(
            'students',
            'academicYears',
            'strands',
            'gradeLevels'
        ));
    }

    public function show(Request $request, string $id)
    {
        $student = User::role('student')
            ->with([
                'studentProfile',
                'studentProfile.academicRecords' => function ($query) use ($request) {
                    $query->when($request->academic_year, function ($q) use ($request) {
                        $q->where('academic_year_id', $request->academic_year);
                    })
                    ->orderBy('grade_level', 'desc');
                },
                'studentProfile.academicRecords.academicYear',
                // 'studentProfile.academicRecords.strand', // Commented out
                'studentProfile.academicRecords.grades',
                'profilePicture',
                'asStudentClassrooms.classroom.subject'
            ])
            ->findOrFail($id);

        $academicYears = AcademicYear::orderBy('created_at', 'desc')->get();

        // Get payment history with pagination
        $payments = Payment::where('user_id', $id)
            ->with('paymentAccount')
            ->latest()
            ->paginate(10);

        // Calculate payment statistics
        $paymentStats = [
            'total_paid' => Payment::where('user_id', $id)
                ->where('status', 'approved')
                ->sum('amount'),
            'total_pending' => Payment::where('user_id', $id)
                ->where('status', 'pending')
                ->sum('amount'),
            'total_count' => Payment::where('user_id', $id)->count(),
            'payment_rate' => 0
        ];

        // Calculate payment rate
        $totalExpected = Payment::where('user_id', $id)->sum('amount');
        if ($totalExpected > 0) {
            $paymentStats['payment_rate'] = ($paymentStats['total_paid'] / $totalExpected) * 100;
        }

        // Prepare chart data (last 6 months)
        $chartData = $this->preparePaymentChartData($id);

        return view('users.registrar.student.show', compact(
            'student',
            'academicYears',
            'payments',
            'paymentStats',
            'chartData'
        ));
    }

    /**
     * Generate comprehensive student data report
     */
    public function studentDataReport(string $id)
    {
        $student = User::role('student')
            ->with([
                'studentProfile',
                'studentProfile.academicRecords' => function ($query) {
                    $query->orderBy('grade_level', 'desc');
                },
                'studentProfile.academicRecords.academicYear',
                // 'studentProfile.academicRecords.strand', // Commented out
                'studentProfile.academicRecords.grades',
                'profilePicture',
                'asStudentClassrooms.classroom.subject'
            ])
            ->findOrFail($id);

        // Get all payments (not paginated for report)
        $payments = Payment::where('user_id', $id)
            ->with('paymentAccount')
            ->latest()
            ->get();

        // Calculate payment statistics
        $paymentStats = [
            'total_paid' => Payment::where('user_id', $id)
                ->where('status', 'approved')
                ->sum('amount'),
            'total_pending' => Payment::where('user_id', $id)
                ->where('status', 'pending')
                ->sum('amount'),
            'total_count' => Payment::where('user_id', $id)->count(),
            'payment_rate' => 0
        ];

        // Calculate payment rate
        $totalExpected = Payment::where('user_id', $id)->sum('amount');
        if ($totalExpected > 0) {
            $paymentStats['payment_rate'] = ($paymentStats['total_paid'] / $totalExpected) * 100;
        }

        return view('users.registrar.student.student-data', compact(
            'student',
            'payments',
            'paymentStats'
        ));
    }

    /**
     * Prepare payment chart data
     */
    private function preparePaymentChartData($userId)
    {
        $payments = Payment::where('user_id', $userId)
            ->where('status', 'approved')
            ->where('created_at', '>=', now()->subMonths(6))
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($payment) {
                return $payment->created_at->format('M Y');
            });

        $labels = [];
        $amounts = [];

        // Generate last 6 months labels
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabel = $date->format('M Y');
            $labels[] = $monthLabel;

            // Get total amount for this month
            $monthPayments = $payments->get($monthLabel, collect());
            $amounts[] = $monthPayments->sum('amount');
        }

        return [
            'labels' => $labels,
            'amounts' => $amounts
        ];
    }

    public function print(string $studentId, string $academicRecordId)
    {
        $student = User::with('studentProfile')->findOrFail($studentId);

        $academicRecord = AcademicRecord::with([
            'academicYear',
            // 'strand', // Commented out
            'grades' => function ($query) {
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
            'studentProfile' => function ($query) {
                $query->with([
                    'academicRecords' => function ($q) {
                        $q->with([
                            'academicYear',
                            // 'strand', // Commented out
                            'grades' => function ($query) {
                                $query->orderBy('subject')->orderBy('quarter');
                            }
                        ]);
                    },
                ]);
            },
        ])->findOrFail($id);

        return view('users.registrar.student.form-137', compact('student'));
    }

    /**
     * Export filtered students
     */
    public function export(Request $request)
    {
        return redirect()->route('registrar.students.index')
            ->with('info', 'Export functionality coming soon');
    }
}
